<?php
session_start();
$session_id = session_id();

$iid = $typea;

$mysqlquery="SELECT * FROM classic WHERE ID='$iid' ORDER BY ID DESC LIMIT 1";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {

	$usersession_id = $row['session_id'];
	$delete_status = $row['delete_status'];
  $wall = $row['wall'];

  $replace=$base_url . "/";


	}

$sessioncheck = 0;
if ($usersession_id == $session_id){$sessioncheck = 1;}

if ($delete_status == 1 or $sessioncheck == 0){
  log_malicious();
  $location = "Location: " . $base_url;
  header($location);
  exit();
} else {


$pagetitle = "Wallpaper Cropper - Your Walpaper";
$classic=1;
$mainoptions=1;
$fullscreenb=1;
include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-flex">
      <div class="main-options-container-b">

				<h1 class="header-index-b">Here is your wallpaper<br />it won't be on our server for long so save it to your computer/device now</h1>

              <div class="fullscreen-container-b">

								<?php include($php_base_directory . 'ads/classicad.php'); ?>

								<div class="tagspacer"></div>

                  <div id="wallimage">
                  <img src="<?php echo $base_url . "/" . $wall; ?>" alt="Your Wallpaper" class='theimage' data-pagespeed-no-transform />
                  </div>

                  <div id="bottomnavleft">
                    <div id="fb"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=275592602520986";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                  <div class="fb-like-box" data-href="https://www.facebook.com/WallpaperCropper" data-width="292" data-show-faces="false" data-colorscheme="light" data-stream="false" data-border-color="#000" data-header="false"></div>
                  </div>

                  <div id="bottomnavright">
                  <h4><a href="<?php echo $base_url; ?>/delete/<?php echo $iid ?>/">Delete</a></h4><h4><a href="<?php echo $base_url; ?>/stage2/<?php echo $iid ?>/">New Resolution</a></h4><h4><a href="<?php echo $base_url; ?>/stage3/<?php echo $iid ?>/">Re-Crop</a></h4>
                  </div>


              </div>

      </div>
    </section>


<?php include($php_base_directory . 'includes/footer.php');?>
<?php
//end of image nad session check check deleted
}?>
