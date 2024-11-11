function newpost(){
    var postcontent = document.getElementById("postpad-userpost").value;
    

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

        var params = "action=newpost&postcontent="+encodeURIComponent(postcontent);
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