<?php
    //This class will handle most of the things user related
    class usermanager{
        private function logger($type, $function, $content){
            include "app/system/connect.php";
            //Throw the error log against the wall, hope it sticks
            $log = $conn->prepare("INSERT INTO logs (type, function, message) VALUES (?, ?, ?)");
            $log->bind_param("iss", $type, $function, $content);
            $log->execute();
        }

        private function userlookup($username){
            //Scan DB to see if user exists
            //Returns user id if true, otherwise returns false
            include "app/system/connect.php";
            if($userlookup = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 0, 1")){
                $userlookup->bind_param("s", $username);
                if($userlookup->execute()){
                    $userlookup->bind_result($userid);
                    $userlookup->store_result();
                    $userlookup->fetch();
                    return $userid;
                }
                else{
                    echo $conn->error;
                    return false;
                }
            }
            else{
                return false;
            }
        }

        private function passwordcheck($id, $username, $password){
            include "app/system/connect.php";
            //Returns true if password is correct, otherwise, returns false
            if($passwordcheck = $conn->prepare("SELECT password FROM users WHERE id = ? AND username = ? LIMIT 0, 1")){
                $passwordcheck->bind_param("is", $id, $username);
                $passwordcheck->execute();
                
                $passwordcheck->bind_result($passwordhash);
                $passwordcheck->store_result();
                $passwordcheck->fetch();
                return password_verify($password, $passwordhash);
            }
            else{
                return false;
            }
        }

        private function bancheck($uid){
            //Returns true if user is banned, otherwise returns false
            include "app/system/connect.php";
            if($bancheck = $conn->prepare("SELECT id FROM bans WHERE userid = ?")){
                $bancheck->bind_param("i", $uid);
                $bancheck->execute();
                $bancheck->store_result();
                $bancheck->fetch();
                if($bancheck->num_rows > 0){
                    return true;
                }
                else{
                    return false;
                }
            }
        }


        public function signin(){
            /*
            Possible error messages
            - "wrongpw" - user entered a wrong password
            - "nouser"  - user not found
            */
            /*
            Array
            (
                [action] => signin
                [username] => asdasd
                [password] => asdasd
            )
            */
            include "app/system/connect.php";
            $username = $_POST['username'];
            $password = $_POST['password'];

            $uid = $this->userlookup($username);

            if($uid > 0){
                if($this->passwordcheck($uid, $username, $password)){
                    if(!$this->bancheck($uid)){
                        //Setting up user session then letting the user in
                        
                        $agent = $_SERVER['HTTP_USER_AGENT'];

                        $hashstring = $username . $agent . $_SERVER['REMOTE_ADDR'];
                        

                        $sessionid = hash('sha512', $hashstring);

                        

                        //Inserting session ID into database
                        if($sessioninsert = $conn->prepare("INSERT INTO userlogins (userid, devicetype, agent, sessionid, logintimestamp) VALUES (?, ?, ?, ?, ?)")){
                            $timestamp = time();
                            $devicetype = 0;
                            $sessioninsert->bind_param("iissi", $uid, $devicetype, $agent, $sessionid, $timestamp);
                            if($sessioninsert->execute()){
                                //Login valid, preparing user session and liftoff
                                setcookie("postpad_uid", $uid, time() + 86400, "/");
                                setcookie("postpad_sessionid", $sessionid, time() + 86400, "/");
                                echo "ok";
                            }
                            else{
                                echo "sessionfail";
                                unset($timestamp);
                                unset($sessioninsert);
                                unset($sessionid);
                                unset($hashstring);
                                unset($agent);
                                die();
                            }
                        }
                        else{
                            echo "sessionfail";
                            unset($sessionid);
                            unset($hashstring);
                            unset($agent);
                            die();
                        }
                    }
                    else{
                        echo "ban";
                        unset($username);
                        unset($password);
                        die();
                    }
                }
                else{
                    echo "wrongpw";
                    unset($username);
                    unset($password);
                    die();
                }
            }
            else{
                echo "nouser";
                unset($username);
                unset($password);
                die();
            }
        }

        public function signout(){
            include "app/system/connect.php";
            $sessionid = $_COOKIE['postpad_sessionid'];

            //Invalidating the session in the DB
            if($delsession = $conn->query("DELETE FROM userlogins WHERE sessionid = '{$sessionid}'")){
                setcookie("postpad_uid", "", time() - 1, "/");
                setcookie("postpad_sessionid", $sessionid, time() - 1, "/");

                //Deleting user data set by userdetailfactory
                session_destroy();

                header("Location: /");
            }
            else{
                echo "<p>We couldn't log you out</p>";
            }
        }

        public function autologin(){
            include "app/system/connect.php";
            if(isset($_COOKIE['postpad_sessionid'])){
                $sessionid = $_COOKIE['postpad_sessionid'];
                //Looking up session
                if($searchsession = $conn->prepare("SELECT id, logintimestamp FROM userlogins WHERE sessionid = ?")){
                    $searchsession->bind_param("s", $sessionid);
                    if($searchsession->execute()){
                        $searchsession->bind_result($session_dbid, $logintimestamp);
                        $searchsession->store_result();
                        $searchsession->fetch();

                        //Is session still valid?
                        $currenttime = time();
                        $invalidtime = $logintimestamp + 86400;
                        if($currenttime < $invalidtime){
                            //Session valid
                            echo "ok";
                        }
                        else{
                            //Invalidate session
                            $delsession = $conn->query("DELETE FROM userlogins WHERE id = '{$session_dbid}'");
                            setcookie("postpad_uid", "", time() - 1, "/");
                            setcookie("postpad_sessionid", $sessionid, time() - 1, "/");
                            echo "invalid_session";
                        }
                    }
                    else{
                        echo "nosession";
                    }
                }
            }
            else{
                echo "nosession";
            }
        }
    }
?>