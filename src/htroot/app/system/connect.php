<?php
    //Testing
    $conn = new mysqli("postpad-db", "root", "root", "postpad", "3306");
    
    //Prod
    //

    //This is to ensure emojis and such will work
    $conn->set_charset('utf8mb4');

    // Check connection
    if ($conn -> connect_errno) {
        echo "Failed to connect to database: " . $conn -> connect_error;
        exit();
    }
?>