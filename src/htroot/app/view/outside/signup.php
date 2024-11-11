<section class="content">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-12">
          <h4>Sign up to PostPad</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-lg-6">
            <div class="card transparentbg">
                <div class="card-header">
                    <h4 class="card-title">Required information</h4>
                </div>
                <div class="card-body">
                    <label for="email">E-mail address</label>
                    <input type="text" name="emailconfirm" id="emailconfirm" class="form-control"><br>
                    <label for="emailconfirm">Confirm e-mail address</label>
                    <input type="text" name="email" id="email" class="form-control"><br>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                    <small><i>Username can only contain alphanumeric characters</i></small>
                    <br>
                    <label for="birthday">Date of Birth</label>
                    <input type="date" name="birthday" id="birthday" class="form-control" value="2000-01-01">
                    <br>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" pattern="[^\s]">
                    <label for="confirmpassword">Confirm password</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" pattern="[^\s]">
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
                    <?php
                        if(INVITE_ONLY){
                    ?>
                    <hr>
                    <p><i>The website currently operates in "Invite only" mode</i></p>
                    <label for="invitecode">Invite code</label>
                    <input class="form-control" type="text" name="invitecode" id="invitecode" placeholder="A1A1A-B2B2B-C3C3C-D4D4D-E5E5E" required>
                    <?php
                        }
                    ?>
                    <p></p>
                </div>
                <div class="card-footer">
                    <i><small>By signing up you agree to our <a href="/documents/tos" target="_blank" style="color: ">Terms of Service</a>,  <a href="/documents/privacy" target="_blank">Privacy Policy</a> and <a href="/documents/guidelines">Community Guidelines</a></small></i>
                    <br><br>

                    <button type="button" onclick="signup()" class="btn PostPadDarkElement">Sign up</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
<script>

    //Password strength evaluation
    $(function() {
        $('#password').on('keypress', function(){
            //We are delaying the read so the character actually has time to register
            setTimeout(function(){
                var password = document.getElementById("password").value;
                

                //How many points does the password achieve
                var points = 0;
                var capsPoints = 0;
                var numPoints = 0;
                var charPoints = 0;

                //If the password is less than 10 characters, it gets the points of charcount/2
                if(password.length <= 10){
                    points = password.length / 2;
                }
                else if(password.length > 10){
                    points = 5;
                }

                //If the password contains a capital letter, add a point
                const capitals = /[A-Z]/g;
                var passCaps = password.match(capitals);
                if(passCaps != null){
                    if(passCaps.length <=3){
                        capsPoints = passCaps.length;
                    }
                    else{
                        capsPoints = 3;
                    }
                }
                //If the password contains a number, add a point
                const numberz = /[0-9]/g;
                var passNums = password.match(numberz);
                if(passNums != null){
                    if(passNums.length  <=3){
                        numPoints = passNums.length;
                    }
                    else{
                        numPoints = 3;
                    }
                }
                //If the character contains a special character, add 2 points
                const charz = /[^0-9A-Za-z\s]/g;
                var passChars = password.match(numberz);
                if(passChars != null){
                    if(passChars.length  < 3){
                        charPoints = 2 * passChars.length;
                    }
                    else{
                        charPoints = 4;
                    }
                }

                //Summarise the points
                points += capsPoints + numPoints + charPoints;

                
                if(points <= 5){
                    document.getElementById("passwordstrength").innerHTML = "Weak";
                }
                else if(points >= 6 && points <= 9){
                    document.getElementById("passwordstrength").innerHTML = "Strong";
                }
                else if(points >= 10){
                    document.getElementById("passwordstrength").innerHTML = "Very strong!";
                }

                
                //Checking for whitespace and overwriting
                var passWhiteSpace = password.match(/[\s]/g);
                if(passWhiteSpace != null && passWhiteSpace.length > 0){
                    document.getElementById("passwordstrength").innerHTML = "Password cannot contain spaces!";
                }
            }, 125);
        })
    });

    //Password strength evaluation END

    //Signup script
    function signup(){
        var password = document.getElementById("password").value;
        var confirmpassword = document.getElementById("confirmpassword").value;
        if(password !== confirmpassword){
            alert("Passwords don't match!");
            return;
        }

        //Checking for whitespace
        var passWhiteSpace = password.match(/[\s]/g);

        if(passWhiteSpace == null || passWhiteSpace == undefined){
            var email = document.getElementById("email").value;
            var emailconfirm = document.getElementById("emailconfirm").value;
            if(email !== emailconfirm){
                alert("E-mail addresses don't match");
                return;
            }

            var username = document.getElementById("username").value;
            //Removing whitespace
            username = username.trim();

            var birthday = document.getElementById("birthday").value;

            //Check if username contains sth other than alphanumeric characters, underscore allowed
            var unameCheck = username.match(/[^0-9a-zA-Z'_']/g);
            if(unameCheck == null || unameCheck == undefined){
                if(email && username && password){
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200){
                            if(this.responseText === "ok"){
                                alert("Successful signup, you can now log in!");
                                window.location.replace("/");
                            }
                            else if(this.responseText === "username taken"){
                                alert("Username already taken!");
                            }
                            else if(this.responseText === "email taken"){
                                alert("E-mail address already in use");
                            }
                            else{
                                console.log(this.responseText);
                                alert("An error occured, please contact the developers!");
                            }
                        }
                    };

                    var params = "action=usersignup&email="+encodeURIComponent(email)+"&username="+encodeURIComponent(username)+"&password="+encodeURIComponent(password)+"&birthday="+encodeURIComponent(birthday);
                    xhr.open("POST", "/outside/processor", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.send(params);
                }
            }
            else{
                showcustommodal("Empty fields", "Please fill in every field");
            }
        }
        else if(passWhiteSpace != null && passWhiteSpace.length > 0){
            //password cannot contain spaces
        }
    }
</script>