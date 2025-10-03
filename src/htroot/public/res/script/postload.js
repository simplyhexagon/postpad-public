var offset = 0;
var doNotLoad = false;

function fillPosts(){
    
    if(!doNotLoad){
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                switch(this.responseText){
                    case "nomoreposts":

                        document.getElementById("everypost").innerHTML += "<div class='card postpad-post'><div class='card-body text-center'><div class='row'><div class='col-xs-12 col-lg-12'><p class='postpad-text bottomMessage'>We couldn't find any more posts</p></div></div></div></div>";
                        doNotLoad = true;
                        break;
                    
                    case "internalerror":
                        
                        document.getElementById("everypost").innerHTML += "<div class='card postpad-post'><div class='card-body text-center'><div class='row'><div class='col-xs-12 col-lg-12'><p class='postpad-text bottomMessage'>Something went wrong on our end</p></div></div></div></div>";
                        doNotLoad = true;
                        break;
                    
                    case "noposts":
                        
                        document.getElementById("everypost").innerHTML = "";
                        document.getElementById("everypost").innerHTML = "<div class='card postpad-post'><div class='card-body text-center'><div class='row'><div class='col-xs-12 col-lg-12'><p class='postpad-text bottomMessage'>This user hasn't posted anything... <i>Yet...</i></p></div></div></div></div>";
                        doNotLoad = true;
                        break;

                    default:
                        if(offset == 0){
                            // Clear loading message
                            if(this.responseText.length > 0){
                                document.getElementById("everypost").innerHTML = "";
                            }
                        }
                        document.getElementById("everypost").innerHTML += this.responseText;
    
                        offset += 20;
                        break;
                }
                
            }
        };

        // Check if we are on a /user page
        // Get the current URL
        const currentUrl = window.location.href;

        // Split the URL at the '/' characters
        const urlParts = currentUrl.split('/');

        if(urlParts[3] === "user"){
            var params = "action=fillPosts&offset="+encodeURIComponent(offset)+"&user="+encodeURIComponent(urlParts[4]);
        }
        else{
            var params = "action=fillPosts&offset="+encodeURIComponent(offset);
        }
        xhr.open("POST", "/main/postmanager", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }
    else{
        return;
    }
}
fillPosts();

function resetOffset(){
    doNotLoad = false;
    offset = 0;
}

function resetPosts(){
    document.getElementById("cw-general-check").checked = false;
    document.getElementById("cw-nsfw-check").checked = false;
    resetOffset();
    countCharacters();
    document.getElementById("everypost").innerHTML = "";
    fillPosts();
}

window.addEventListener('scroll', function() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        fillPosts();
    }
});