<?php
    $url = $_SERVER["REQUEST_URI"];
    $split = explode("/", $url);

    $model = new publicuserdetails();
    $details = $model->compileUserProfile($split[2]);
    if($details["username"] == "Error"){
?>
<div class="col-xs-12 col-lg-7" id="posts">
    <div class="card postpad-container textColorOverride">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h3>Uh oh...</h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    An error occured while trying to find the user
                </div>
            </div>
            
        </div>
        
    </div>
</div>
<?php
    }
    if($details["username"] == "Empty"){
?>
<div class="col-xs-12 col-lg-7" id="posts">
    <div class="card postpad-container textColorOverride">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h3>Uh oh...</h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    The user you are looking for does not exist
                </div>
            </div>
            
        </div>
        
    </div>
</div>
<?php
    }
    if($details["privateprofile"] == 1){
?>
<div class="col-xs-12 col-lg-7" id="posts">
        <div class="card postpad-container textColorOverride">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <img style="height: 12vh; border-radius: 50%;" src="<?php echo $details["pfppath"]; ?>" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>
                            
                            <?php echo $details["displayname"]; ?>
                        </h3>
                        <i ><small><?php echo "@" . $details["username"]; ?></small></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <i ><small>Joined: <?php echo $details["signupday"]; ?></small></i>
                    </div>
                </div>
            </div>
            <hr>
            <span id="everypost">
                <p class="text-center text-white"><i>This profile is set to private</i></p>
            </span>
            
        </div>
    </div>
<?php
    }
    else{
        $counterdata = $model->getprofilecounters($details["username"]);
?>
<div class="col-xs-12 col-lg-7" id="posts">
        <div class="card postpad-container textColorOverride">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <img style="height: 12vh; border-radius: 50%;" src="<?php echo $details["pfppath"]; ?>" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>
                            
                            <?php echo $details["displayname"]; ?>
                        </h3>
                        <i ><small><?php echo "@" . $details["username"]; ?></small></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <i ><small>Joined: <?php echo $details["signupday"]; ?></small></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <small>Website: <a target="_blank" href="<?php echo $details["website"]; ?>"><?php echo $details["website"]; ?></a></small>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <table class="profilecounters text-center">
                            <tr>
                                <th>Posts &amp; replies</th>
                                <th>Following</th>
                                <th>Followers</th>
                            </tr>
                            <tr>
                                <td><?php echo $counterdata["postcount"]; ?></td>
                                <td><?php echo $counterdata["followedcount"]; ?></td>
                                <td><?php echo $counterdata["followercount"]; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <?php echo $details["bio"]; ?>
                    </div>
                </div>
                
            </div>
            <span id="everypost">
                <p class="text-center text-white"><i class="fa-solid fa-circle-notch fa-spin"></i></p>
            </span>
            
        </div>
    </div>
<script type="text/javascript" src="/public/res/script/postload.js"></script>
<script src="/public/res/script/blurLogic.js"></script>
<?php
    }
?>