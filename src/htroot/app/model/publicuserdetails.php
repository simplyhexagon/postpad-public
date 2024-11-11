<?php
    class publicuserdetails{
        private function logger($type, $function, $content){
            include "app/system/connect.php";
            //Throw the error log against the wall, hope it sticks
            $log = $conn->prepare("INSERT INTO logs (type, function, message) VALUES (?, ?, ?)");
            $log->bind_param("iss", $type, $function, $content);
            $log->execute();
        }

        private function uidfromuname($username){
            //This function returns the User ID from specified username
            include "app/system/connect.php";
            $getuid = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $getuid->bind_param("s", $username);

            $getuid->execute();
            $result = $getuid->get_result();

            $uid = $result->fetch_assoc()["id"];
            unset($result);
            unset($getuid);
            return $uid;
        }
        
        public function compileUserProfile($username){
            // This function compiles the relevant information to display in the
            // user's profile header when visiting their /user/* page
            include "app/system/connect.php";

            //Querying relevant info
            //username, displayname, birthday, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, signupday, bio, website, privateprofile, timezone
            $username = htmlspecialchars($username, ENT_QUOTES, "UTF-8");


            $userdetails = $conn->prepare("SELECT username, displayname, birthday, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, signupday, bio, website, privateprofile, timezone FROM users WHERE username = ?");
            $userdetails->bind_param("s", $username);
            if($userdetails->execute()){

                $result = $userdetails->get_result();
                
                if($result->num_rows > 0){
                    $userdata = $result->fetch_assoc();
                    return $userdata;
                }
                else{
                    $error = Array(
                        "username" => "Empty"
                    );
    
                    return $error;
                }
                $userdetails->close();
            }
            else{
                $error = Array(
                    "username" => "Error"
                );

                return $error;
            }
        }

        public function getprofilecounters($username){
            //This function collects the data necessary to display the counters
            include "app/system/connect.php";

            $uid = $this->uidfromuname($username);

            //Get post counter
            $getpostcount = $conn->prepare("SELECT count(id) AS postcount FROM posts WHERE posting_user = ?");
            $getpostcount->bind_param("i", $uid);
            $getpostcount->execute();
            $result = $getpostcount->get_result();

            $postcount = $result->fetch_assoc()["postcount"];

            //Get follower count
            $getfollowercount = $conn->prepare("SELECT count(id) AS followercount FROM follows WHERE followed = ?");
            $getfollowercount->bind_param("i", $uid);
            $getfollowercount->execute();
            $result = $getfollowercount->get_result();

            $followercount = $result->fetch_assoc()["followercount"];

            //Get followed count
            $getfollowedcount = $conn->prepare("SELECT count(id) AS followedcount FROM follows WHERE follower = ?");
            $getfollowedcount->bind_param("i", $uid);
            $getfollowedcount->execute();
            $result = $getfollowedcount->get_result();

            $followedcount = $result->fetch_assoc()["followedcount"];

            $data = Array(
                "postcount" => $postcount,
                "followercount" => $followercount,
                "followedcount" => $followedcount
            );

            return $data;
        }

        public function getfollowslist(){

        }

        public function getfollowerlist(){
            
        }
    }
?>