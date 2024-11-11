function savechanges(){
        
    const saveBtnDefaultTxt = "Save changes";
    var fd = new FormData();
    fd.append("action", "savechanges")
    var savebtn = document.getElementById("savebtn");

    savebtn.classList.add("disabled");
    savebtn.innerHTML = "Saving...";

    var displayname = document.getElementById("displayname").value;
    //Trim whitespaces off of display name
    displayname.trim()

    var profilePicture = document.getElementById("profilepic");
    var birthday = document.getElementById("birthday").value;
    var bio = document.getElementById("bio").value;
    var website = document.getElementById("website").value;
    var email = document.getElementById("email").value;
    var currentpass = document.getElementById("currentpass").value;
    var newpass = document.getElementById("newpass").value;
    var newpassagain = document.getElementById("newpassagain").value;

    if(displayname != ""){
        
        fd.append("displayname", displayname);
        if(newpass != "" && newpassagain != ""){
            //Checking for whitespaces in the password
            var passWhiteSpace = newpass.match(/[\s]/g);
            
            if(passWhiteSpace == null || passWhiteSpace == undefined){
                //New passwords not empty
                if(newpass != newpassagain){
                    alert("New passwords must match");
                }
                else{
                    fd.append("newpass", newpass);
                    fd.append("newpassagain", newpassagain);
                }
            }
            else{
                alert("Password cannot contain spaces!");
            }
        }
        if(profilePicture.files.length == 1){
            fd.append("profilepicture", profilePicture.files[0]);
        }
                    
        fd.append("birthday", birthday);
        fd.append("bio", bio);
        fd.append("website", website);
        fd.append("email", email);
        fd.append("currentpass", currentpass);
        

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/settings/processor', true);
        xhr.send(fd);

        xhr.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                switch(this.responseText){
                    case "updateok":
                        getNewProfilePic();
                        savebtn.classList.add("bg-success");
                        savebtn.innerHTML = "Saved!";
                        break;
                    case "pwchgok":
                        window.location.replace("/logout");
                        break;
                    case "wrongpw":
                        alert("Invalid password");
                        break;
                    case "pwchgfail":
                        alert("Failed to change user password");
                        break;
                    case "imgUploadError":
                        alert("Failed to upload the new profile image");
                        break;
                    case "invalidimgtype":
                        alert("Invalid profile image type");
                        break;
                    case "filesizetoobig":
                        alert("Profile image size too big");
                        break;
                    case "imgtoolarge":
                        alert("Profile image too large for resolution limit (max. 500x500)");
                        break;
                    case "imguploadinternal":
                        alert("We couldn't upload your profile image (Internal server error)");
                        break;
                    default:
                        console.warn(this.responseText);
                        alert("An unknown error occured");
                        break;
                }
                setTimeout(function(){
                    if(savebtn.classList.contains("bg-success"))
                        savebtn.classList.remove("bg-success");

                    savebtn.classList.remove("disabled");
                    savebtn.innerHTML = saveBtnDefaultTxt;
                }, 1000);
                
            }
        };
    }
    else{
        alert("Display name cannot be empty!");
    }
}

function queryActiveSessions(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            document.getElementById("sessionList").innerHTML = this.responseText;
        }
    };
    var params = "action=queryactivesessions";
    xhr.open("POST", "/settings/processor", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}

function logoutSession(sessionid){
    if(confirm("Do you wish to log out this session? (ID: " + sessionid + ")")){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                if(this.responseText === "ok"){
                    queryActiveSessions();
                }
            }
        };
        var params = "action=logoutsession&sessionid="+encodeURIComponent(sessionid);
        xhr.open("POST", "/settings/processor", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }
}

function logoutEverySession(){
    if(confirm("Do you want to log out every session? This will also log you out from this session!")){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                if(this.responseText === "ok"){
                    window.location.replace("/logout");
                }
                else{
                    console.log(this.responseText);
                    alert("An error occured");
                }
            }
        };
        var params = "action=logouteverysession";
        xhr.open("POST", "/settings/processor", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }
}

function getNewProfilePic(){
    var oldpfp = document.getElementById("userprofilepicture").src;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            if(this.responseText != "nochange" && this.responseText.startsWith("/public/res/img/pfps")){
                document.getElementById("userprofilepicture").src = this.responseText;
            }
            else if(!this.responseText.startsWith("/public/res/img/pfps")){
                console.error("Error: " + this.responseText);
                alert("An error occured while trying to fetch new profile picture!");
            }
        }
    };
    var params = "action=getnewprofilepic&oldpfp="+encodeURIComponent(oldpfp);
    xhr.open("POST", "/settings/processor", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}