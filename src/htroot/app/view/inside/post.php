<?php
    $model = new postmanager();
    $postcontent = $model->getpostfull($params["postid"]);
    
    if(!$postcontent){
?>

<div class="col-xs-12 col-lg-7">
    <div class="card postpad-userpost-container textColorOverride">
        <div class="card-body">
            The post you're looking for doesn't exist
        </div>
    </div>
</div>

<?php
    die();
}

$posttime = date('Y-m-d H:i:s', $postcontent['timestamp']);
if($postcontent["reply_to"] == NULL){
?>
<div class="col-xs-12 col-lg-7">
    <div class="card postpad-userpost-container textColorOverride">
        <div class="card-header">
            <h4>Post by <?php echo $postcontent['displayname']; ?></h4>
        </div>
        <div class="card-body">
            <div class='row'>
                <div class='col-12'>
                    <table>
                        <tr>
                            <td rowspan='2'>
                                <a <?php echo "href='/user/" . $postcontent['username'] . "'"; ?>>                                                            
                                <img height='50vh' class='postpad-post-img-image' src="<?php echo $postcontent['pfppath']; ?>">
                                </a>
                            </td>
                            <td width='20px'>

                            </td>
                            <td >
                                <a <?php echo "href='/user/" . $postcontent['username'] . "'"; ?>>
                                    <strong><?php echo $postcontent['displayname']; ?></strong>
                                </a>
                            </td>
                        </tr>
                        <tr>
                        <td width='20px'>

                        </td>
                            <td>
                                <a <?php echo "href='/user/" . $postcontent['username'] . "'"; ?>>
                                    <small><i>@<?php echo $postcontent['username']; ?></i></small>
                                </a>
                            </td>
                            
                        </tr>
                    </table>
                </div> 
            </div>
            <hr>
            <div class="row">
                <div class="col-12 postpad-text">
                    <p>
                        <?php echo $postcontent['content']; ?>
                    </p>
                </div>
            </div>
            <div class='row'>
                <div class='col-12 text-left'>
                    <small><i><?php echo $posttime; ?> GMT</i></small>
                </div>
            </div>
            <hr>
            <div class='row text-center'>
                <div class='col-3'>
                    <a href="#comments"><i class='fa-solid fa-comment'>&nbsp;</i> <?php echo $postcontent['commentcount']; ?></a>
                </div>
                <div class='col-3'>
                    <i class='fa-solid fa-retweet'></i>
                </div>
                <div class='col-3'>
                    <i class='fa-solid fa-heart'></i>
                </div>
                <div class='col-3'>
                    <i id='sharebutton<?php echo $params["postid"]; ?>' data-bs-toggle='tooltip' data-bs-placement='top' title='Copy Link to Clipboard' onclick='share(<?php echo $params["postid"]; ?>);' class='fa-solid fa-share-nodes sharebutton'></i>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-footer">
            <?php
                $this->model("accesschecker");
                $ac = new accesschecker();
                if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
            ?>
                <textarea id="postpad-userpost" class="postpad-userpost form-control" maxlength="400" oninput="countCharacters()" placeholder="Leave a comment..."></textarea>
                <span id="userpost-miscelements">
                    <small id="charcount"></small>
                    <button id="sendButton" class="btn PostPadLightElement" style="float: right;" onclick="newcomment()">Post!</button>
                </span>
                <hr>
            <?php
                }
            ?>
            <span id="comments">
                <p class="text-center text-white"><i class="fa-solid fa-circle-notch fa-spin"></i></p>
            </span>
        </div>
    </div>
</div>

<script src="/public/res/script/postpage.js" type="text/javascript"></script>
<?php
    $this->model("accesschecker");
    $ac = new accesschecker();
    if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
?>
    <script src="/public/res/script/commentUnderPost.js" type="text/javascript"></script>
<?php
    }
?>

<?php
}
else{
    $sourcepost = $model->getpostfull($postcontent["reply_to"]);
    $sourceposttime = date('Y-m-d H:i:s', $sourcepost['timestamp']);
?>

<div class="col-xs-12 col-lg-7">
    <div class="card postpad-userpost-container textColorOverride">
        <div class="card-header">
            <h4>Thread</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <!-- Start of source post -->
                    <a href="/post/<?php echo $sourcepost['id'] ?>">
                        <div class='row'>
                            <div class='col-12'>
                                <table>
                                    <tr>
                                        <td rowspan='2'>
                                            <a <?php echo "href='/user/" . $sourcepost['username'] . "'"; ?>>                                                            
                                            <img height='50vh' class='postpad-post-img-image' src="<?php echo $sourcepost['pfppath']; ?>">
                                            </a>
                                        </td>
                                        <td width='20px'>

                                        </td>
                                        <td >
                                            <a <?php echo "href='/user/" . $sourcepost['username'] . "'"; ?>>
                                                <strong><?php echo $sourcepost['displayname']; ?></strong>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td width='20px'>

                                    </td>
                                        <td>
                                            <a <?php echo "href='/user/" . $sourcepost['username'] . "'"; ?>>
                                                <small><i>@<?php echo $sourcepost['username']; ?></i></small>
                                            </a>
                                        </td>
                                        
                                    </tr>
                                </table>
                            </div> 
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 postpad-text">
                                <p>
                                    <?php echo $sourcepost['content']; ?>
                                </p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12 text-left'>
                                <small><i><?php echo $sourceposttime; ?> GMT</i></small>
                            </div>
                        </div>
                    </a>
                    <!-- End of source post -->

                    <hr>

                    <!-- Start of reply -->

                    <div class='row'>
                        <div class="col-1"> <!-- Indentation --> </div>
                        <div class="col-11">
                            <div class="row">
                                <div class='col-12'>
                                    <table>
                                        <tr>
                                            <td rowspan='2'>
                                                <a <?php echo "href='/user/" . $postcontent['username'] . "'"; ?>>                                                            
                                                <img height='50vh' class='postpad-post-img-image' src="<?php echo $postcontent['pfppath']; ?>">
                                                </a>
                                            </td>
                                            <td width='20px'>

                                            </td>
                                            <td >
                                                <a <?php echo "href='/user/" . $postcontent['username'] . "'"; ?>>
                                                    <strong><?php echo $postcontent['displayname']; ?></strong>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                        <td width='20px'>

                                        </td>
                                            <td>
                                                <a <?php echo "href='/user/" . $postcontent['username'] . "'"; ?>>
                                                    <small><i>@<?php echo $postcontent['username']; ?></i></small>
                                                </a>
                                            </td>
                                            
                                        </tr>
                                    </table>
                                </div> 
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 postpad-text">
                                    <p>
                                        <?php echo $postcontent['content']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-12 text-left'>
                                    <small><i><?php echo $posttime; ?> GMT</i></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class='row text-center'>
                        <div class='col-3'>
                            <a href="#comments"><i class='fa-solid fa-comment'>&nbsp;</i> <?php echo $postcontent['commentcount']; ?></a>
                        </div>
                        <div class='col-3'>
                            <i class='fa-solid fa-retweet'></i>
                        </div>
                        <div class='col-3'>
                            <i class='fa-solid fa-heart'></i>
                        </div>
                        <div class='col-3'>
                            <i onclick='share(<?php echo $params["postid"]; ?>);' class='fa-solid fa-share-nodes sharebutton'></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <div class="card-footer">
            <?php
                $this->model("accesschecker");
                $ac = new accesschecker();
                if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
            ?>
                <textarea id="postpad-userpost" class="postpad-userpost form-control" maxlength="400" oninput="countCharacters()" placeholder="Leave a comment..."></textarea>
                <span id="userpost-miscelements">
                    <small id="charcount"></small>
                    <button id="sendButton" class="btn PostPadLightElement" style="float: right;" onclick="newcomment()">Post!</button>
                </span>
                <hr>
            <?php
                }
            ?>
            <span id="comments">
                <p class="text-center text-white"><i class="fa-solid fa-circle-notch fa-spin"></i></p>
            </span>
        </div>
    </div>
</div>

<script src="/public/res/script/postpage.js" type="text/javascript"></script>
<?php
    $this->model("accesschecker");
    $ac = new accesschecker();
    if(isset($_COOKIE['postpad_sessionid']) && $ac->check($_COOKIE['postpad_sessionid'])){
?>
    <script src="/public/res/script/commentUnderPost.js" type="text/javascript"></script>
<?php
    }
?>

<?php
}
?>