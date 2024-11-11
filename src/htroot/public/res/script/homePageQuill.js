//Quill stuff here
    //Initialise Quill editor on page load
    var customPlaceholder = document.getElementById("postpad-userpost").placeholder;
    var quill = new Quill('#quillEditor', {
        placeholder: customPlaceholder,
        theme: 'snow'
    });

    function newpostquill(){
        var content = quill.getContents();
        var rawContent = document.getElementsByClassName('ql-editor')[0].innerHTML;

        var insertThing = content.ops[0].insert

        var postcontent = rawContent;
        
        //Removing whitespaces
        var temp = postcontent.trim();
        var temp2 = insertThing.trim();
        //Replacing post content with whitespaces removed
        //It will become "" if the post only contains whitespaces
        postcontent = temp;
        insertThing = temp2;

        console.log("Post content: "+postcontent);

        //Checking for "<p><br></p>" is needed bc the "empty" Quill field
        //contains these characters
        if(insertThing == "" || postcontent == "<p><br></p>"){
            alert("You cannot send empty posts");
            document.getElementById("postpad-userpost").value = "";
            resetPosts();
        }
        else{
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200){
                    if(this.responseText === "ok"){
                        document.getElementsByClassName('ql-editor')[0].innerHTML = "";
                        resetPosts();
                    }
                    else if(this.responseText === "fail"){
                        alert("Posting failed, please contact the developers!");
                        document.getElementsByClassName('ql-editor')[0].innerHTML = "";
                        resetPosts();
                    }
                    else{
                        console.warn("An unknown error occured:\n" + this.responseText);
                        alert("An unknown error occured!\nCheck the developer console and report to the developers");
                        document.getElementsByClassName('ql-editor')[0].innerHTML = "";
                        resetPosts();
                    }
                }
            };

            var params = "action=newpostquill&postcontent="+encodeURIComponent(postcontent);
            xhr.open("POST", "/main/postmanager", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(params);
        }
    }