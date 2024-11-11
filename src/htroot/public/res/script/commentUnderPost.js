const userpost = document.getElementById("postpad-userpost");
var initialBoxHeight = userpost.clientHeight;

// Add an event listener for input changes
userpost.addEventListener('input', () => {
    // Adjust the textarea's height to fit the content
    userpost.style.height = 'auto';
    userpost.style.height = (userpost.scrollHeight + 5) + 'px';
});

const sendButton = document.getElementById("sendButton");
sendButton.addEventListener('click', () => {
    // Reset the textarea's height to its initial value
    userpost.style.height = initialBoxHeight + 'px';
});

//This functionality is only available on the home page so it has been moved here
function countCharacters(){
    var text = document.getElementById("postpad-userpost").value;

    var miscelements = document.getElementById("userpost-miscelements");
    var count = text.length;
    document.getElementById("charcount").innerHTML = count + "/400";

    if(count === 0){
        miscelements.style.display = "none";
    }
    else{
        miscelements.style.display = "block";
    }
    
}
countCharacters();

function newcomment(){
    let postID = getPostID();

    var postcontent = document.getElementById("postpad-userpost").value;
    

    //Removing whitespaces
    var temp = postcontent.trim();
    //Replacing post content with whitespaces removed
    //It will become "" if the post only contains whitespaces
    postcontent = temp;

    if(postcontent != ""){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                if(this.responseText === "ok"){
                    document.getElementById("postpad-userpost").value = "";
                    resetPosts();
                }
                else{
                    console.warn("An error occured while trying to post comment:\n" + this.responseText);
                    alert("An error occured while trying to post comment");
                    resetPosts();
                }
            }
        }
        var params = "action=newcomment&postid="+encodeURIComponent(postID)+"&content="+encodeURIComponent(postcontent);
        xhr.open("POST", "/post/processor", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }
    else{
        alert("You cannot leave empty comments!");
        document.getElementById("postpad-userpost").value = "";
    }    
}