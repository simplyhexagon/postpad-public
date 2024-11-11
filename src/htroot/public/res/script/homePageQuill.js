//Quill stuff here
    //Initialise Quill editor on page load
    var customPlaceholder = document.getElementById("postpad-userpost").placeholder;
    var charCountQuill = document.getElementById("charCountQuill");
    const maxCharCount = 4000;

    var quill = new Quill('#quillEditor', {
        placeholder: customPlaceholder,
        theme: 'snow'
    });

    var content = null;
    var rawContent = null;
    var insertThing = null;
    var postContent = null;

    quill.on('text-change', function(delta, oldDelta, source){
        if(source == "user"){
            content = quill.getContents();
            insertThing = content.ops[0].insert;

            charCountQuill.innerHTML = insertThing.length + "/" + maxCharCount;
        }
    });

    function newpostquill(){
        var checkbox_cw_general = document.getElementById("cw-general-check").checked;
        var checkbox_cw_nsfw = document.getElementById("cw-nsfw-check").checked;
        var cw_general = (checkbox_cw_general) ? 1 : 0;
        var cw_nsfw = (checkbox_cw_nsfw) ? 1 : 0;


        content = quill.getContents();
        rawContent = document.getElementsByClassName('ql-editor')[0].innerHTML;

        insertThing = content.ops[0].insert

        postcontent = rawContent;
        
        //Removing whitespaces
        var temp = postcontent.trim();
        var temp2 = insertThing.trim();
        //Replacing post content with whitespaces removed
        //It will become "" if the post only contains whitespaces
        postcontent = temp;
        insertThing = temp2;

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

            var params = "action=newpostquill&cw_general="+encodeURIComponent(cw_general)+"&cw_nsfw="+encodeURIComponent(cw_nsfw)+"&postcontent="+encodeURIComponent(postcontent);
            xhr.open("POST", "/main/postmanager", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(params);
        }
    }