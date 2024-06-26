<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $iid = $typea;

  $res = $db->sql("SELECT * FROM wall_generation WHERE id=? AND complete = '0' ORDER BY ID DESC LIMIT 1", 'i', $iid);
  while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $owner = $row['owner'];
    $imagefile = $row['imagefile'];
    $imgwidth = $row['imgwidth'];
    $imgheight = $row['imgheight'];

    $done_16by9_recrop = $row['16by9_recrop'];
    $done_16by10_recrop = $row['16by10_recrop'];
    $done_4by3_recrop = $row['4by3_recrop'];
    $done_5by4_recrop = $row['5by4_recrop'];
    $done_mobile_recrop = $row['mobile_recrop'];
    $done_reviewed = $row['reviewed'];

    $replace = $base_url . "/";
    $imagefile = str_replace($php_base_directory, $replace, $imagefile);
  }
  if ($logged_in_id == $owner) {


    $pagetitle = "Wallpaper Cropper - The Mobile Crop";
    $loadingcss = 1;
    $jcrop = 1;
    $multiheader = 1;
    $mainoptions = 1;
    $fullscreenb = 1;
    $formfields = 1;
    include($php_base_directory . 'includes/header.php');
?>

    <script>
      $(function() {

        $('#cropbox').Jcrop({
          aspectRatio: <?php echo 9 / 16; ?>,
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
        $("#loading").fadeOut("fast", function() {
          $("#submit").show();
        });
        return false;
      };
    </script>


    <section id="fullscreen-flex">
      <div class="main-options-container-b">

        <div class="multi-header">
          <h1>Crop 5/5</h1>
          <h2>MOBILE (GENERIC RATIO)</h2>
          <h3>For the best results use as much of the image as possible!</h3>
        </div>

        <div class="sub-header-multiwall">
          <a class="multi-stage-on border" href="<?php echo $base_url; ?>/16by9select/<?php echo $id; ?>/">16by9</a>
          <?php if ($done_16by9_recrop == 0) { ?><div class="multi-stage-off border">16by10</div><?php } else { ?><a class="multi-stage-on border" href="<?php echo $base_url; ?>/16by10select/<?php echo $id; ?>/">16by10</a><?php } ?>
          <?php if ($done_16by10_recrop == 0) { ?><div class="multi-stage-off border">4by3</div><?php } else { ?><a class="multi-stage-on border" href="<?php echo $base_url; ?>/4by3select/<?php echo $id; ?>/">4by3</a><?php } ?>
          <?php if ($done_4by3_recrop == 0) { ?><div class="multi-stage-off border">5by4</div><?php } else { ?><a class="multi-stage-on border" href="<?php echo $base_url; ?>/5by4select/<?php echo $id; ?>/">5by4</a><?php } ?>
          <?php if ($done_5by4_recrop == 0) { ?><div class="multi-stage-off border">Mobile</div><?php } else { ?><a class="multi-stage-current border" href="<?php echo $base_url; ?>/mobileselect/<?php echo $id; ?>/">Mobile</a><?php } ?>
          <?php if ($done_16by9_recrop == 1 && $done_16by10_recrop == 1 && $done_4by3_recrop == 1 && $done_5by4_recrop == 1 && $done_mobile_recrop == 1) {
          ?><a class="multi-stage-on" href="<?php echo $base_url; ?>/review/<?php echo $id; ?>/">Review</a><?php } else { ?><div class="multi-stage-off">Review</div><?php } ?>
        </div>

        <div class="fullscreen-container-b">

          <form action="<?php echo $base_url; ?>/mobilecrop/<?php echo $iid ?>/" method="post" onsubmit="return checkCoords();">

            <input class="submit3" type="submit" value="Submit &amp; Continue" onclick="loading();" />

            <img src="<?php echo $imagefile ?>" class="cropbox" id="cropbox" alt="Your Image" data-pagespeed-no-defer data-pagespeed-no-transform />

            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />

            <input type="hidden" id="user_width" name="user_width" value="650" />

            <input class="submit" type="submit" value="Submit &amp; Continue" id="submit" onclick="loading();" />
          </form>

          <a class="delete-button2" onclick="loading();" href="<?php echo $base_url; ?>/delete-multiwall/<?php echo $id ?>/">SCRAP AND DELETE</a>

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