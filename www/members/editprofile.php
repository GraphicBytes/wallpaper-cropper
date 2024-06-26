<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {?>

      <?php
      $pagetitle = "Wallpaper Cropper - Edit Your Profile";
      $loadingcss = 1;
      $fullscreena = 1;
      $mainoptions=1;
      $formfields=1;
      include($php_base_directory . 'includes/header.php');
      ?>

      <section id="fullscreen-flex"  >
        <div class="main-options-container">

          <div class="small-container">

          <h1 class="header-index">EDIT PROFILE</h1>

          <div class="fullscreen-container">

            <?php if($typea == "updated"){?><p class="updated-text">PROFILE UPDATED</p><?php } ?>
            <?php if($typea == "emailupdated"){?><p class="updated-text">EMAIL UPDATED</p><?php } ?>
            <?php if($typea == "passlengherror"){?><p class="errormessage">PASSWORDS MUST BE 8 CHARACTERS OR MORE</p><?php } ?>
            <?php if($typea == "passwordmissmatch"){?><p class="errormessage">PASSWORDS DID NOT MATCH!</p><?php } ?>
            <?php if($typea == "emailinuse"){?><p class="errormessage">THAT EMAIL IS IN USE BY ANOTHER USER!</p><?php } ?>
            <?php if($typea == "newuser"){?>
              <p style="display:block; width:100%; text-align:center; font-size:24pt; padding:0; margin:0 0 0px 0;">Hello and welcome to Wallpaper Cropper</p>
              <p style="display:block; width:100%; text-align:center; font-size:12pt; padding:0; margin:0 0 20px 0;">As you are a brand new member, please review your infomation below.</p>
              <p style="display:block; width:100%; text-align:center; font-size:14pt; padding:0; margin:0 0 20px 0;">All details here are public.</p>
            <?php } ?>
          <div class="sidebar-break"></div>

              <?php
              $mysqlquery="SELECT * FROM users WHERE id='$logged_in_id' ORDER BY id DESC LIMIT 1";
              $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
              while($row=$res->fetch_assoc()) {?>

                  <form  method="post" action="<?php echo $base_url; ?>/updateprofile/" enctype="multipart/form-data" name="imagechoice" id="imagechoice">

                    <label for="display_name">Display Name</label>
                    <input class="form-field" value="<?php echo $row['display_name']; ?>" type="text" name="display_name">

                    <label for="bio">Bio (500 Characters Max)</label>
                    <textarea class="form-textfield" name="bio"><?php echo $row['bio']; ?></textarea>

                    <?php if ($row['account_type'] == 1) {?>
                    <label for="email">Email</label>
                    <input class="form-field" value="<?php echo $row['email']; ?>" type="text" name="email">
                    <?php if($row['new_email']=="" or $row['validation_age'] < (time() - 86400)) {}else{?><p class="new-email">New email waiting validation: <?php echo $row['new_email']; ?></p><?php } ?>
                    <?php } ?>

                    <label for="facebook">Facebook Page URL</label>
                    <input class="form-field" value="<?php echo $row['facebook_url']; ?>" type="text" name="facebook">

                    <label for="twitter">Twitter URL</label>
                    <input class="form-field" value="<?php echo $row['twitter']; ?>" type="text" name="twitter">

                    <label for="website">Website URL</label>
                    <input class="form-field" value="<?php echo $row['website_url']; ?>" type="text" name="website">

                    <?php if ($row['account_type'] == 1) {?>
                    <label for="website">New Password (Minimum 8 characters, leave blank to leave unchanged)</label>
                    <input class="form-field" value="" type="password" name="passworda">

                    <label for="website">Repeate New Password</label>
                    <input class="form-field" value="" type="password" name="passwordb">
                    <?php } ?>


                    <input class="submit" id="submit" type="submit" value="Update Profile" onclick="loading();" />
                  </form>

              <?php } ?>
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

                <h5>Updating your profile!</h5>
                <h6>This may take a while depending on connection speeds, please do not refresh the page.</h6>

          </div>
        </div>
      </div>


      <script>
          function loading(){
            $( "#submit" ).hide();
            $( "#loading" ).fadeIn( "fast", function() {
              // Animation complete
            });
          }
      </script>

      <?php include($php_base_directory . 'includes/footer.php');?>
<?php }?>
