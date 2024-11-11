<?php
    class searchmodel{
        public function usersearch(){
            try{
                include "app/system/connect.php";
                $username = $_POST["q"];
                $response = Array(
                    "response" => "empty"
                );

                //pre-query checks
                if(strlen($username) <= 3){
                    $response = Array(
                        "response" => "error",
                        "message" => "tooshort"
                    );
                    echo json_encode($response);
                    return;
                }

                //id, username, displayname, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, privateprofile

                $userq = $conn->prepare("SELECT id, username, displayname, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, privateprofile FROM users WHERE username LIKE CONCAT('%', ?, '%')");
                $userq->bind_param("s", $username);

                $userq->execute();

                // Bind the results to variables
                $userq->bind_result($id, $username, $displayname, $isuserstaff, $isuserverified, $isuserdeveloper, $isuserpatron, $pfppath, $privateprofile);

                // Initialize an array to store the user data
                $userList = array();

                // Fetch and store the results
                if ($userq->fetch()) {
                    do {
                        // Create an associative array to store the user data
                        $currentQueriedUser = array(
                            "id" => $id,
                            "username" => $username,
                            "displayname" => $displayname,
                            "isuserstaff" => $isuserstaff,
                            "isuserverified" => $isuserverified,
                            "isuserdeveloper" => $isuserdeveloper,
                            "isuserpatron" => $isuserpatron,
                            "pfppath" => $pfppath,
                            "privateprofile" => $privateprofile
                        );

                        // Encode the current user's data into JSON
                        $currentQueriedUserJSON = json_encode($currentQueriedUser);

                        // Append the user's JSON data to the userList array
                        $userList["user$id"] = $currentQueriedUserJSON;
                    } while ($userq->fetch());

                    // Close the statement
                    $userq->close();

                    // Encode the userList array into JSON
                    $userListJSON = json_encode($userList);

                    // Output the userList JSON

                    //echo $userListJSON;
                    $response = Array(
                        "response" => "success",
                        "users" => $userListJSON
                    );
                } else {
                    $response = Array(
                        "response" => "success",
                        "message" => "nousers"
                    );
                }
            }
            catch(Exception $e){
                $response = Array(
                    "response" => "error",
                    "message" => "An error occured\n" . $e->getMessage()
                );

                
            }
            echo json_encode($response);
        }

        public function postsearch(){
            include "app/system/connect.php";
            $searchquery = $_POST["q"];
        }
    }
?>