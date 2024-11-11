<?php
    //A function that generates a random string to put into the user post field
    function userpostplaceholder(){
        $messages = [ "What's your message for the day?", "What's something you're looking forward to?", "Share your thoughts with the world!", "What are you (over)thinking about?", "Inspire others with your thoughts!", "What made you smile today?", "Tell us your story!", "Start a new conversation!", "What's happening in your world?", "Share the good vibes!", "Tell us your favourite moment of today!", "What are you grateful for today?", "Tell us something we don't know!" ];
        $number = random_int(0, count($messages) - 1);
        return $messages[$number];;
    }
?>
<!-- Quill stylesheet -->
<link rel="stylesheet" href="/public/dist/quill/quill.snow.css">

            <div class="col-xs-12 col-lg-7" id="posts">
            <!-- The div the user can post in -->
                <div class="card postpad-container">
                    <div class="card-header">
                        <!-- Input selectors -->
                        <ul class="nav nav-tabs" id="inputTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basicInput" data-bs-toggle="tab" data-bs-target="#basicInputTab" type="button" aria-controls="basicInput" aria-selected="true">Basic input</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="advancedInput" data-bs-toggle="tab" data-bs-target="#advancedInputTab" type="button" aria-controls="details">Advanced Editor</button>
                            </li>
                        </ul>
                        <!-- Input selectors END -->
                        <div class="tab-content" id="inputTabsContent">
                            <!-- Basic input tab -->
                            <div class="tab-pane fade show active" id="basicInputTab" aria-labelledby="basicInput">
                                <textarea id="postpad-userpost" class="postpad-userpost form-control" maxlength="400" oninput="countCharacters()" placeholder="<?php echo userpostplaceholder(); ?>"></textarea>
                                <span id="userpost-miscelements">
                                    <small class="charcount" id="charcount"></small>
                                    <button id="sendButton" class="btn PostPadLightElement" style="float: right;" onclick="newpost()">Post!</button>
                                </span>
                            </div>
                            <!-- Basic input tab END -->

                            <!-- Advanced input tab -->
                            <div class="tab-pane fade" id="advancedInputTab" aria-labelledby="advancedInput">
                                    <div id="quillEditor">
                                    </div>
                                    <br>
                                    <span id="quillpost-miscelements">
                                        <small class="charcount" id="charCountQuill"></small>
                                        <button id="sendButtonQuill" class="btn PostPadLightElement" style="float: right;" onclick="newpostquill()">Post!</button>
                                    </span>
                                    
                            </div>
                            <!-- Advanced input tab END -->
                        </div>
                        <div>
                            <!-- Content Warning checkboxes -->
                            <div class="cwcheckbox textColorOverride" id="cw-general">
                                <input type="checkbox" class="cwcheck" name="cw-general-check" id="cw-general-check">
                                <label class="cwchecklabel" for="cw-general-check" alt="General Content Warning" title="General Content Warning"><b>CW</b></label>

                                <input type="checkbox" class="cwcheck" name="cw-nsfw-check" id="cw-nsfw-check">
                                <label class="cwchecklabel" for="cw-nsfw-check" alt="General Content Warning" title="Not Safe For Work Warning"><b>NSFW</b></label>
                            </div>
                        </div>
                        
                    </div>

                    <div id="postpad-announcement" class="bg-warning text-center justify-content-around">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-warning"></i>
                            </div>

                            <div class="col-8">
                                <b><a class="text-dark" target="_blank" id="announcement-title">Announcement title</a></b>
                            </div>

                            <div class="col-1">
                                <i class="fa fa-warning"></i>
                            </div>
                            <div class="col-1" >
                                <button id="dismissAnnounceBtn" class="btn" onclick="dismissAnnouncement()"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>

                    <span id="everypost">
                        <p class="text-center text-white"><i class="fa-solid fa-circle-notch fa-spin"></i></p>
                    </span>
                </div>
            </div>

<script src="/public/dist/quill/quill.js"></script>
<script src="/public/res/script/homePageQuill.js"></script>

<script src="/public/res/script/homepage.js"></script>
<script src="/public/res/script/postload.js"></script>
<script src="/public/res/script/announcement.js"></script>
<script src="/public/res/script/blurLogic.js"></script>

<script>
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
</script>