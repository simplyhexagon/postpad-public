  </div>

    <!--hr>

    <div class="row justify-content-center">
        <div class="col-xs-12 col-lg-4 text-center">
            <button class="btn PostPadLightElement" onclick="fillPosts()">Load more posts</button>
        </div>
    </div-->
  </div>
</section>


<!-- Common modal instead of alert() -->
<div class="modal fade" id="custommodal" tabindex="-1" role="dialog" aria-labelledby="custommodallabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
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
</script>
<script src="/public/res/script/share.js" type="text/javascript"></script>
</body>
</html>