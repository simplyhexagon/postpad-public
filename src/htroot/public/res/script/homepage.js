function newpost(){
    var postcontent = document.getElementById("postpad-userpost").value;
    var checkbox_cw_general = document.getElementById("cw-general-check").checked;
    var checkbox_cw_nsfw = document.getElementById("cw-nsfw-check").checked;
    var cw_general = (checkbox_cw_general) ? 1 : 0;
    var cw_nsfw = (checkbox_cw_nsfw) ? 1 : 0;

    //Removing whitespaces
    var temp = postcontent.trim();
    //Replacing post content with whitespaces removed
    //It will become "" if the post only contains whitespaces
    postcontent = temp;

    if(postcontent !== ""){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                if(this.responseText === "ok"){
                    document.getElementById("postpad-userpost").value = "";
                    resetPosts();
                }
                else if(this.responseText === "fail"){
                    alert("Posting failed, please contact the developers!");
                    document.getElementById("postpad-userpost").value = "";
                    resetPosts();
                }
                else{
                    console.warn("An unknown error occured:\n" + this.responseText);
                    alert("An unknown error occured!\nCheck the developer console and report to the developers");
                    document.getElementById("postpad-userpost").value = "";
                    resetPosts();
                }
            }
        };

        var params = "action=newpost&cw_general="+encodeURIComponent(cw_general)+"&cw_nsfw="+encodeURIComponent(cw_nsfw)+"&postcontent="+encodeURIComponent(postcontent);
        xhr.open("POST", "/main/postmanager", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }
    else{
        alert("You cannot send empty posts");
        document.getElementById("postpad-userpost").value = "";
        resetPosts();
    }
}