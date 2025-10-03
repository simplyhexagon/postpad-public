<?php
    class postmanager{
        private function logger($type, $function, $content){
            include "app/system/connect.php";
            //Throw the error log against the wall, hope it sticks
            $log = $conn->prepare("INSERT INTO logs (type, function, message) VALUES (?, ?, ?)");
            $log->bind_param("iss", $type, $function, $content);
            $log->execute();
        }

        public function fillPosts(){
            if(is_numeric($_POST['offset']) && $_POST['offset'] >= 0){
                $offset = intval($_POST['offset']);
                $maxvalue = $offset + 20;

                //Real post query
                include "app/system/connect.php";

                //id, type, posting_user, sharecount, reblogs, views, timestamp
                $postquerystring = "SELECT id, type, posting_user, content, sharecount, reblogs, views, timestamp, cw_general, cw_nsfw FROM posts WHERE id > 0 AND reply_to IS NULL ORDER BY id DESC LIMIT {$maxvalue} OFFSET {$offset} ";
                //Checking if we are browsing a user's /user/* site
                //If so, get their user ID
                if(isset($_POST['user'])){
                    $userq = $conn->prepare("SELECT id FROM users WHERE username = ?");
                    $userq->bind_param("s", $_POST['user']);
                    $userq->execute();
                    $result = $userq->get_result();
                    $user = $result->fetch_assoc();
                    
                    $postquerystring = "SELECT id, type, posting_user, content, sharecount, reblogs, views, timestamp, cw_general, cw_nsfw FROM posts WHERE id > 0 AND posting_user = {$user["id"]} ORDER BY id DESC LIMIT {$maxvalue} OFFSET {$offset} ";
                }

                if($postq = $conn->query($postquerystring)){
                    if($postq->num_rows > 0){
                        //We have posts!!!

                        //Query post content
                        while($postqr = $postq->fetch_assoc())
                        {
                            //Query info about the user to compose post content
                            //Not quite secure, TODO: make it more secure, fail safe
                            $uid = $postqr['posting_user'];
                            $userq = $conn->query("SELECT id, username, displayname, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath FROM users WHERE id = {$uid}");
                            $userdata = $userq->fetch_assoc();

                            $postid = $postqr['id'];

                            $commentcount = $this->getcommentcount($postid);
                            $posttime = date('Y-m-d H:i:s', $postqr['timestamp']);

                            $realpostcontent = $postqr['content'];

                            //Look for hyperlink elements, add the "hyperlinkOverride" class to them
                            $aPosition = strpos($realpostcontent, "<a ");
                            if($aPosition !== false){
                                $modifiedString = substr_replace($realpostcontent, " class='hyperlinkOverride' ", $aPosition + 2, 0);
                                $realpostcontent = $modifiedString;
                            }


                            //COMPOSING THE POST
                            //This is the post itself
                            echo "
                                <div class='card postpad-post'>
                                    <div class='card-header'>
                                        <div class='row'>
                                            <div class='col-12'>
                                                <table>
                                                    <tr>
                                                        <td rowspan='2' >
                                                            <a href='/user/{$userdata['username']}'>                                                            
                                                            <img height='50vh' class='postpad-post-img-image' src='{$userdata['pfppath']}'>
                                                            </a>
                                                        </td>
                                                        <td width='20px'>

                                                        </td>
                                                        <td >
                                                            <a href='/user/{$userdata['username']}'>
                                                                <strong>{$userdata['displayname']}</strong>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td width='20px'>

                                                    </td>
                                                        <td>
                                                            <a href='/user/{$userdata['username']}'>
                                                                <small><i>@{$userdata['username']}</i></small>
                                                            </a>
                                                        </td>
                                                        
                                                    </tr>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>";
                                    if($postqr["cw_general"] == 0 && $postqr["cw_nsfw"] == 0)
                                    {
                                        echo "
                                        <a href='/post/{$postid}'>
                                        <div class='card-body postpad-cardBody'>
                                            <hr>
                                            <div class='postpad-text'>
                                                <p>
                                                {$realpostcontent}
                                                </p>
                                            </div>
                                        </div>
                                        </a>";
                                    }
                                    else if($postqr["cw_nsfw"] == 1 && $postqr["cw_general"] == 0){
                                        echo "<div class='card-body postpad-cardBody postpad-blurredPostContainer'>
                                            <hr>
                                            <div class='postpad-text postpad-blurredPost'>
                                                <a href='/post/{$postid}'>
                                                    <p>
                                                    {$realpostcontent}
                                                    </p>
                                                </a>  
                                            </div>
                                            <div id='postBlurOverlay{$postid}' class='postpad-text postpad-blurOverlay'>
                                                <div class='postBlurOverlayContent text-center justify-content-center'>
                                                    <p><i><strong>This post was marked as Not Safe For Work</strong></i></p>
                                                    <p><button onclick='unblurPost({$postid})' class='btn btn-sm btn-secondary'>Show post content</button></p>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                    else{
                                        echo "<div class='card-body postpad-cardBody postpad-blurredPostContainer'>
                                            <hr>
                                            <div class='postpad-text postpad-blurredPost'>
                                                <a href='/post/{$postid}'>
                                                    <p>
                                                    {$realpostcontent}
                                                    </p>
                                                </a>  
                                            </div>
                                            <div id='postBlurOverlay{$postid}' class='postpad-text postpad-blurOverlay'>
                                                <div class='postBlurOverlayContent text-center justify-content-center'>
                                                    <p><i><strong>This post has a content warning</strong></i></p>
                                                    <p><button onclick='unblurPost({$postid})' class='btn btn-sm btn-secondary'>Show post content</button></p>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                    echo "<div class='card-footer'>
                                        <div class='row'>
                                            <div class='col-xs-12 col-lg-12 text-left'>
                                                <small><i>{$posttime} GMT</i></small>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class='row text-center'>
                                            <div class='col-3'>
                                                <a href='/post/{$postid}#comments'><i class='fa-solid fa-comment'></i> {$commentcount}</a>
                                            </div>
                                            <div class='col-3'>
                                                <i class='fa-solid fa-retweet'></i>
                                            </div>
                                            <div class='col-3'>
                                                <i class='fa-solid fa-heart'></i>
                                            </div>
                                            <div class='col-3'>
                                                <i id='sharebutton{$postid}' data-toggle='tooltip' data-placement='top' title='Copy Link to Clipboard' onclick='share({$postid});' class='fa-solid fa-share-nodes sharebutton'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";

                        }
                    }
                    else if($postq->num_rows == 0 && isset($_POST['user']) && $offset == 0){
                        echo "noposts";
                    }
                    else{
                        //We don't have posts
                        //This shouldn't happen in prod
                        echo "nomoreposts";
                    }
                }
                else{
                    echo "internalerror";
                }
            }
        }

        public function fillPosts_API(){
            $composedReply = Array();
            if(is_numeric($_POST['offset']) && $_POST['offset'] >= 0){
                $offset = intval($_POST['offset']);
                $maxvalue = $offset + 20;

                //Real post query
                include "app/system/connect.php";

                //id, type, posting_user, sharecount, reblogs, views, timestamp
                $postquerystring = "SELECT id, type, posting_user, content, sharecount, reblogs, views, timestamp, cw_general, cw_nsfw, reply_to FROM posts WHERE id > 0 ORDER BY id DESC LIMIT {$maxvalue} OFFSET {$offset} ";
                //Checking if we are browsing a user's /user/* site
                //If so, get their user ID
                if(isset($_POST['user'])){
                    $userq = $conn->prepare("SELECT id FROM users WHERE username = ?");
                    $userq->bind_param("s", $_POST['user']);
                    $userq->execute();
                    $result = $userq->get_result();
                    $user = $result->fetch_assoc();
                    
                    $postquerystring = "SELECT id, type, posting_user, content, sharecount, reblogs, views, timestamp, cw_general, cw_nsfw, reply_to FROM posts WHERE id > 0 AND posting_user = {$user["id"]} ORDER BY id DESC LIMIT {$maxvalue} OFFSET {$offset} ";
                }

                if($postq = $conn->query($postquerystring)){
                    if($postq->num_rows > 0){
                        //We have posts!!!

                        //Query post content
                        $composedReply = Array(
                            "response" => "ok"
                        );
                        $postList = Array();

                        while($postqr = $postq->fetch_assoc())
                        {
                            
                            //Query info about the user to compose post content
                            //Not quite secure, TODO: make it more secure, fail safe
                            $uid = $postqr['posting_user'];
                            $userq = $conn->query("SELECT id, username, displayname, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath FROM users WHERE id = {$uid}");
                            $userdata = $userq->fetch_assoc();

                            $postid = $postqr['id'];
                            $commentcount = $this->getcommentcount($postid);

                            //"Fix" the thing that hides 0 on the frontend
                            if($commentcount == ""){
                                $commentcount = 0;
                            }

                            $realpostcontent = $postqr['content'];

                            $reply_to = 0;
                            if($postqr["reply_to"] != NULL)
                                $reply_to = $postqr["reply_to"];

                            //COMPOSING THE POST
                            //This is the post itself

                            //Composing PFP path
                            $api_pfppath = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]" . $userdata['pfppath'];
                            $composedPost = Array(
                                "authorid" => "{$uid}",
                                "authoruname" => "{$userdata['username']}",
                                "authordname" => "{$userdata['displayname']}",
                                "authorpfp" => "{$api_pfppath}",
                                "postbody" => "{$realpostcontent}",
                                "timestamp" => "{$postqr['timestamp']}",
                                "commentcount" => "{$commentcount}",
                                "rtcount" => "0",
                                "likecount" => "0",
                                "cw_general" => "{$postqr['cw_general']}",
                                "cw_nsfw" => "{$postqr['cw_nsfw']}",
                                "reply_to" => "{$reply_to}"
                            );

                            $postList = $postList + Array("{$postid}" => $composedPost);
                        }
                        $composedReply = $composedReply + Array("posts" => $postList);
                    }
                    else if($postq->num_rows == 0 && isset($_POST['user']) && $offset == 0){
                        $composedReply = Array(
                            "response" => "error",
                            "error" => "noposts"
                        );
                    }
                    else{
                        //We don't have posts
                        //This shouldn't happen in prod
                        $composedReply = Array(
                            "response" => "error",
                            "error" => "nomoreposts"
                        );
                    }
                }
                else{
                    $composedReply = Array(
                        "response" => "error",
                        "error" => "internalerror"
                    );
                }
                return $composedReply;
            }
        }


        public function newpost($quill = false){
            //This function is to create a new post
            include "app/system/connect.php";

            $userid = $_COOKIE['postpad_uid'];
            $postcontent = $_POST['postcontent'];

            //If we're posting through the Quill input, it should be posttype 1, since it is a long post.
            //We'll handle loading long posts somewhere else
            $posttype = ($quill) ? 1 : 0;

            $cw_general = $_POST["cw_general"];
            $cw_nsfw = $_POST["cw_nsfw"];


            //Removing JavaScript "injection" with the <script> tags and everything in between
            $postcontent = preg_replace("/<script\b[^>]*>(.*?)<\/script>/is", "", $postcontent);

            //Checking if we still have content in the post, even after removing <script>
            if($postcontent == ""){
                echo "fail";
                $this->logger(2, "postmanager/newpost()", "User {$userid} tried to post an empty post! (Probably tried XSS)");
                die();
            }

            if(!$quill){
                //Converting new lines and special chars to HTML tags to preserve formatting
                $postcontent = nl2br(htmlspecialchars($postcontent, ENT_QUOTES, 'UTF-8'));
            }

            $timestamp = time();
            $newpostq = $conn->prepare("INSERT INTO posts (type, posting_user, content, timestamp, cw_general, cw_nsfw) VALUES (?, ?, ?, ?, ?, ?)");
            $newpostq->bind_param("iisiii", $posttype, $userid, $postcontent, $timestamp, $cw_general, $cw_nsfw);

            if($newpostq->execute()){
                //Closing connections, finalising and exiting
                $newpostq->close();
                $conn->close();

                unset($newpostq);
                echo "ok";
                exit();
            }
            else{
                //Everything is burning omg
                $this->logger(2, "postmanager/newpost()", "Failed to create new post: " . $conn->error);
                $newpostq->close();
                $conn->close();

                unset($newpostq);
                echo "fail";
                die();
            }
        }

        public function getpostfull($postid){
            //This function gathers the information to display a post
            include "app/system/connect.php";

            $fullpostA = Array();

            $getfullpost = $conn->prepare("SELECT posts.id AS id, posts.type AS type, posts.posting_user AS posting_user, posts.sharecount AS sharecount, posts.reblogs AS reblogs, posts.views AS views, posts.timestamp AS timestamp, posts.content AS content, posts.reply_to AS reply_to, users.username AS username, users.displayname AS displayname, users.isuserstaff AS isuserstaff, users.isuserverified AS isuserverified, users.isuserdeveloper AS isuserdeveloper, users.isuserpatron AS isuserpatron, users.pfppath AS pfppath, users.privateprofile AS privateprofile FROM posts JOIN users ON posts.posting_user = users.id WHERE posts.id = ?");
            $getfullpost->bind_param("i", $postid);
            $getfullpost->execute();
            $result = $getfullpost->get_result();
            if($result->num_rows == 1){
                $fullpost = $result->fetch_assoc();

                $commentcount = $this->getcommentcount($fullpost["id"]);

                $realpostcontent = $fullpost["content"];
                $aPosition = strpos($realpostcontent, "<a ");
                if($aPosition !== false){
                    $modifiedString = substr_replace($realpostcontent, " class='hyperlinkOverride' ", $aPosition + 2, 0);
                    $realpostcontent = $modifiedString;
                }

                $fullpostA = Array(
                    "id" => $fullpost["id"],
                    "type" => $fullpost["type"],
                    "sharecount" => $fullpost["sharecount"],
                    "reblogs" => $fullpost["reblogs"],
                    "views" => $fullpost["views"],
                    "timestamp" => $fullpost["timestamp"],
                    "username" => $fullpost["username"],
                    "displayname" => $fullpost["displayname"],
                    "isuserstaff" => $fullpost["isuserstaff"],
                    "isuserverified" => $fullpost["isuserverified"],
                    "isuserdeveloper" => $fullpost["isuserdeveloper"],
                    "isuserpatron" => $fullpost["isuserpatron"],
                    "pfppath" => $fullpost["pfppath"],
                    "privateprofile" => $fullpost["privateprofile"],
                    "content" => $realpostcontent,
                    "reply_to" => $fullpost["reply_to"],
                    "commentcount" => $commentcount
                );
                mysqli_free_result($result);
                $conn->close();

                return $fullpostA;
            }
            else{
                return false;
            }
            
        }

        private function getcommentcount($postid){
            if(is_numeric($postid) && $postid > 0){
                include "app/system/connect.php";
                $commentcount = $conn->query("SELECT COUNT(id) AS commentcount FROM posts WHERE reply_to = {$postid}");
                if($commentcount->num_rows == 0){
                    return 0;
                }
                else{
                    $realcommentcount = $commentcount->fetch_assoc()["commentcount"];
                    if($realcommentcount == 0){
                        return "";
                    }
                    else{
                        return $realcommentcount;
                    }
                }
            }
        }

        public function getcomments(){
            $postid = $_POST['postid'];
            $offset = $_POST['offset'];
            if(is_numeric($postid) && $postid > 0){
                include "app/system/connect.php";
        
                $offset = intval($_POST['offset']);
                $maxvalue = $offset + 20;
            
                //comments: userid, timestamp, comment
                //users: username, displayname, isuserstaff, isuserverified, isuserdeveloper, isuserpatron, pfppath, privateprofile
                $querystring = "SELECT posts.id AS commentid, users.username AS username, users.displayname AS displayname, users.isuserstaff AS isuserstaff, users.isuserverified AS isuserverified, users.isuserdeveloper AS isuserdeveloper, users.isuserpatron AS isuserpatron, users.pfppath AS pfppath, users.privateprofile AS privateprofile, posts.timestamp AS timestamp, posts.content AS content FROM posts JOIN users ON posts.posting_user = users.id WHERE posts.reply_to = {$postid} ORDER BY posts.id DESC LIMIT {$maxvalue} OFFSET {$offset}";
                if($getcomments = $conn->query($querystring)){
                    if($getcomments->num_rows > 0){
                        //If we have comments, do the processing
                        while($comments = $getcomments->fetch_assoc()){
                            $posttime = date('Y-m-d H:i:s', $comments['timestamp']);
                            //COMPOSING THE COMMENT
                            //This is the comment itself
                            echo "
                            <a href='/post/{$comments['commentid']}'>
                                <div class='card postpad-post'>
                                    <div class='card-header'>
                                        <div class='row'>
                                            <div class='col-12'>
                                                <table>
                                                    <tr>
                                                        <td rowspan='2' >
                                                            <a href='/user/{$comments['username']}'>                                                            
                                                            <img height='50vh' class='postpad-post-img-image' src='{$comments['pfppath']}'>
                                                            </a>
                                                        </td>
                                                        <td width='20px'>
        
                                                        </td>
                                                        <td >
                                                            <a href='/user/{$comments['username']}'>
                                                                <strong>{$comments['displayname']}</strong>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td width='20px'>
        
                                                    </td>
                                                        <td>
                                                            <a href='/user/{$comments['username']}'>
                                                                <small><i>@{$comments['username']}</i></small>
                                                            </a>
                                                        </td>
                                                        
                                                    </tr>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class='card-body'>
                                        <hr>
                                        <div class='postpad-text'>
                                            <p>
                                            {$comments['content']}
                                            </p>
                                        </div>
                                    </div>
                                    <div class='card-footer'>
                                        <div class='row'>
                                            <div class='col-xs-12 col-lg-12 text-left'>
                                                <small><i>{$posttime} GMT</i></small>
                                            </div>
                                        </div>
        
                                        <hr>
        
                                        <div class='row text-center'>
                                            <div class='col-3'>
                                                <a href='/post/{$comments['commentid']}#comments'><i class='fa-solid fa-comment'></i></a>
                                            </div>
                                            <div class='col-3'>
                                                <i class='fa-solid fa-retweet'></i>
                                            </div>
                                            <div class='col-3'>
                                                <i class='fa-solid fa-heart'></i>
                                            </div>
                                            <div class='col-3'>
                                                <i id='sharebutton{$comments['commentid']}' data-toggle='tooltip' data-placement='top' title='Copy Link to Clipboard' onclick='share({$comments['commentid']});' class='fa-solid fa-share-nodes sharebutton'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            ";
                        }
                    }
                    else if($getcomments->num_rows == 0 && $offset == 0){
                        echo "nocomments";
                    }
                    else{
                        echo "nomorecomments";
                    }
                }
                else{
                    echo "fail";
                    unset($postid);
                    unset($offset);
                    unset($maxvalue);
                    unset($querystring);
                    unset($getcomments);
                    $conn->close();
                    exit();
                }
            }
            else{
                echo "fail";
                unset($postid);
                unset($offset);
                exit();
            }
        }

        public function newcomment(){
            $reply_to = $_POST['postid'];
            $content = $_POST['content'];
            $userid = $_COOKIE['postpad_uid'];
            $posttype = 0; //Until further development, all posts are short posts, thus the posttype var is always 0

            if(is_numeric($reply_to) && $reply_to > 0){
                include "app/system/connect.php";

                //Prevent XSS
                $content = preg_replace("/<script\b[^>]*>(.*?)<\/script>/is", "", $content);

                //Checking if we still have content in the post, even after removing <script>
                if($content == ""){
                    echo "fail";
                    $this->logger(2, "postmanager/newpost()", "User {$userid} tried to post an empty comment! (Probably tried XSS)");
                    $conn->close();
                    die();
                }

                $content = nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8'));

                $timestamp = time();
                $newcommentq = $conn->prepare("INSERT INTO posts (type, posting_user, content, timestamp, reply_to) VALUES (?, ?, ?, ?, ?)");
                $newcommentq->bind_param("iisii", $posttype, $userid, $content, $timestamp, $reply_to);

                if($newcommentq->execute()){
                    //Post content stored, finalising
                    $newcommentq->close();
                    $conn->close();

                    unset($newcommentq);
                    echo "ok";
                    exit();
                }
                else{
                    //Failed to create post header
                    $this->logger(2, "postmanager/newcomment()", "Failed to create new comment: " . $conn->error);
                    $newcommentq->close();
                    $conn->close();

                    unset($newcommentq);
                    echo "fail";
                    die();
                }
            }
        }
    }
?>