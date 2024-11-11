var lastAnnouncement = 0;
var loadedAnnouncement = 0;

function checkForCookie(){
    //Checking for "postPadAnnouncement" cookie
    var exists = false;
    var cookies = document.cookie.split("; ");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split("=");
        if (cookie[0] === "postPadAnnouncement") {
            exists = true;
            lastAnnouncement = cookie[1];
        }
    }

    if(exists){
        console.log("Cookie exists, its value is " + lastAnnouncement);
    }
    else{
        console.log("Cookie doesn't exist");

        //Create cookie, and set its value to 0
        document.cookie = "postPadAnnouncement=" + lastAnnouncement;
        //Recursive check, to see if cookie got set, if so, its value should be 0
        checkForCookie();
    }
}

function getLatestAnnouncement(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            
            try{
                var jsonObject = JSON.parse(this.responseText);

                switch(jsonObject.status){
                    case "success":
                        if(jsonObject.id > lastAnnouncement){
                            document.getElementById("postpad-announcement").style.display = "block";
                            document.getElementById("announcement-title").innerHTML = jsonObject.title;
                            document.getElementById("announcement-title").href = "/announcement/"+ jsonObject.id;
                            loadedAnnouncement = jsonObject.id;
                        }
                        return;
                    case "latestInvalid":
                        console.log("Latest announcement entry is invalid, exiting...")
                        return;
                    case "error":
                        console.warn("Error while trying to get the latest announcement");
                        console.warn(jsonObject.errormsg);
                        return;
                    default:
                        break;
                }
            }
            catch(error){
                console.log("Reply:\n" + this.responseText);
                console.warn("Failed to display announcement\n" + error);
            }
        }
    }
    var params = "action=getLatest";
    xhr.open("POST", "/announcement/processor", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}

function dismissAnnouncement(){
    console.log("dismissAnnouncement()");
    document.getElementById("postpad-announcement").style.display = "none";
    document.cookie = "postPadAnnouncement=" + loadedAnnouncement;
}

function initAnnounceHandler(){
    checkForCookie();
    getLatestAnnouncement();
}
initAnnounceHandler();
