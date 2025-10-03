<?php
    class settingsmodel{
        private function logger($type, $function, $content){
            include "app/system/connect.php";
            //Throw the error log against the wall, hope it sticks
            $log = $conn->prepare("INSERT INTO logs (type, function, message) VALUES (?, ?, ?)");
            $log->bind_param("iss", $type, $function, $content);
            $log->execute();
        }


        public function savechanges(){
            //Handles user changes
            //Echoes appropriate message back to XHR

            include "app/system/connect.php";
            
            //Using userid from SESSION and data from userdetailfactory
            $username = $_SESSION['username'];
            $userid = $_COOKIE['postpad_uid'];

            //Querying old password to see if it matches
            $oldStuffQuery = $conn->query("SELECT displayname, email, birthday, pfppath, bio, website, privateprofile, timezone FROM users WHERE id = {$userid}");
            $oldStuff = $oldStuffQuery->fetch_assoc();

            
            $displayname = $_POST['displayname'];
            $profilePicture = NULL;

            if(isset($_FILES['profilepicture'])){
                $profilePicture = $_FILES['profilepicture'];
            }
            
            $birthday = $_POST['birthday'];
            $bio = mysqli_real_escape_string($conn, $_POST['bio']);
            $website = mysqli_real_escape_string($conn, $_POST['website']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $oldpw = $_POST['currentpass'];
            $newpw = "";
            if(isset($_POST['newpass'])){
                $newpw = $_POST['newpass'];
            }
            

            $password_change = false;
            $pfp_change = false;
            $email_change = false; //Will be used for further functionality
            $pfppath = "";
            

            
            //If this is true, we can proceed
            //Remove unsafe shit from displayname
            $displayname = htmlspecialchars($displayname);
            
            $updateStatements = Array();

            //Processing fields one-by-one, and appending them to the update string
            if($displayname != $oldStuff["displayname"]){
                array_push($updateStatements, "displayname = '{$displayname}'");
            }
            if(($newpw != "") && ($newpw != $oldpw)){
                if($this->passwordcheck($userid, $username, $oldpw)){
                    $newpw = password_hash($newpw, PASSWORD_DEFAULT);
                    array_push($updateStatements, "password = '{$newpw}'");
                    $password_change = true;
                }
                else{
                    //If not, return with appropriate message
                    echo "wrongpw";
                    //Cleaning up
                    unset($displayname);
                    unset($birthday);
                    unset($bio);
                    unset($website);
                    unset($email);
                    unset($oldpw);
                    unset($newpw);
                    $conn->close();
                    die();
                }
            }
            if($email != $oldStuff['email']){
                array_push($updateStatements, "email = '{$email}'");
                $email_change = true;
            }
            if($birthday != $oldStuff['birthday']){
                array_push($updateStatements, "birthday = '{$birthday}'");
            }
            if($bio != $oldStuff['bio']){
                array_push($updateStatements, "bio = '{$bio}'");
            }
            if($website != $oldStuff['website']){
                array_push($updateStatements, "website = '{$website}'");
            }
            if($profilePicture != NULL){
                $pfppath = $this->pfpchange($profilePicture, $oldStuff["pfppath"]);
                if($pfppath != false){
                    $pfp_change = true;
                }
                else{
                    //If the pfpchange function fails, it could be caused by a serious error, so we cancel the update activity
                    //Cleaning up
                    unset($displayname);
                    unset($profilePicture);
                    unset($birthday);
                    unset($bio);
                    unset($website);
                    unset($email);
                    unset($oldpw);
                    unset($newpw);
                    $conn->close();
                    return;
                }
            }
            if($pfp_change){
                array_push($updateStatements, "pfppath = '{$pfppath}'");
            }
            
            $userUpdateString = "UPDATE users SET " . implode(", ", $updateStatements) . " WHERE id = {$userid}";

            //Actually updating user content
            if($updateUser = $conn->query($userUpdateString)){
                if($password_change){
                    echo "pwchgok";
                    //Cleaning up
                    unset($displayname);
                    unset($profilePicture);
                    unset($birthday);
                    unset($bio);
                    unset($website);
                    unset($email);
                    unset($oldpw);
                    unset($newpw);
                    $conn->close();

                    //Invalidate every session
                    $this->logouteverysession();

                    return;
                }
                else{
                    echo "updateok";
                    //Cleaning up
                    unset($displayname);
                    unset($profilePicture);
                    unset($birthday);
                    unset($bio);
                    unset($website);
                    unset($email);
                    unset($oldpw);
                    unset($newpw);
                    $conn->close();
                    return;
                }
            } 
        }
        private function pfpchange($profilePicture, $oldPfpPath){
            if($profilePicture != NULL && $profilePicture['error'] === UPLOAD_ERR_OK){
                //Processing new pfp
                $fileType = $profilePicture['type'];
                $fileSize = $profilePicture['size'];
                
                $allowedTypes = Array('image/jpeg', 'image/png', 'image/gif');

                if(in_array($fileType, $allowedTypes)){
                    $maxFileSize = 1024 * 1024; //Max 1MB

                    if($fileSize <= $maxFileSize){
                        $tmpPath = $profilePicture['tmp_name'];
                        $imageData = file_get_contents($tmpPath);
                        $imageInfo = getimagesizefromstring($imageData);

                        if($imageInfo[0] <= 500 && $imageInfo[1] <= 500){
                            //Everything fits, move profile picture to its final destination
                            // Define the directory where you want to store the uploaded files
                            $targetDirectory = "/public/res/img/pfps/";

                            // Generate a unique name for the uploaded file
                            $uniqueFilename = uniqid() . "_" . $profilePicture['name'];

                            // Construct the target path for the uploaded file
                            $targetFilePath = $targetDirectory . $uniqueFilename;

                            // Move the uploaded file to the target directory
                            if (move_uploaded_file($tmpPath, SITE_ROOT . $targetFilePath)) {
                                //Delete the old pfp from the server
                                unlink(SITE_ROOT . $oldPfpPath);

                                //When finished, return the new pfp
                                return $targetFilePath;
                            } else {
                                echo "imguploadinternal";
                                return false;
                            }
                        }
                        else{
                            echo "imgtoolarge";
                            return false;
                        }
                    }
                    else{
                        echo "filesizetoobig";
                        return false;
                    }
                }
                else{
                    echo "invalidimgtype";
                    return false;
                }
            }
            else{
                echo "imgUploadError";
                return false;
            }
        }

        public function getnewprofilepic(){
            $userid = $_COOKIE["postpad_uid"];
            $oldpfp = $_POST["oldpfp"];
            include "app/system/connect.php";
            
            $newpfpq = $conn->prepare("SELECT pfppath FROM users WHERE id = ?");
            $newpfpq->bind_param("i", $userid);

            $newpfpq->execute();
            $result = $newpfpq->get_result();

            $newpfp = $result->fetch_assoc()["pfppath"];

            if($oldpfp == $newpfp){
                echo "nochange";
                unset($newpfp);
                unset($result);
                unset($newpfpq);
                unset($oldpfp);
                unset($userid);
                return;
            }
            else{
                echo $newpfp;
                unset($newpfp);
                unset($result);
                unset($newpfpq);
                unset($oldpfp);
                unset($userid);
                return;
            }
        }

        //START Code required for session management:

        function getBrowserInfo($userAgent) {
            // List of common browsers and their user agent identifiers
            $browsers = [
                ['name' => 'Chrome', 'identifier' => 'Chrome'],
                ['name' => 'Firefox', 'identifier' => 'Firefox'],
                ['name' => 'Edge', 'identifier' => 'Edge'],
                ['name' => 'Safari', 'identifier' => 'Safari'],
                ['name' => 'Opera', 'identifier' => 'OPR'],
                // Add more browsers and identifiers as needed
            ];

            $deviceTypes = [
                ['name' => 'Desktop', 'identifier' => 'Desktop'],
                ['name' => 'Windows Desktop', 'identifier' => 'Windows NT'],
                ['name' => 'Linux Desktop', 'identifier' => 'Linux x86_64'],
                ['name' => 'Mac', 'identifier' => 'Macintosh'],
                ['name' => 'Other Smartphone', 'identifier' => 'Mobile'],
                ['name' => 'Android', 'identifier' => 'Android'],
                ['name' => 'iPhone', 'identifier' => 'iPhone'],
                ['name' => 'Windows Phone', 'identifier' => 'Windows Phone'],
            ];
        
            $deviceType = 'Desktop';

            foreach ($deviceTypes as $types) {
                if (strpos($userAgent, $types['identifier']) !== false) {
                    $deviceType = $types["name"];
                }
            }
        
            foreach ($browsers as $browser) {
                if (strpos($userAgent, $browser['identifier']) !== false) {
                    return $browser['name'] . ' (' . $deviceType . ')';
                }
            }
        
            // If no known browser is detected, return the full user agent and device type
            return $userAgent . ' (' . $deviceType . ')';
        }

        public function queryactivesessions(){
            include "app/system/connect.php";
            $userid = $_COOKIE['postpad_uid'];
            $sessionid = $_COOKIE['postpad_sessionid'];
    
            //Query active logins
            $sessionsQ = $conn->prepare("SELECT id, agent, logintimestamp, sessionid FROM userlogins WHERE userid = ?");
            $sessionsQ->bind_param("i", $userid);

            $sessionsQ->execute();

            $result = $sessionsQ->get_result();
            if($result->num_rows > 0){
                while($details = $result->fetch_assoc()){
                    //Convert timestamp to UTC time
                    $real_time = date('Y-m-d H:i:s', $details['logintimestamp']);
                    $formattedAgent = $this->getBrowserInfo($details["agent"]);
                    $sessiondbid = $details["id"];

                    if($details["sessionid"] == $sessionid){
                        echo "<tr><td>{$formattedAgent}</td><td>{$real_time} UTC</td><td><i>None (Current session)</i></td></tr>";
                    }
                    else{
                        echo "<tr><td>{$formattedAgent}</td><td>{$real_time} UTC</td><td><button class='btn btn-sm btn-danger' onclick='logoutSession({$sessiondbid})'>Log out session</button></td></tr>";
                    }
                }
            }
            else{
                echo "<tr><td><i>No active sessions (This shouldn't happen btw...)</i></td></tr>";
            }
        }

        public function logoutsession(){
            include "app/system/connect.php";

            $dropsessionid = $_POST['sessionid'];

            $removesession = $conn->prepare("DELETE FROM userlogins WHERE id = ?");
            $removesession->bind_param("i", $dropsessionid);
            if($removesession->execute()){
                echo "ok";
            }
            else{
                $this->logger(2, "model/usermanager.php/logouteverysession()", "Failed to remove rows from userlogins: " . $conn->error);
                echo "error";
            }

            unset($dropsessionid);
            unset($removesession);
            return;
        }

        public function logouteverysession($uidinternal = ""){
            include "app/system/connect.php";

            if($uidinternal == ""){
                $userid = $_COOKIE['postpad_uid'];
            }
            else{
                $userid = $uidinternal;
            }
            
            $sessionid = $_COOKIE['postpad_sessionid'];

            //Remove every active session EXCEPT current, so we can log out properly after
            $removesessions = $conn->prepare("DELETE FROM userlogins WHERE userid = ? AND sessionid <> ?");
            $removesessions->bind_param("is", $userid, $sessionid);
            if($removesessions->execute()){
                echo "ok";
            }
            else{
                $this->logger(2, "model/usermanager.php/logouteverysession()", "Failed to remove rows from userlogins: " . $conn->error);
                echo "error";
            }

            unset($userid);
            unset($sessionid);
            unset($removesessions);
            return;
        }

        //END Code required for session management
    }
?>