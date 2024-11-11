    // Get the current URL
    const currentUrl = window.location.href;

    // Split the URL at the '/' characters
    const urlParts = currentUrl.split('/');

    var offset = 0;
    var doNotLoad = false;

    function getPostID(){
        var postID = urlParts[4];

        if(urlParts[4].includes('#')){
            var split = urlParts[4].split('#');
            postID = split[0];
        }

        return postID;
    }

    function loadComments(){
        if(!doNotLoad){
            let postID = getPostID();

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200){
                    
                    switch(this.responseText){
                    case "nomorecomments":
                        
                        document.getElementById("comments").innerHTML += "<div class='card postpad-post'><div class='card-body'><div class='row'><div class='col-xs-12 col-lg-12'><p class='postpad-text'><i>No more comments are available</i></p></div></div></div></div>";
                        doNotLoad = true;
                        break;
                    
                    case "fail":
                        document.getElementById("comments").innerHTML += "<div class='card postpad-post'><div class='card-body'><div class='row'><div class='col-xs-12 col-lg-12'><p class='postpad-text'><i>Something went wrong on our end</i></p></div></div></div></div>";
                        doNotLoad = true;
                        break;
                    
                    case "nocomments":
                        
                        document.getElementById("comments").innerHTML = "";
                        document.getElementById("comments").innerHTML = "<div class='card postpad-post'><div class='card-body'><div class='row'><div class='col-xs-12 col-lg-12'><p class='postpad-text'>This are no comments on this post... <i>Yet...</i></p></div></div></div></div>";
                        doNotLoad = true;
                        break;

                    default:
                        if(offset == 0){
                            // Clear loading message
                            if(this.responseText.length > 0){
                                document.getElementById("comments").innerHTML = "";
                            }
                        }
                        document.getElementById("comments").innerHTML += this.responseText;

                        offset += 20;
                        break;
                    }
                }
                
            };
            var params = "action=getcomments&postid="+encodeURIComponent(postID)+"&offset="+encodeURIComponent(offset);
            xhr.open("POST", "/post/processor", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(params);
        }
    }

    loadComments();

    

    window.addEventListener('scroll', function() {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
            loadComments();
        }
    });

    function resetOffset(){
        doNotLoad = false;
        offset = 0;
    }

    function resetPosts(){
        resetOffset();
        countCharacters();
        document.getElementById("comments").innerHTML = "";
        loadComments();
    }