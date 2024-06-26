<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

          $id = null;
          $creation_id = null;

          $res = $db->sql( "SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $typea );
          while($row=$res->fetch_assoc()) {
            $id = $row['id'];
            $owner = $row['owner'];
            $sfw = $row['sfw'];

            $highlight = $row['highlight'];

            $creation_id = $row['creation_id'];

            $thumb16by9 = $row['16by9thumb'];
            $thumb16by10 = $row['16by10thumb'];
            $thumb4by3 = $row['4by3thumb'];
            $thumb5by4  = $row['5by4thumb'];
            $thumbmobile = $row['mobilethumb'];

            $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);
            $thumb16by10 = str_replace($php_base_directory, $base_url . "/", $thumb16by10);
            $thumb4by3 = str_replace($php_base_directory, $base_url . "/", $thumb4by3);
            $thumb5by4 = str_replace($php_base_directory, $base_url . "/", $thumb5by4);
            $thumbmobile = str_replace($php_base_directory, $base_url . "/", $thumbmobile);

            $replace=$base_url . "/";

            $title = $row['title'];
            $credit = $row['image_credit'];
          }



  if ($logged_in_id == $owner or $logged_in_id == 1) {

      $pagetitle = "Wallpaper Cropper - Edit Wallpaper";
      $loadingcss = 1;
      $multiheader = 1;
      $mainoptions=1;
      $fullscreenb=1;
      $selectize=1;
      $formfields=1;
      include($php_base_directory . 'includes/header.php');
      ?>

      <section id="fullscreen-flex" >
        <div class="main-options-container-b">


    <div class="multi-header">
      <h1>EDIT WALLPAPER</h1>
    </div>

      <div class="fullscreen-container-b">

      <div class="review-left">

        <div class="review-left-inner">

          <div class="thumb-block">

                <h3>16 by 9</h3>

                <img src="<?php echo $thumb16by9;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                </div>

                <h3>Mobile</h3>
                <img src="<?php echo $thumbmobile;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                </div>

          </div>

          <div class="thumb-block">

                <h3>16 by 10</h3>
                <img src="<?php echo $thumb16by10;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                </div>

                <h3>4 by 3</h3>
                <img src="<?php echo $thumb4by3;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                </div>

                <h3>5 by 4</h3>
                <img src="<?php echo $thumb5by4;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                </div>

          </div>

          <a class="delete-button" onclick="loading();" href="<?php echo $base_url; ?>/delete-wall/<?php echo $id ?>/">DELETE</a>

        </div>


      </div>


      <div class="review-right">

        <?php if ($logged_in_id == 1) { ?>
        <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:<?php if ($highlight==1){echo "#3a7bd5";}else{echo "#000";} ?>; font-weight: bold;text-decoration: none;text-align: center;" onclick="loading();" href="<?php echo $base_url; ?>/approve/<?php echo $id ?>/highlight-b/">MARK AS HIGHLIGHT</a>

        <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:<?php if ($sfw==1){echo "#3a7bd5";}else{echo "#000";} ?>; font-weight: bold;text-decoration: none;text-align: center;" onclick="loading();" href="<?php echo $base_url; ?>/approve/<?php echo $id ?>/sfw/"><?php if ($sfw==1){echo "Safe for Work";}else{echo "NOT Safe for Work";} ?></a>
        <?php } ?>

        <form action="<?php echo $base_url; ?>/update-wall/<?php echo $id ?>/" method="post">

        <label for="title">Wallpaper Title</label>
        <input class="form-field" type="text" name="title" value="<?php echo $title; ?>">


        <div class="dropdown-select">
          <div class="control-group">
            <label for="category"><strong>Categories</strong></label>
            <select id="select-category" name="category[]" multiple style="width:100%" placeholder="Select categories">
              <?php
              $selected=null;
              $res = $db->sql( "SELECT * FROM category ORDER BY cat_name ASC" );
              while($row=$res->fetch_assoc()) {
                $catid = $row['id'];
                ?>

                    <?php
                    $resf = $db->sql( "SELECT * FROM category_links WHERE wallpaper_id=? AND category_id = ? ORDER BY id DESC", 'ii' , $id, $catid );
                    while($rowf=$resf->fetch_assoc()) {

                      $selected=" selected";

                    }?>

                <option value="<?php echo $row['id']; ?>" <?php echo $selected;?> ><?php echo $row['cat_name']; ?></option>

              <?php $selected=""; }?>
            </select>
          </div>
          <script>
          $('#select-category').selectize();
          </script>
        </div>

        <div class="thetagsspacer"></div>

        <label for="input-tags">Tags (seperate with ',' comma)</label>
        <input type="text" id="input-tags" name="tags" value="<?php

        $res = $db->sql( "SELECT * FROM tag_links INNER JOIN tags ON tag_links.tag_id = tags.id WHERE tag_links.wallpaper_id=? ORDER BY tags.tag_name ASC", 'i' , $id );
        $commacount = 1;
        while($row=$res->fetch_assoc()) {
          $tag_name = $row['tag_name'];
          $tag_name = ucwords($tag_name);
          $tag_slug = $row['slug'];

          if ($commacount > 1){echo ",";}
          echo $tag_name;
          $commacount = $commacount+1; }
        ?>">

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

        <label for="credit">Credit</label>
        <input class="form-field" type="text" name="credit" value="<?php echo $credit; ?>">

        <input class="submit" type="submit" value="UPDATE" id="submit" onclick="loading();" />

        </form>

      </div>

  </div>
</div>
</section>

<script>
    function loading(){
      $( "#submit" ).hide();
      $( "#loading" ).fadeIn( "fast", function() {
        // Animation complete
      });
    }
</script>

<script>
  for (let input of document.querySelectorAll('#tags')) {
    tagsInput(input);
  }
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
          <h5>Updating Wallpaper Details!</h5>
          <h6>This may take a while depending on image size, please do not refresh the page.</h6>
    </div>
  </div>
</div>



      <?php include($php_base_directory . 'includes/footer.php');?>

<?php   } else {
  $location = "Location: " . $base_url;
    log_malicious();
  header($location);
  exit();
}}?>
