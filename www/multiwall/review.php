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

    $thumb16by9 = $row['thumbnail'];
    $thumb16by10 = $row['16by10thumb'];
    $thumb4by3 = $row['4by3thumb'];
    $thumb5by4  = $row['5by4thumb'];
    $thumbmobile = $row['mobilethumb'];

    $done_16by9_recrop = $row['16by9_recrop'];
    $done_16by10_recrop = $row['16by10_recrop'];
    $done_4by3_recrop = $row['4by3_recrop'];
    $done_5by4_recrop = $row['5by4_recrop'];
    $done_mobile_recrop = $row['mobile_recrop'];
    $done_reviewed = $row['reviewed'];

    $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);
    $thumb16by10 = str_replace($php_base_directory, $base_url . "/", $thumb16by10);
    $thumb4by3 = str_replace($php_base_directory, $base_url . "/", $thumb4by3);
    $thumb5by4 = str_replace($php_base_directory, $base_url . "/", $thumb5by4);
    $thumbmobile = str_replace($php_base_directory, $base_url . "/", $thumbmobile);

    $replace = $base_url . "/";
  }
  if ($logged_in_id == $owner) {


    $pagetitle = "Wallpaper Cropper - Wallpaper Review";
    $loadingcss = 1;
    $multiheader = 1;
    $mainoptions = 1;
    $fullscreenb = 1;
    $selectize = 1;
    $formfields = 1;
    include($php_base_directory . 'includes/header.php');
?>



    <section id="fullscreen-flex">
      <div class="main-options-container-b">






        <div class="multi-header">
          <h1>LAST STAGE - WALLPAPER REVIEW</h1>
        </div>

        <div class="sub-header-multiwall">
          <a class="multi-stage-on border" href="<?php echo $base_url; ?>/16by9select/<?php echo $id; ?>/">16by9</a>
          <?php if ($done_16by9_recrop == 0) { ?><div class="multi-stage-off border">16by10</div><?php } else { ?><a class="multi-stage-on border" href="<?php echo $base_url; ?>/16by10select/<?php echo $id; ?>/">16by10</a><?php } ?>
          <?php if ($done_16by10_recrop == 0) { ?><div class="multi-stage-off border">4by3</div><?php } else { ?><a class="multi-stage-on border" href="<?php echo $base_url; ?>/4by3select/<?php echo $id; ?>/">4by3</a><?php } ?>
          <?php if ($done_4by3_recrop == 0) { ?><div class="multi-stage-off border">5by4</div><?php } else { ?><a class="multi-stage-on border" href="<?php echo $base_url; ?>/5by4select/<?php echo $id; ?>/">5by4</a><?php } ?>
          <?php if ($done_5by4_recrop == 0) { ?><div class="multi-stage-off border">Mobile</div><?php } else { ?><a class="multi-stage-on border" href="<?php echo $base_url; ?>/mobileselect/<?php echo $id; ?>/">Mobile</a><?php } ?>
          <?php if ($done_16by9_recrop == 1 && $done_16by10_recrop == 1 && $done_4by3_recrop == 1 && $done_5by4_recrop == 1 && $done_mobile_recrop == 1) {
          ?><a class="multi-stage-current" href="<?php echo $base_url; ?>/review/<?php echo $id; ?>/">Review</a><?php } else { ?><div class="multi-stage-off">Review</div><?php } ?>
        </div>

        <div class="fullscreen-container-b">

          <?php if ($typeb == "notcat") { ?>
            <p class="errormessage">YOU MUST PUT YOUR WALLPAPER INTO A CATEGORY</p>
          <?php } ?>

          <div class="review-left">
            <div class="review-left-inner">

              <h4>Click on thumbnail to recrop</h4>

              <div class="thumb-block">

                <h3>16 by 9</h3>
                <a href="<?php echo $base_url; ?>/16by9select/<?php echo $id; ?>/"><img src="<?php echo $thumb16by9; ?>" class="review-thumb" /></a>

                <h3>Mobile</h3>
                <a href="<?php echo $base_url; ?>/mobileselect/<?php echo $id; ?>/"><img src="<?php echo $thumbmobile; ?>" class="review-thumb" /></a>

              </div>

              <div class="thumb-block">

                <h3>16 by 10</h3>
                <a href="<?php echo $base_url; ?>/16by10select/<?php echo $id; ?>/"><img src="<?php echo $thumb16by10; ?>" class="review-thumb" /></a>

                <h3>4 by 3</h3>
                <a href="<?php echo $base_url; ?>/4by3select/<?php echo $id; ?>/"><img src="<?php echo $thumb4by3; ?>" class="review-thumb" /></a>

                <h3>5 by 4</h3>
                <a href="<?php echo $base_url; ?>/5by4select/<?php echo $id; ?>/"><img src="<?php echo $thumb5by4; ?>" class="review-thumb" /></a>

              </div>

              <a class="delete-button" onclick="loading();" href="<?php echo $base_url; ?>/delete-multiwall/<?php echo $id ?>/">SCRAP AND DELETE</a>

            </div>
          </div>


          <div class="review-right">
            <form id="reviewform" action="<?php echo $base_url; ?>/submitwall/<?php echo $iid ?>/" method="post" onsubmit="return checkCoords();">

              <label for="title">Give your wallpaper a title (optional)</label>
              <input class="form-field" type="text" name="title">

              <div class="dropdown-select">
                <div class="control-group">
                  <label for="category"><strong>Select categories (not optional)</strong></label>
                  <select id="select-category" name="category[]" multiple style="width:100%" placeholder="Select categories">
                    <?php
                    $res = $db->sql("SELECT * FROM category ORDER BY cat_name ASC");
                    while ($row = $res->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['cat_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <script>
                  $('#select-category').selectize();
                </script>
              </div>


              <div class="thetagsspacer"></div>

              <label for="input-tags">Tags (seperate with ',' comma)</label>
              <input type="text" id="input-tags" name="tags" value="">

              <script class="show">
                $('#input-tags').selectize({
                  delimiter: ',',
                  persist: false,
                  create: function(input) {
                    return {
                      value: input,
                      text: input
                    }
                  }
                });
              </script>



              <div class="dropdown-select">
                <div class="control-group">
                  <label for="collection"><strong>Add to collection</strong> <small>(Simply type to add new)</small></label>
                  <select id="select-collection" name="collection[]" multiple style="width:100%">
                    <?php
                    $resf = $db->sql("SELECT * FROM collections WHERE owner_id=? ORDER BY name ASC", 'i', $logged_in_id);
                    while ($rowf = $resf->fetch_assoc()) { ?>
                      <option value="<?php echo $rowf['name']; ?>"><?php echo $rowf['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <script>
                  $('#select-collection').selectize({
                    create: true,
                    sortField: {
                      field: 'text',
                      direction: 'asc'
                    },
                    dropdownParent: 'body'
                  });
                </script>
              </div>




              <label for="credit">Credit Image Source (optional)</label>
              <input class="form-field-blue" type="text" name="credit">


              <input class="submit" type="submit" value="Submit Wallpaper" id="submit" onclick="loading();" />

            </form>
          </div>



        </div>



      </div>
    </section>


    <script>
      $('#reviewform').submit(function() {
        $("input[type='submit']", this)
          .attr('disabled', 'disabled');
        return true;
      });
    </script>

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
          <h5>Submitting your handy work!</h5>
          <h6>This may take a while, please do not refresh the page.</h6>
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