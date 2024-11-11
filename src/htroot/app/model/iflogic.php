<?php
    class iflogic{
        public function accessCheck(){
            //Check if appropriate "header" info has been send, otherwise do nothing
            if(isset($_POST["appid"]) && isset($_POST["appname"]) && isset($_POST["accesskey"])){
                include "app/system/connect.php";
                $checkAccess = $conn->prepare("SELECT id FROM apikeys WHERE appid = ? AND appname = ? AND accesskey = ?");
                $checkAccess->bind_param("sss", $_POST["appid"], $_POST["appname"], $_POST["accesskey"]);
                
                $checkAccess->execute();
                $result = $checkAccess->get_result();
                if($result->num_rows == 0){
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                return false;
            }
        }
    }
?>