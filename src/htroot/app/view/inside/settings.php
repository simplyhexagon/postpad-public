<?php
    error_reporting(E_ALL & ~E_NOTICE);
    
    session_start();
    //We'll get the details from the session vars set by userdetailfactory

    $model = new userdetailfactory();
    $details = $model->getdataforsettings();
?>
<section class="content" style="padding-top: 2vh !important;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <h3>
                    <a href="/home"><img class="brandicon" src="/public/res/img/appicon.png" alt="" srcset=""></a>
                    User settings
                </h3>
                <a class="btn btn-sm PostPadLightElement" href="/home">← Go back Home</a>
                <br>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="card transparentbg ">
                    <div class="card-body">
                            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basicSettings" data-bs-toggle="tab" data-bs-target="#basicSettingsTab" type="button" aria-controls="basicSettings" aria-selected="true">Basic Settings</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="details" data-bs-toggle="tab" data-bs-target="#detailsTab" type="button" aria-controls="details">Profile Details</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button onclick="queryActiveSessions()" class="nav-link" id="sessions" data-bs-toggle="tab" data-bs-target="#sessionsTab" type="button" aria-controls="details">Active Sessions</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="advanced" data-bs-toggle="tab" data-bs-target="#advancedTab" type="button" aria-controls="advanced">Advanced Settings</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="settingsTabContent">
                                <div class="tab-pane fade show active" id="basicSettingsTab" aria-labelledby="basicSettings">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Name</legend>
                                            <label for="displayname">Display name</label>
                                            <input type="text" class="form-control" id="displayname" value="<?php echo $details['displayname']; ?>" maxlength="25">
                                            <label for="username">Username <small>(cannot be changed)</small></label>
                                            <input disabled readonly type="text" name="username" id="username" class="form-control disabled" value="<?php echo $details['username']; ?>" maxlength="15">
                                        </fieldset>
                                        

                                        <hr>
                                        <legend>Profile picture</legend>
                                        
                                        <div class="row">
                                            <div class="col-sm-3 col-lg-2 ">
                                                <p>Current picture: </p>
                                            </div>
                                            <div class="col-sm-9 col-lg-10">
                                                <img id="userprofilepicture" class="settingspfp" src="<?php echo $details['pfppath'] ?>" alt="User profile picture" srcset="">
                                            </div>
                                        </div>
                                        <label for="profilepic">Upload new picture <br><small>(*.jpg, *.jpeg, *.png, *.gif | max. 500x500 | max. 1MB)</small></label>
                                        <input type="file" name="profilepic" id="profilepic" class="form-control" accept="image/jpeg, image/png, image/gif">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="detailsTab" aria-labelledby="details">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Profile details</legend>
                                            <label for="birthday">Date of Birth</label>
                                            <input type="date" name="birthday" id="birthday" class="form-control" value="<?php echo $details['birthday']; ?>">
                                            <label for="bio">Bio:</label>
                                            <textarea class="form-control" name="bio" id="bio" cols="30" rows="4" maxlength="150"><?php echo $details['bio']; ?></textarea>
                                            <label for="website">Website:</label>
                                            <input type="text" name="website" id="website" class="form-control" maxlength="150" value="<?php echo $details['website']; ?>">
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sessionsTab" aria-labelledby="sessions">
                                    <fieldset>
                                        <legend>Active Sessions</legend>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Browser and device type</th>
                                                    <th>Login timestamp</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sessionList">
                                                
                                            </tbody>
                                        </table>
                                        <button class="btn btn-danger" onclick="logoutEverySession()">Log Out Every Session</button>
                                    </fieldset>
                                </div>
                                <div class="tab-pane fade" id="advancedTab" aria-labelledby="advanced">
                                    <div class="form-group">
                                        <fieldset>
                                            <legend>Contact</legend>
                                            <label for="email">E-mail address</label>
                                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $details['email']; ?>">
                                        </fieldset>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <legend>Change password</legend>
                                        <label for="currentpass">Current password</label>
                                        <input type="password" name="currentpass" id="currentpass" class="form-control">
                                        <label for="newpass">New password</label>
                                        <input type="password" name="newpass" id="newpass" class="form-control">
                                        <label for="newpassagain">Repeat new password</label>
                                        <input type="password" name="newpassagain" id="newpassagain" class="form-control">
                                        <br>
                                        <small>
                                            <i>
                                                The password must contain
                                                <ul>
                                                    <li>at least 8 characters</li>
                                                    <li>one capital letter</li>
                                                    <li>one number</li>
                                                    <li>one special character</li>
                                                </ul>
                                            </i>
                                            Password strength: <span id="passwordstrength"></span>
                                        </small>
                                        <br>
                                        <i>
                                            <small>
                                                Please note that after changing your password
                                                <ul>
                                                    <li>you will have to log in again</li>
                                                    <li>every session will be invalidated</li>
                                                </ul>
                                            </small>
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button id="savebtn" class="btn PostPadLightElement" onclick="savechanges()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="/public/res/script/newPasswordEval.js"></script>

<script src="/public/res/script/settingsPage.js"></script>