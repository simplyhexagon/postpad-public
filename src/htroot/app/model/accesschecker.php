<?php
    class accesschecker{
        
        private function logger($type, $function, $content){
            include "app/system/connect.php";
            //Throw the error log against the wall, hope it sticks
            $log = $conn->prepare("INSERT INTO logs (type, function, message) VALUES (?, ?, ?)");
            $log->bind_param("iss", $type, $function, $content);
            $log->execute();
        }

        public function check($sessionid){
            include "app/system/connect.php";

            $sessionLookup = $conn->prepare("SELECT id FROM userlogins WHERE sessionid = ?");
            $sessionLookup->bind_param("s", $sessionid);

            if($sessionLookup->execute()){
                $result = $sessionLookup->get_result();
                if($result->num_rows > 0){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }            
        }
    }
?>