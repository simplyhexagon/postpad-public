var userSearch = null;
var postSearch = null;
var searchQuery = null;
var searchResult = null;

function updatePlaceHolder(tab){
    const original = "Enter @username...";
    let placeholder = "";

    placeholder = (tab == 2) ? "Enter search term..." : original;

    document.getElementById("searchQuery").placeholder = placeholder;
}

function initSearch(){
    userSearch = document.getElementById("userSearch").checked;
    postSearch = document.getElementById("postSearch").checked;
    searchQuery = document.getElementById("searchQuery").value;

    searchResult = document.getElementById("searchResult");

    if(searchQuery != ""){
        searchResult.innerHTML = "<div class='text-center'><p><i class='fa-solid fa-circle-notch fa-spin'></i></p></div>";

        if(userSearch){
            userSearchF();
        }
        if(postSearch){
            postSearchF();
        }
    }
    else{
        let tempPlaceholder = document.getElementById("searchQuery").placeholder;

        document.getElementById("searchQuery").value = "";
        document.getElementById("searchQuery").placeholder = "Cannot search for nothing...";

        setTimeout(function(){
            document.getElementById("searchQuery").placeholder = tempPlaceholder;
        }, 2000);

    }
}

function userSearchF(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            console.log("userSearchF raw response: " + this.responseText);
            try{
                let response = JSON.parse(this.responseText);
                if(response.response === "success"){
                    userResultCompositor(response);
                }
                else{
                    errormsghandler(response.message);
                }
            }
            catch(error){
                errormsghandler(error);
            }
        }
    };
    let params = "q="+encodeURIComponent(searchQuery);
    xhr.open("POST", "/search/user", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}

function postSearchF(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            /*let response = JSON.parse(this.responseText);*/
            console.log(this.responseText);
        }
    };
    let params = "q="+encodeURIComponent(searchQuery);
    xhr.open("POST", "/search/posts", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}

///

function userResultCompositor(result1){
    var parsedData = JSON.parse(result1.users);
    searchResult.innerHTML = "";
    for(var key in parsedData){
        if(parsedData.hasOwnProperty(key)){
            var userData = parsedData[key];
            var deeperParsedUserData = JSON.parse(userData);
            searchResult.innerHTML +="<div class='card postpad-post'><div class='card-header'><div class='row'><div class='col-12'><table><tr><td rowspan='2'><a href='/user/"+deeperParsedUserData.username+"'><img height='50vh' class='postpad-post-img-image' src='"+deeperParsedUserData.pfppath+"'></a></td><td width='20px'></td><td><a href='/user/"+deeperParsedUserData.username+"'><strong>"+deeperParsedUserData.displayname+"</strong></a></td></tr><tr><td width='20px'></td><td><a href='/user/"+deeperParsedUserData.username+"'><small><i>@"+deeperParsedUserData.username+"</i></small></a></td></tr></table></div></div></div></div>";

        }
    }
}

function errormsghandler(errormsg){
    switch(errormsg){
        case "tooshort":
            searchResult.innerHTML = "<p><i class='text-red'>Query too short</p></p>";
            break;
        case "nousers":
            searchResult.innerHTML = "<p><i class='text-red'>No user found with this @username</p></p>";
            break;

        default:
            searchResult.innerHTML = "<p><i class='text-red'>An unknown error has occured</p></p>";
            console.warn("errormsghandler(): An error has occured:\n"+errormsg);
            break;
    }
}


// Add an event listener for the "keydown" event
document.addEventListener("keydown", function(event) {
    // Check if the pressed key is the "Enter" key (key code 13)
    if (event.code === 'Enter') {
        // Call the initSearch function
        initSearch();
    }
});


