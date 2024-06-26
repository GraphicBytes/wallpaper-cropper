<?php
if ($logged_in_id == 0) {
  log_malicious();
  $location = "Location: " . $base_url;
  header($location);
  exit();
} else {

  if ($logged_in_id == 1) {

      $pagetitle = "Wallpaper Cropper - Moderate";
      $loadingcss = 1;
      $selectize = 1;
      $mainoptions=1;
      $fullscreenb=1;
      $formfields=1;
      include($php_base_directory . 'includes/header.php');

      $id = null;
      $creation_id = null;

      $mysqlquery="SELECT * FROM wallpapers WHERE moderated='0' ORDER BY id DESC LIMIT 1";
      $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
      while($row=$res->fetch_assoc()) {
      	$id = $row['id'];
        $owner = $row['owner'];

        $highlight = $row['highlight'];

        $creation_id = $row['creation_id'];

        $thumb16by9 = $row['16by9thumb'];
        $thumb16by10 = $row['16by10thumb'];
        $thumb4by3 = $row['4by3thumb'];
        $thumb5by4  = $row['5by4thumb'];
        $thumbmobile = $row['mobilethumb'];

        //16by9
        $image_1280x720 = $row['1280x720'];
        $image_1920x1080 = $row['1920x1080'];
        $image_2560x1440 = $row['2560x1440'];
        $image_3840x2160 = $row['3840x2160'];

        //16by10
        $image_1280x800 = $row['1280x800'];
        $image_1680x1050  = $row['1680x1050'];
        $image_1920x1200 = $row['1920x1200'];
        $image_2560x1600 = $row['2560x1600'];

        //4by3
        $image_1024x768 = $row['1024x768'];
        $image_1400x1050 = $row['1400x1050'];
        $image_2048x1536 = $row['2048x1536'];
        $image_2800x2100 = $row['2800x2100'];

        //4by4
        $image_1280x1024 = $row['1280x1024'];
        $image_2560x2048 = $row['2560x2048'];

        //mobile
        $image_mobilesmall = $row['mobilesmall'];
        $image_mobilemedium = $row['mobilemedium'];
        $image_mobilestandard = $row['mobilestandard'];
        $image_mobilelarge = $row['mobilelarge'];



        $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);
        $thumb16by10 = str_replace($php_base_directory, $base_url . "/", $thumb16by10);
        $thumb4by3 = str_replace($php_base_directory, $base_url . "/", $thumb4by3);
        $thumb5by4 = str_replace($php_base_directory, $base_url . "/", $thumb5by4);
        $thumbmobile = str_replace($php_base_directory, $base_url . "/", $thumbmobile);

        $replace=$base_url . "/";

        $title = $row['title'];
        $credit = $row['image_credit'];
      }




      $mysqlqueryb="SELECT * FROM wall_generation WHERE id='$creation_id' ORDER BY ID DESC LIMIT 1";
      $resb=$dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
      while($rowb=$resb->fetch_assoc()) {

        $originalimage = $rowb['imagefile'];

        $originalimage = str_replace($php_base_directory, $base_url . "/", $originalimage);

      }

      ?>

      <section id="fullscreen-flex" class="droppable">
        <div class="main-options-container-b">
          <div class="fullscreen-container-b">


    <?php if ($id == "" or $id == null) {?>

      <h2 style="margin:15px 0 20px 0;padding:0 0 0 0; border-bottom:none;">NO WALLPAPPERS TO MODERATE</h2>

    <?php } else {?>

    <h2 style="margin:15px 0 20px 0;padding:0 0 0 0; border-bottom:none;">WALLPAPER MODERATE</h2>



      <div class="review-left">

        <div class="review-left-inner">

          <div class="thumb-block">

                <h3>16 by 9</h3>

                <img src="<?php echo $thumb16by9;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_1280x720 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_1920x1080 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_2560x1440 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_3840x2160 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                </div>

                <h3>Mobile</h3>
                <img src="<?php echo $thumbmobile;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if( $image_mobilesmall == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_mobilemedium == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if( $image_mobilestandard == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_mobilelarge == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                </div>

          </div>

          <div class="thumb-block">

                <h3>16 by 10</h3>
                <img src="<?php echo $thumb16by10;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_1280x800 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_1680x1050 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_1920x1200 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_2560x1600 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                </div>

                <h3>4 by 3</h3>
                <img src="<?php echo $thumb4by3;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_1024x768 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_1400x1050 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_2048x1536 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:25%; height:15px; background:<?php if($image_2800x2100 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                </div>

                <h3>5 by 4</h3>
                <img src="<?php echo $thumb5by4;?>" class="review-thumb" />
                <div style="display:flex; margin:-5px 0 10px 0;">
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:50%; height:15px; background:<?php if( $image_1280x1024 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                <div style="display:inline-block; margin:0 0 0 0; pading:0; width:50%; height:15px; background:<?php if($image_2560x2048 == null){echo "#797979";}else{echo "#00d30a";} ?>;"></div>
                </div>

          </div>

          <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:#000;font-weight: bold;text-decoration: none;text-align: center;
          " onclick="loading();" href="<?php echo $base_url; ?>/noapprove/<?php echo $id ?>/">DELETE</a>


          <h2 style="margin:70px 0 10px 0;padding:0 0 0 0; border-bottom:none;">Not safe for work</h2>

          <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:#000;font-weight: bold;text-decoration: none;text-align: center;
          " onclick="loading();" href="<?php echo $base_url; ?>/approve/<?php echo $id ?>/nsfwhq/">HIGH QUALITY</a>

          <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:#000;font-weight: bold;text-decoration: none;text-align: center;
          " onclick="loading();" href="<?php echo $base_url; ?>/approve/<?php echo $id ?>/nsfwlq/">LOW QUALITY</a>


        </div>

      </div>


      <div class="review-right">

              <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:<?php if ($highlight==1){echo "#3a7bd5";}else{echo "#000";} ?>; font-weight: bold;text-decoration: none;text-align: center;" onclick="loading();" href="<?php echo $base_url; ?>/approve/<?php echo $id ?>/highlight/">MARK AS HIGHLIGHT</a>

              <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:#000;font-weight: bold;text-decoration: none;text-align: center;" target="_blank" href="<?php echo $originalimage ?>">VIEW ORIGINAL IMAGE</a>

        <form action="<?php echo $base_url; ?>/approve/<?php echo $id ?>/recat/" method="post">

        <label for="title">Wallpaper Title</label>
        <input class="form-field" type="text" name="title" value="<?php echo $title; ?>">

        <div class="dropdown-select">
          <div class="control-group">
            <label for="category"><strong>Categories</strong></label>
            <select id="select-category" name="category[]" multiple style="width:100%" placeholder="Select categories">
              <?php
              $selected=null;
              $mysqlquery="SELECT * FROM category ORDER BY cat_name ASC";
              $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
              while($row=$res->fetch_assoc()) {
                $catid = $row['id'];
                ?>

                    <?php
                    $mysqlqueryf="SELECT * FROM category_links WHERE wallpaper_id='$id' AND category_id = '$catid' ORDER BY id DESC";
                    $resf=$dbconn->query($mysqlqueryf) or die(mysqli_error($dbconn));
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
        $mysqlquery="SELECT * FROM tag_links INNER JOIN tags ON tag_links.tag_id = tags.id WHERE tag_links.wallpaper_id='$id' ORDER BY tags.tag_name ASC";
        $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
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


        <input class="submit" type="submit" value="Re-Categorise" id="submit" onclick="loading();" />


        </form>


        <div style="display:block; width:100%;">


          <h2 style="margin:60px 0 10px 0;padding:0 0 0 0; border-bottom:none;">Safe for work</h2>

          <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:#000;font-weight: bold;text-decoration: none;text-align: center;
          " onclick="loading();" href="<?php echo $base_url; ?>/approve/<?php echo $id ?>/sfwhq/">HIGH QUALITY</a>

          <a style="display: block;width:100%;font-size: 12px;height:35px;line-height:35px;padding:5px; margin:0 auto 25px auto;color:#fff; background:#000;font-weight: bold;text-decoration: none;text-align: center;
          " onclick="loading();" href="<?php echo $base_url; ?>/approve/<?php echo $id ?>/sfwlq/">LOW QUALITY</a>

        </div>




      </div>

    <?php } ?>




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

<div id="loading">
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

<?php   } else { $location = "Location: " . $base_url;
  header($location);
  exit();
}}?>
