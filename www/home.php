<?php
$pagetitle = "Wallpaper Maker - Create &amp; Share Backgrounds for Iphone, Android &amp; Desktop";
$loadingcss = 1;
$fullscreena = 1;
$mainoptions = 1;
$formfields = 1;
$homepromo = 1;
$mainoptions = 1;
$signup = 1;
$pagenate = 1;
include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-flex" class="droppable homefullscreen" >
  <div class="main-options-container">

    <?php if ($is_malicious == 0) { ?>

      <div class="small-container">

        <h1 class="header-index">CREATE A WALLPAPER</h1>

        <div class="fullscreen-container home">

          <?php if (isset($_GET['typea'])) {
            $typea = $_GET['typea']; ?>
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
          <?php } ?>

          <div class="<?php if ($logged_in_id < 1) { ?>main-options-left<?php } else { ?>main-options<?php } ?>">
            <form method="post" action="<?php echo $base_url; ?>/imagefetch/" enctype="multipart/form-data" name="imagechoice">

              <label for="file_url">Option 1: Input image URL</label>
              <input class="form-field" placeholder="http://" type="text" name="file_url">

              <label for="file">Option 2: Upload An Image</label>
              <div class="form-field" id="uploadfile" onclick="getFile()">click to upload a file</div>
              <div style='height: 0px; width: 0px;overflow:hidden;'>
                <input id="files" type="file" name="files" onchange="sub(this)" accept='image/*' data-max-size="5120" />
                <input id="draggedfiles" type="file" name="draggedfiles" accept='image/*' data-max-size="5120" />
              </div>

              <h5>.JPG .PNG and .GIF - 10MB max</h5>

              <div class="output"></div>

              <input class="submit" type="submit" value="Submit &amp; Continue" onclick="loading();" />
            </form>

          </div>

        </div>

      </div>

    <?php } ?>
  </div>
</section>



<section id="fullscreen-b">
  <div class="full-site-container">
    <h1 class="header-index">Our Latest Wallpapers</h1>
    <div class="wallpaper-thumb-container-index">
      <?php

      if ($resfilter == null or $resfilter == "") {
        $filter = "";
      } else {
        $filter = " AND " . $resfilter . " IS NOT NULL AND " . $resfilter . " <> ''";
      }


      if ($nsfw == 1) {
        $mysqlquery = "SELECT id FROM wallpapers WHERE hq='1' AND moderated='1'$filter";
      } else {
        $mysqlquery = "SELECT id FROM wallpapers WHERE hq='1' AND moderated='1' AND sfw='1'$filter";
      }

      $total = $dbconn->query($mysqlquery);
      $total = $total->num_rows;
      $limit = 24;
      $pages = ceil($total / $limit);

      $page = $typea;
      if ($page == null) {
        $page = 1;
      }
      $offset = ($page - 1)  * $limit;

      ?>

      <div class="pagenavi1">
        <?php $prefix = "new-walls";
        include('includes/pagenate.php'); ?>
      </div>


      <?php
      if ($nsfw == 1) {
        $mysqlquery = "SELECT * FROM wallpapers WHERE hq='1' AND moderated='1'$filter ORDER BY id DESC LIMIT 24 OFFSET $offset";
      } else {
        $mysqlquery = "SELECT * FROM wallpapers WHERE hq='1' AND moderated='1' AND sfw='1'$filter ORDER BY id DESC LIMIT 24 OFFSET $offset";
      }

      $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
      while ($row = $res->fetch_assoc()) {

        if ($defaultratio == "16by9") {
          $thumb = $row['16by9thumb'];
        } else if ($defaultratio == "16by10") {
          $thumb = $row['16by10thumb'];
        } else if ($defaultratio == "4by3") {
          $thumb = $row['4by3thumb'];
        } else if ($defaultratio == "5by4") {
          $thumb = $row['5by4thumb'];
        } else if ($defaultratio == "mobile") {
          $thumb = $row['mobilethumb'];
        } else {
          if ($mobile == 1) {
            $thumb = $row['mobilethumb'];
          } else {
            $thumb = $row['16by9thumb'];
          }
        }

        $thumb = str_replace($php_base_directory, $thumb_url . "/", $thumb);

      ?>

        <div class="wall-box-index">
          <div class="wall-box-inner-index">
            <a class="walllink" href="<?php echo $base_url ?>/view-wall/<?php echo $row['id']; ?>/"><img alt="<?php echo $row['title']; ?>" class="wall-box-image-index" src="<?php echo $thumb; ?>" />
              <?php if ($row['title'] == "" or $row['title'] == null) {
              } else { ?>
                <span class="walltitle"><?php echo $row['title']; ?></span>
              <?php } ?></a>
          </div>
        </div>

      <?php $firstlink = 0;
      } ?>

      <div class="pagenavi2">
        <?php $prefix = "new-walls";
        include('includes/pagenate.php'); ?>
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

      <h5 class="fetching">Fetching your image!</h5>
      <h5 class="loggingin">Logging In!</h5>
      <h6>This may take a while depending on connection speeds, please do not refresh the page.</h6>

    </div>
  </div>
</div>

<script>
  function loading_logingin() {
    $(".submit").hide();
    $(".fetching").hide();
    $("#loading").fadeIn("fast", function() {
      // Animation complete
    });
  }

  function loading() {
    $(".submit").hide();
    $(".loggingin").hide();
    $("#loading").fadeIn("fast", function() {
      // Animation complete
    });
  }
</script>


<script>
  function getFile() {
    document.getElementById("files").click();
  }

  function sub(obj) {
    var file = obj.value;
    var fileName = file.split("\\");
    event.preventDefault();
  }

  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object
    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) {
      if (f.size > 10120000) {
        output.push('WARNING: FILE SELECTED IS OVER 10MB');
      } else {
        output.push(escape(f.name), ' - ', Math.round((f.size / 1024000) * 100) / 100, 'MB\'s');
      }
    }
    document.getElementById("uploadfile").innerHTML = output.join('');

    var output = document.querySelector('.output');
    output.innerHTML = '';
    for (var i = 0; i < files.length; i++) {
      if (files[i].type.indexOf('image/') === 0) {
        output.innerHTML += '<img class="preview" src="' + URL.createObjectURL(files[i]) + '" />';

        document.getElementById('output_message').innerHTML = "";
        $(".preview").removeClass("warning");


        if (files[i].size > 1000000) {
          document.getElementById('output_message').innerHTML = "WARNING: FILE SELECTED IS OVER 10MB";
          $(".preview").addClass("warning");
        }

      }
    }

  }
  document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>

<script>
  (function(window) {
    function triggerCallback(e, callback) {
      if (!callback || typeof callback !== 'function') {
        return;
      }
      var files;
      if (e.dataTransfer) {
        files = e.dataTransfer.files;
      } else if (e.target) {
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
      for (var i = 0; i < files.length; i++) {
        if (files[i].type.indexOf('image/') === 0) {

          output.innerHTML += '<img class="preview" src="' + URL.createObjectURL(files[i]) + '" />';
          var fileInput = document.getElementById("draggedfiles");
          fileInput.files = files;
        }
        document.getElementById("uploadfile").innerHTML = files[i].name;
      }
    });
  })(this);
</script>
<?php include($php_base_directory . 'includes/footer.php'); ?>