<?php
$pagetitle = "Wallpaper Cropper - Sign In";
$loadingcss = 1;
$fullscreena = 1;
$mainoptions=1;
$signup=1;
$formfields=1;
include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-flex" >
  <div class="main-options-container">

    <div class="small-container">

    <h1 class="header-index">LOG-IN TO CREATE &amp; SHARE</h1>

    <div class="fullscreen-container">

      <?php if (isset($_GET['typea'])) { $typea = $_GET['typea']; ?>
            <?php if ($typea == "nothingset") { ?>
              <p class="errormessage">ERROR: NO FILE OR URL</p>
            <?php } ?>
            <?php if ($typea == "invalidfetch") { ?>
              <p class="errormessage">There was an error fetching the image from the URL you entered, please try again.</p>
            <?php } ?>
            <?php if ($typea == "filetoobig") { ?>
              <p class="errormessage">The file you tried to upload/fetch was too large. The max file size accepted is 5MB</p>
            <?php } ?>
            <?php if ($typea == "deleted") { ?>
              <p class="errormessage">Your image has been deleted from our server</p>
            <?php } ?>
            <?php if ($typea == "invalidimagetype") { ?>
              <p class="errormessage">Invalid file type!!!</p>
            <?php } ?>
            <?php if ($typea == "noaccount") { ?>
              <p class="errormessage">That Email address is invalid or unverified. The account may also be locked, who knows?</p>
            <?php } ?>
            <?php if ($typea == "passwordfail") { ?>
              <p class="errormessage">Incorrect password used</p>
            <?php } ?>
            <?php if ($typea == "nowsignedup") { ?>
              <p class="errormessage">You are signed up, you can now log in with your Email and Password</p>
            <?php } ?>
            <?php if ($typea == "socialerror") { ?>
              <p class="errormessage">Login fail, please try again</p>
            <?php } ?>
      <?php }?>

              <div class="main-options">

                <label>Login With Email</label>

                <form  method="post" action="<?php echo $base_url; ?>/login/email/" enctype="multipart/form-data" name="imagechoice">

                  <input class="form-field2 loginform" placeholder="Email" type="text" name="email">
                  <input class="form-field2 loginform" placeholder="Password" type="password" name="password">

                  <a class="signup-link" href="<?php echo $base_url; ?>/signup/">Sign Up</a>
                  <input  class="submit2" type="submit" value="Login" onclick="loading_logingin();" />

                </form>

              </div>

    </div>
  </div>
  </div>
</section>





<div id="loading" style="background:url('<?php echo $bgimage; ?>'); background-repeat:no-repeat; background-size:cover; background-position:50% 50%; background-attachment: fixed;">
  <div id="innerloading">
    <div class="loading-frame">
          <div class="sk-cube-grid">
            <div class="sk-cube sk-cube1"></div>
            <div class="sk-cube sk-cube2"></div>
            <div class="sk-cube sk-cube3"></div>
            <div class="sk-cube sk-cube4"></div>
            <div class="sk-cube sk-cube5"></div>
            <div class="sk-cube sk-cube6"></div>
            <div class="sk-cube sk-cube7"></div>
            <div class="sk-cube sk-cube8"></div>
            <div class="sk-cube sk-cube9"></div>
          </div>

          <h5 class="loggingin">Logging In!</h5>
          <h6>This may take a while depending on connection speeds, please do not refresh the page.</h6>

    </div>
  </div>
</div>

<script>
function loading_logingin(){
  $( ".submit" ).hide();
  $( "#loading" ).fadeIn( "fast", function() {
    // Animation complete
  });
}
</script>


<script>
    function getFile(){
      document.getElementById("files").click();
    }

    function sub(obj){
       var file = obj.value;
       var fileName = file.split("\\");
          event.preventDefault();
    }

    function handleFileSelect(evt) {
      var files = evt.target.files; // FileList object
      // files is a FileList of File objects. List some properties.
      var output = [];
      for (var i = 0, f; f = files[i]; i++) {
      if(f.size > 10120000){
      output.push( 'WARNING: FILE SELECTED IS OVER 10MB');
      }else{
          output.push(escape(f.name), ' - ', Math.round((f.size / 1024000)*100)/100, 'MB\'s');
      }
      }
     document.getElementById("uploadfile").innerHTML = output.join('');

     var output = document.querySelector('.output');
     output.innerHTML = '';
     for(var i=0; i<files.length; i++) {
       if(files[i].type.indexOf('image/') === 0) {
         output.innerHTML += '<img class="preview" src="' + URL.createObjectURL(files[i]) + '" />';

         document.getElementById('output_message').innerHTML = "";
         $(".preview" ).removeClass("warning");


             if(files[i].size > 1000000){
             document.getElementById('output_message').innerHTML = "WARNING: FILE SELECTED IS OVER 10MB";
             $(".preview" ).addClass("warning");
           }

       }
       }

    }
    document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>

<script>
  (function(window) {
    function triggerCallback(e, callback) {
      if(!callback || typeof callback !== 'function') {
        return;
      }
      var files;
      if(e.dataTransfer) {
        files = e.dataTransfer.files;
      } else if(e.target) {
        files = e.target.files;
      }
      callback.call(null, files);
    }

    function makeDroppable(ele, callback) {
      var input = document.getElementById("draggedfiles");
      input.addEventListener('change', function(e) {
        triggerCallback(e, callback);
      });

      ele.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.add('dragover');
      });

      ele.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.remove('dragover');
      });

      ele.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.remove('dragover');

        triggerCallback(e, callback);

      });

    }
    window.makeDroppable = makeDroppable;
  })(this);
  (function(window) {
    makeDroppable(window.document.querySelector('.droppable'), function(files) {
      console.log(files);
      var output = document.querySelector('.output');
      output.innerHTML = '';
      for(var i=0; i<files.length; i++) {
        if(files[i].type.indexOf('image/') === 0) {

          output.innerHTML += '<img class="preview" src="' + URL.createObjectURL(files[i]) + '" />';
          var fileInput = document.getElementById("draggedfiles");
          fileInput.files = files;
        }
        document.getElementById("uploadfile").innerHTML = files[i].name;
        }
    });
  })(this);
</script>
<?php include($php_base_directory . 'includes/footer.php');?>
