<?php
    class announcementModel{
        public function test(){
            $test = Array(
                "title" => "Test Title",
                "content" => "Test Content",
                "timestamp" => 1707137102
            );

            return $test;
        }

        public function getLatest(){
            include "app/system/connect.php";
            $detailsQ = $conn->query("SELECT id, title, invalid FROM announcements WHERE id > 0 ORDER BY id DESC LIMIT 1");
            $returnArray = Array();
            if($detailsQ->num_rows > 0){
                $details = $detailsQ->fetch_assoc();
                if($details["invalid"] != 1){
                    $returnArray = Array( "status" => "success" ) + $details;
                }
                else{
                    $returnArray = Array( "status" => "latestInvalid" );
                }
            }
            else{
                $returnArray = Array( "status" => "error", "errormsg" => $conn->error );
            }
            $returnString = json_encode($returnArray);
            echo $returnString;
            
        }

        public function getDetails($announceid){
            include "app/system/connect.php";

            $values = Array();
            $currentTime = time();

            $detailsQ = $conn->prepare("SELECT title, content, timestamp, invalid FROM announcements WHERE id = ?");
            $detailsQ->bind_param("i", $announceid);

            if($detailsQ->execute()){
                $result = $detailsQ->get_result();
                if($result->num_rows == 0){
                    $values = Array(
                        "title" => "Error",
                        "content" => "We couldn't find an announcement with this ID",
                        "timestamp" => $currentTime,
                        "invalid" => 0
                    );
                }
                else{
                    $valuesQ = $result->fetch_assoc();
                    $values = Array(
                        "title" => $valuesQ["title"],
                        "content" => $valuesQ["content"],
                        "timestamp" => $valuesQ["timestamp"],
                        "invalid" => $valuesQ["invalid"]
                    );
                }
            }
            else{
                $values = Array(
                    "title" => "Error",
                    "content" => "Failed to retrieve announcement data",
                    "timestamp" => $currentTime,
                    "invalid" => 0
                );
            }

            return $values;
        }
    }
?>