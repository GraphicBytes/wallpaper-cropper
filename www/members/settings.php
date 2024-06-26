<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {
      $pagetitle = "Wallpaper Cropper - Your Site Settings";
      $fullscreena = 1;
      $mainoptions=1;
      $formfields=1;
      include($php_base_directory . 'includes/header.php');
?>

      <section id="fullscreen-flex" >
        <div class="main-options-container">

          <div class="small-container">

          <h1 class="header-index">SITE SETTINGS</h1>

          <div class="fullscreen-container">

              <div id="feedback"></div>
                  <?php $notificationcount = 0;
                  $res = $db->sql( "SELECT * FROM users WHERE id=? ORDER BY id", 'i' , $logged_in_id );
                  while($row=$res->fetch_assoc()) {
                    $id=$row['id'];
                    $nsfw=$row['nsfw'];
                    $defaultratio=$row['defaultratio'];
                    $resfilter=$row['resfilter'];
                  ?>

                  <div class="settings-row">
                    <div class="settings-left" >
                      Enable "NOT SAFE FOR WORK" Content:
                    </div>
                    <div class="settings-right" >
                      <label class="switch">
                        <input id="nsfw" type="checkbox" <?php if($nsfw==1){echo "checked";} ?>>
                        <span class="slider round"></span>
                      </label>
                    </div>
                  </div>


                  <div class="settings-row">
                    <div class="settings-left" >
                      View thumbnails at this aspect ratio:
                    </div>
                    <div class="settings-right" >
                      <select class="styled-select blue semi-square" id="defaultratio">
                                <option value="default">DEFAULT</option>
                                <option <?php if($defaultratio=="16by9"){echo "selected";} ?> value="16by9">16 by 9</option>
                                <option <?php if($defaultratio=="mobile"){echo "selected";} ?> value="mobile">Mobile</option>
                                <option <?php if($defaultratio=="16by10"){echo "selected";} ?> value="16by10">16 by 10</option>
                                <option <?php if($defaultratio=="4by3"){echo "selected";} ?> value="4by3">4 by 3</option>
                                <option <?php if($defaultratio=="5by4"){echo "selected";} ?> value="5by4">5 by 4</option>
                      </select>
                    </div>
                  </div>


                  <div class="settings-row">
                    <div class="settings-left" >
                      Hide walls without this resolution available:
                    </div>
                    <div class="settings-right" >
                      <select class="styled-select blue semi-square" id="resfilter">
                                <option value="default">DEFAULT</option>
                                <option disabled value="default">--16 by 9--</option>
                                <option <?php if($resfilter=="1280x720"){echo "selected";} ?> value="1280x720">1280x720</option>
                                <option <?php if($resfilter=="1920x1080"){echo "selected";} ?> value="1920x1080">1920x1080</option>
                                <option <?php if($resfilter=="2560x1440"){echo "selected";} ?> value="2560x1440">2560x1440</option>
                                <option <?php if($resfilter=="3840x2160"){echo "selected";} ?> value="3840x2160">3840x2160</option>
                                <option disabled value="default">--MOBILE--</option>
                                <option <?php if($resfilter=="mobilesmall"){echo "selected";} ?> value="mobilesmall">480x853</option>
                                <option <?php if($resfilter=="mobilemedium"){echo "selected";} ?> value="mobilemedium">720x1280</option>
                                <option <?php if($resfilter=="mobilestandard"){echo "selected";} ?> value="mobilestandard">1080x1920</option>
                                <option <?php if($resfilter=="mobilelarge"){echo "selected";} ?> value="mobilelarge">1800x3200</option>
                                <option disabled value="default">--16 by 10--</option>
                                <option <?php if($resfilter=="1280x800"){echo "selected";} ?> value="1280x800">1280x800</option>
                                <option <?php if($resfilter=="1680x1050"){echo "selected";} ?> value="1680x1050">1680x1050</option>
                                <option <?php if($resfilter=="1920x1200"){echo "selected";} ?> value="1920x1200">1920x1200</option>
                                <option <?php if($resfilter=="2560x1600"){echo "selected";} ?> value="2560x1600">2560x1600</option>
                                <option disabled value="default">--4 by 3--</option>
                                <option <?php if($resfilter=="1024x768"){echo "selected";} ?> value="1024x768">1024x768</option>
                                <option <?php if($resfilter=="1400x1050"){echo "selected";} ?> value="1400x1050">1400x1050</option>
                                <option <?php if($resfilter=="2048x1536"){echo "selected";} ?> value="2048x1536">2048x1536</option>
                                <option <?php if($resfilter=="2800x2100"){echo "selected";} ?> value="2800x2100">2800x2100</option>
                                <option disabled value="default">--5 by 4--</option>
                                <option <?php if($resfilter=="1280x1024"){echo "selected";} ?> value="1280x1024">1280x1024</option>
                                <option <?php if($resfilter=="2560x2048"){echo "selected";} ?> value="2560x2048">2560x2048</option>
                      </select>
                    </div>
                  </div>

                  <?php } ?>
                </div>
            </div>
        </div>
      </section>


      <script>
      $(document).ready(function() {
          //set initial state.
          $('#nsfw').change(function() {

              if($(this).is(':checked')) {
                var url = "<?php echo $base_url ?>/update/nsfw/1/";
                $("#feedback").load(url);
              } else {
                var url = "<?php echo $base_url ?>/update/nsfw/0/";
                $("#feedback").load(url);
              }
          });

          $('#defaultratio').change(function() {

              var url = "<?php echo $base_url ?>/update/defaultratio/" + this.value + "/";
              $("#feedback").load(url);

          });

          $('#resfilter').change(function() {

              var url = "<?php echo $base_url ?>/update/resfilter/" + this.value + "/";
              $("#feedback").load(url);

          });
      });

      </script>

      <?php include($php_base_directory . 'includes/footer.php');?>
<?php }?>
