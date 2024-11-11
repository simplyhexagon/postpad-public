<footer class="transparentbg">
  <div class="footer">
    <div class="row">
      <div class="col-12 text-center">
        <div id="cookie-notice">
          <p> 
            <?php echo APP_NAME; ?> uses cookies to provide its services to its users<br>
            For more information, check our <u><a href="/documents/privacy" class="hyperlinkOverride" target="_blank">Privacy Policy</a></u>  
          </p>
          <button id="close-cookie-notice">&times;</button>
          <hr>
        </div>
        <p>
          Copyright &copy; <?php echo (date("Y") == "2023")? "2023" : "2023-" . date("Y") ?>
        </p>
      </div>
    </div>
  </div>
</footer>

<!-- Common modal instead of alert() -->
<div class="modal fade" id="custommodal" tabindex="1" role="dialog" aria-labelledby="custommodallabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="custommodallabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="custommodalbody">
        ...
      </div>
      <div class="modal-footer">
	      <button type="button" class="btn bg-green" id="custommodalconfirmbutton">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="custommodalclosebutton">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Common modal instead of alert() END -->


<!-- Small message modal -->

<div class="modal" id="messagemodal" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-bottom" role="document">
    <div class="modal-content">
      <div class="modal-body" id="messagemodalbody">
        ...
      </div>
    </div>
  </div>
</div>

<!-- Small message modal END -->


<!-- Necessary scripts-->
<script>
    //Enable tooltips
    $(function() {
      $("[data-toggle='tooltip']").tooltip();
    });

    function showcustommodal(title, content, yesbutton = false, callback = false){
        document.getElementById("custommodallabel").innerHTML = title;
        document.getElementById("custommodalbody").innerHTML = content;

        if(yesbutton && callback){
            document.getElementById("custommodalconfirmbutton").style.display = "block";
            document.getElementById("custommodalconfirmbutton").innerHTML = "Yes";
            document.getElementById("custommodalclosebutton").innerHTML = "No";

            $('#custommodal').modal("show");

            $('#custommodalclosebutton').click(function(){
                $('#custommodal').modal('hide');
                if (callback) callback(false);

            });
            $('#custommodalconfirmbutton').click(function(){
                $('#custommodal').modal('hide');
                if (callback) callback(true);
            });
        }
        else{
            document.getElementById("custommodalconfirmbutton").style.display = "none";
            document.getElementById("custommodalconfirmbutton").innerHTML = "Unusable";
            document.getElementById("custommodalclosebutton").innerHTML = "Close";

            $('#custommodal').modal('show');
        }
    }

    function showmessagemodal(message){
      document.getElementById("messagemodalbody").innerHTML = message;
      $('#messagemodal').modal("show");
      setTimeout(function(){
        $('#messagemodal').modal("hide");
      }, 1000);
    }

    //Cookie consent dialog stuff
    // Function to set a cookie when the notice is closed
    function setCookie(cookieName, cookieValue, expirationDays) {
        const date = new Date();
        date.setTime(date.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
    }

    // Function to check if the cookie is set
    function checkCookie(cookieName) {
        return document.cookie.indexOf(cookieName) !== -1;
    }

    const cookieNotice = document.getElementById("cookie-notice");
    const closeCookieNotice = document.getElementById("close-cookie-notice");

    // Check if the cookie is set; if not, display the notice
    if (!checkCookie("cookieConsent")) {
        cookieNotice.style.display = "block";
    }

    // Add an event listener to the close button
    closeCookieNotice.addEventListener("click", function () {
        cookieNotice.style.display = "none";
        setCookie("cookieConsent", "true", 365); // Set the cookie to expire in 365 days
    });

</script>
<script src="/public/res/script/share.js" type="text/javascript"></script>
</body>
</html>