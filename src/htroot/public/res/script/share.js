// Get the current URL
const currentURL = window.location.href;

// Function to extract the base URL
function getBaseURL(url) {
  const urlObject = new URL(url);
  if(urlObject.port){
    return `${urlObject.protocol}//${urlObject.hostname}:${urlObject.port}`;
  }
  else{
    return `${urlObject.protocol}//${urlObject.hostname}`;
  }
  
}

const baseURL = getBaseURL(currentURL);

function share(postid){
    let postURL = baseURL + "/post/" + postid;

    let shareButton = document.getElementById("sharebutton" + postid);

    try{
        navigator.clipboard.writeText(postURL);
        console.log("Copied " + postURL + " to clipboard");

        shareButton.title = "Copied Link to Clipboard!";
        setTimeout(function(){
            shareButton.title = "Copy Link to Clipboard"
        }, 500);
    }
    catch(err){
        if(shareFallback(postURL)){
            console.log("Copied " + postURL + " to clipboard");

            shareButton.title = "Copied Link to Clipboard!";
            setTimeout(function(){
                shareButton.title = "Copy Link to Clipboard"
            }, 500);
        }
        else{
            console.error("Fallback failed!");
        }
    }
}

function shareFallback(postURL){
    try{
        const invisible = document.createElement('textarea');
        invisible.style.position = 'fixed';
        invisible.style.left = '-9999px';

        invisible.value = postURL;

        document.body.appendChild(invisible);
        invisible.select();

        let successful = document.execCommand('copy');

        document.body.removeChild(invisible);
        return successful;
    }
    catch(err){
        console.error("Error while trying to copy contents!\n" + err);
    }
}