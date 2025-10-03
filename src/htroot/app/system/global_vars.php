<?php
    define("APP_VERSION", "0.13.0");
    define("APP_NAME", "PostPad");

    //Use this variable to determine if you're working on a devbuild or not
    define("DEV", true);

    //This variable determines if the app is currently in "invite only" mode
    define("INVITE_ONLY", true);

    if(DEV){
        //Dev mail
        define("MAIL_NAME", "PostPad Test Mailing System");
        define("MAIL_USER", "noreply.test@postpad.eu");
        define("MAIL_PASS", "rmyqCwJDP9#");

        //Other global vars can come here if necessary
    }
    else{
        //Define live mailing system when we have it
        define("MAIL_NAME", "");
        define("MAIL_USER", "");
        define("MAIL_PASS", "");

        //Other global vars can come here if necessary
    }
?>