<?php
    class signupmodel{
        private function logger($type, $function, $content){
            include "app/system/connect.php";
            //Throw the error log against the wall, hope it sticks
            $log = $conn->prepare("INSERT INTO logs (type, function, message) VALUES (?, ?, ?)");
            $log->bind_param("iss", $type, $function, $content);
            $log->execute();
        }
        
        public function usersignup(){
            /*
            Array
            (
                [action] => usersignup
                [email] => test@test.com
                [username] => testuser
                [password] => TestTest123-
            )
            */
            include "app/system/connect.php";

            $username_taken = true;
            $email_taken = true;

            //Check if email address is free
            $emailcheck = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $emailcheck->bind_param("s", $_POST['email']);
            if($emailcheck->execute()){
                $emailcheck->store_result();
                if($emailcheck->num_rows == 0)
                    $email_taken = false;
            }

            //Checking if username is taken
            $usernamecheck = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $usernamecheck->bind_param("s", $_POST['username']);
            if($usernamecheck->execute()){
                $usernamecheck->store_result();
                if($usernamecheck->num_rows == 0){
                    $username_taken = false;
                }
            }

            if(!$username_taken && !$email_taken){
                //Inserting user into DB
                $newuser = $conn->prepare("INSERT INTO users (username, displayname, password, email, birthday, signupday) VALUES (?, ?, ?, ?, ?, ?)");
                $today = date("Y-m-d");
                //Encode password
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                //Assemble query with values
                $newuser->bind_param("ssssss", $_POST['username'], $_POST['username'], $password, $_POST['email'], $_POST['birthday'], $today);

                if($newuser->execute()){
                    echo "ok";
                }
                else{
                    echo $conn->error;
                }
            }
            else if($username_taken){
                echo "username taken";
            }
            else if($email_taken){
                echo "email taken";
            }
            else{
                echo "general error";
            }
        }
    }
?>