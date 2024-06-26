<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $iid = $typea;

  $res = $db->sql("SELECT * FROM newprofilephotos WHERE id=? ORDER BY id DESC LIMIT 1", 'i', $iid);
  while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $owner = $row['user_id'];
    $imagefile = $row['file'];
    $imgwidth = $row['imgwidth'];
    $imgheight = $row['imgheight'];

    $replace = $base_url . "/";
    $imagefile = str_replace($php_base_directory, $replace, $imagefile);
  }
  if ($logged_in_id == $owner) {


    $pagetitle = "Wallpaper Cropper - Profile crop";
    $loadingcss = 1;
    $jcrop = 1;
    $mainoptions = 1;
    $fullscreenb = 1;
    include($php_base_directory . 'includes/header.php');
?>

    <script>
      $(function() {

        $('#cropbox').Jcrop({
          aspectRatio: <?php echo 1 / 1; ?>,
          onSelect: updateCoords
        });

      });

      function updateCoords(c) {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
      };

      function checkCoords() {
        if (parseInt($('#w').val())) return true;
        alert('Please select a crop region then press submit.');
        return false;
      };
    </script>


    <section id="fullscreen-flex" style="background:url('<?php echo $bgimage; ?>'); background-repeat:no-repeat; background-size:cover; background-position:50% 50%; background-attachment: fixed;">
      <div class="main-options-container-b">

        <h1 class="header-index-b">Crop Your Profile Photo</h1>

        <div class="fullscreen-container-b">

          <img src="<?php echo $imagefile ?>" class="cropbox" id="cropbox" alt="Your Image" />

          <form action="<?php echo $base_url; ?>/profilephotosubmit/<?php echo $iid ?>/" method="post" onsubmit="return checkCoords();">
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />

            <input type="hidden" id="user_width" name="user_width" value="650" />

            <input class="submit" type="submit" value="Update Profile Photo" id="submit" onclick="loading();" />
          </form>

          <script>
            $(window).load(function() {
              var loadedcropperwidth = $("#cropbox").width();
              $("#user_width").val(loadedcropperwidth);
            });
            $(window).resize(function() {
              var cropperwidth = $("#cropbox").width();
              $("#user_width").val(cropperwidth);
            });
          </script>

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
          <h5>Cropping your image!</h5>
          <h6>This may take a while depending on image size, please do not refresh the page.</h6>
        </div>
      </div>
    </div>


    <?php include($php_base_directory . 'includes/footer.php'); ?>
<?php
  } else {
    $location = "Location: " . $base_url;
    log_malicious();
    header($location);
    exit();
  }
} ?>