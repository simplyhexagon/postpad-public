
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-4">
          <div class="card transparentbg">
            <div class="card-header">
              <h3 class="card-title">
                <img class="brandicon" src="/public/res/img/appicon.png"> PostPad
              </h3>
            </div>
            <div class="card-body">
              <?php
                if(!DEV){
              ?>
                <h4>Dive into the conversation!</h4>
                Sign up to <?php echo APP_NAME; ?> to join discussions,<br>share your thoughts, and connect with others!
                <hr>
                <small><i><?php echo APP_NAME . " " . APP_VERSION ?></i></small>
              <?php
                }
                else{
              ?>
                <div class="card bg-warning" style="color: #3c3c3d;">
                  <div class="card-header"><i class="fa-solid fa-code"></i> <strong>Development instance</strong></div>
                  <div class="card-body">
                    <p class="card-text">
                      <i class="fa-solid fa-triangle-exclamation"></i> <b>WARNING!</b> <i class="fa-solid fa-triangle-exclamation"></i> <br>
                      This instance of the software is under development. Its functionality and looks are subject to change any time <br>
                      <b><i>Strictly for internal, development use only!</i></b>
                    </p>
                    
                  </div>
                  <div class="card-footer">
                    <small><i>Software version: <?php echo APP_NAME . " " . APP_VERSION ?></i></small>
                  </div>
                </div>


              <?php
                }
              ?>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
        <div class="card transparentbg">
            <div class="card-body">
              <h3><i>Welcome to <?php echo APP_NAME; ?>!</i></h3>
              <hr>
              <div class="form-group">
                <fieldset>
                  <legend>Sign in</legend>
                  <label for="username"><b>Username</b></label>
                  <input type="text" name="username" id="username" class="form-control">
                  <label for="password"><b>Password</b></label>
                  <input type="password" name="password" id="password" class="form-control">
                  <br>
                  <button onclick="login()" class="btn PostPadDarkElement">Sign In</button>
                </fieldset>
                <hr>
                <fieldset>
                  <legend><small><i>Other options</i></small></legend>
                  <a class="btn btn-sm PostPadDarkElement" href="/outside/signup">Sign up</a>
                  <a class="btn btn-sm PostPadDarkElement" href="/outside/recover">Recover account</a><br>
                </fieldset>
                
              </div>
              <span id="errormsgholder" style="display: none;">
                <br>
                <p id="errormsg" style="color: red;">Error msg</p>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<script>
  function autologin(){
    //This function will automatically log users in if the session cookie is set

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
      if (this.readyState == 4 && this.status == 200){
        if(this.responseText === "ok"){
          window.location.replace("/home");
        }
        else if(this.responseText === "invalid_session"){
          document.getElementById("errormsgholder").style.display = "block";
          document.getElementById("errormsg").innerHTML = "Your session expired!<br>Please log in again!";
        }
        else if(this.responseText === "nosession"){
          document.getElementById("errormsgholder").style.display = "none";
          document.getElementById("errormsg").innerHTML = "";
        }
        else{
          document.getElementById("errormsgholder").style.display = "block";
          document.getElementById("errormsg").innerHTML = "An error occured trying to log you in automatically";
        }
      }
    }
    var params = "action=autologin"
    xhr.open("POST", "/main/processor", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
  }
  autologin();

  function login(){
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    //Removing whitespaces
    username = username.trim();
    password = password.trim();

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            if(this.responseText === "ok"){
              window.location.replace("/home");
            }
            else if(this.responseText === "wrongpw"){
              document.getElementById("errormsgholder").style.display = "block";
              document.getElementById("errormsg").innerHTML = "Wrong password";
            }
            else if(this.responseText === "nouser"){
              document.getElementById("errormsgholder").style.display = "block";
              document.getElementById("errormsg").innerHTML = "User not found";
            }
            else if(this.responseText === "ban"){
              document.getElementById("errormsgholder").style.display = "block";
              document.getElementById("errormsg").innerHTML = "This account is currently banned";
            }
            else if(this.responseText === "sessionfail"){
              document.getElementById("errormsgholder").style.display = "block";
              document.getElementById("errormsg").innerHTML = "Failed to create user session";
            }
            else{
              document.getElementById("errormsgholder").style.display = "block";
              //document.getElementById("errormsg").innerHTML = "Unknown error occured<br><small><code>"+this.responseText+"</code></small>";
              document.getElementById("errormsg").innerHTML = "Unknown error occured";
              console.warn("Login error:\n" + this.responseText);
            }
        }
    };

    var params = "action=signin&username="+encodeURIComponent(username)+"&password="+encodeURIComponent(password);
    xhr.open("POST", "/main/processor", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
  }
</script>