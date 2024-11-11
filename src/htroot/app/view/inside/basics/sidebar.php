<div class="d-none d-lg-block col-lg-3 stickysidebar">
    <div class="card transparentbg">
        <div class="card-header">
            <ul style="list-style: none">
                <li>
                    <a href="/home"><img class="brandicon" src="/public/res/img/appicon.png" alt="" srcset=""></a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            
            <ul style="list-style: none">
                <li>
                    <?php
                        if($_SERVER["REQUEST_URI"] == "/home"){
                        
                    ?>
                        <a href="#topOfPage" onclick="resetPosts()">
                            <h5><i class="fa-solid fa-house"></i> Home</h5>
                        </a>
                    <?php 
                        }
                        else{
                    ?>
                        <a href="/home">
                            <h5><i class="fa-solid fa-house"></i> Home</h5>
                        </a>
                    <?php
                        }
                    ?>
                </li>
                <li>
                    <a href="/search">
                        <h5><i class="fa-solid fa-magnifying-glass"></i> Search</h5>
                    </a>
                </li>
                <li>
                    <a href="/settings">
                        <h5><i class="fa-solid fa-user-gear"></i> Settings</h5>
                    </a>
                </li>
                <li>
                    <a href="/documents">
                        <h5><i class="fa-solid fa-file-lines"></i> Documents</h5>
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-footer">
                <div class="row">
                    <div class="col-4">
                        <a href="/user/<?php echo $_SESSION['username'] ?>">
                            <img class="sidebarpfp" src="<?php echo $_SESSION['pfppath'] ?>" alt="" srcset="">
                        </a>
                    </div>
                    <div class="col-6" style="margin-top:auto; margin-bottom: auto;">
                        <a href="/user/<?php echo $_SESSION['username'] ?>">
                        <span><?php echo $_SESSION['displayname'] ?></span>
                        </a>
                        <br>
                        <a href="/user/<?php echo $_SESSION['username'] ?>">
                            <small>@<?php echo $_SESSION['username'] ?></small>
                        </a>
                    </div>
                    <div class="col-2" style="margin: auto;">
                        <a href="/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                    </div>
                </div>
        </div>
    </div>
</div>