<?php
class userdetailfactory{
    private function logger($type, $function, $content){
        include "app/system/connect.php";
        //Throw the error log against the wall, hope it sticks
        $log = $conn->prepare("INSERT INTO logs (type, function, message) VALUES (?, ?, ?)");
        $log->bind_param("iss", $type, $function, $content);
        $log->execute();
    }
    //This class puts certain user data into SESSION storage, so we don't have to query every damn time
    //Since sessions get invalidated after the browser tab is closed, we don't have to worry about info leaking
    public function setuserdata(){
        //This function will only run after login, so the user ID is already set in a cookie
        session_start();
        include "app/system/connect.php";
        $userid = $_COOKIE['postpad_uid'];

        //Getting the user data we want
        //username, displayname, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, privateprofile, timezone
        $userdata = $conn->prepare("SELECT username, displayname, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, privateprofile, timezone FROM users WHERE id = ?");
        $userdata->bind_param("i", $userid);

        $userdata->execute();
        $userdata->bind_result($username, $displayname, $userstaff, $verified, $developer, $patron, $pfppath, $privateprofile, $timezone);
        $userdata->store_result();
        $userdata->fetch();


        $_SESSION['username'] = $username;
        $_SESSION['displayname'] = $displayname;
        $_SESSION['isuserstaff'] = $userstaff;
        $_SESSION['isuserverified'] = $verified;
        $_SESSION['isuserdeveloper'] = $developer;
        $_SESSION['isuserpatron'] = $patron;
        $_SESSION['pfppath'] = $pfppath;
        $_SESSION['privateprofile'] = $privateprofile;
        $_SESSION['timezone'] = $timezone;
    }

    public function getdataforsettings(){
        //This function will only run after login, so the user ID is already set in a cookie
        include "app/system/connect.php";
        $userid = $_COOKIE['postpad_uid'];

        //Getting the data we want
        $userFullData = $conn->prepare("SELECT username, displayname, email, birthday, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, bio, website, privateprofile, timezone FROM users WHERE id = ?");
        $userFullData->bind_param("i", $userid);
        $userFullData->execute();
        $result = $userFullData->get_result();
        $userDataForSettings = $result->fetch_assoc();

        return $userDataForSettings;
    }
}
?>