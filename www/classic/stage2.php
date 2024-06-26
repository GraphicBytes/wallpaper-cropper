<?php
session_start();
$session_id = session_id();

$iid = $typea;

$mysqlquery="SELECT * FROM classic WHERE ID='$iid' ORDER BY ID DESC LIMIT 1";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {

	$usersession_id = $row['session_id'];
	$imagefile = $row['imagefile'];
	$imgwidth = $row['imgwidth'];
	$imgheight = $row['imgheight'];
	$thumb = $row['thumb'];
	$thumbw = $row['thumbw'];
	$thumbh = $row['thumbh'];
	$delete_status = $row['delete_status'];

	}

$sessioncheck = 0;
if ($usersession_id == $session_id){$sessioncheck = 1;}

if ($delete_status == 1 or $sessioncheck == 0){
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {


$pagetitle = "Wallpaper Cropper - Stage 2";
$loadingcss = 1;
$classic=1;
$mainoptions=1;
$fullscreenb=1;
$formfields=1;
include($php_base_directory . 'includes/header.php');
?>

<script>
function fillForm()
{document.getElementById("width").value = screen.width;
document.getElementById("height").value = screen.height;}
function users()
{document.getElementById("width").value = screen.width;
document.getElementById("height").value = screen.height;}

function resselect(width, height)
{document.getElementById("width").value = width;
document.getElementById("height").value = height;}
</script>

<section id="fullscreen-flex">
  <div class="main-options-container-b">

		<h1 class="header-index-b">Stage Two<br />Input or select the resolution of your wallpaper</h1>

    <div class="fullscreen-container-b">

			<?php include($php_base_directory . 'ads/classicad.php'); ?>

			<div class="tagspacer"></div>

      <form action="<?php echo $base_url; ?>/prepwall/<?php echo $iid ?>/" method="post" enctype="multipart/form-data" name="imagechoice" id="imagechoice" >

      <div class="imagedetails">

          <div class="imagedetails-left">
            <h2>Your Image</h2>
            <?php $replace=$base_url . "/"; $thumb = str_replace($php_base_directory, $replace, $thumb);?>
            <img class="image-preview" alt="Image Preview" src="<?php echo $thumb;?>" width="<?php echo $thumbw;?>" height="<?php echo $thumbh;?>" data-pagespeed-no-transform />
            <a class="delete-image-link" href="<?php echo $base_url ?>/delete/<?php echo $iid ?>/">Delete This Image</a>
          </div>

          <div class="imagedetails-right">
            <h2>Image Width: <?php echo $imgwidth;?>px - Image Height: <?php echo $imgheight;?>px</h2>

            <a class="your-resolution" onClick="users()" href="#select">Your resolution: <script>document.write(screen.width+'x'+screen.height);</script></a>

            <div style="display:block; width:100%; clear:both;"></div>

              <div class="inputwidth">
                <h2>Chosen Width</h2>
                <input class="form-field" type="text" id="width" name="width">
              </div>


              <div class="inputheight">
                <h2>Chosen Height</h2>
                <input class="form-field" type="text" id="height" name="height"/>
              </div>

          </div>

          <input id="submit" class="submit" type="submit" value="Submit &amp; Continue to Stage Two" onclick="loading();">

          <h1>Other Common Resolutions</h1>
          <p>
						<a onClick="resselect(2048, 2732)" href="#select">Ipad Portrait</a>
						<a onClick="resselect(2732,2048 )" href="#select">Ipad Landscape</a>
						<a onClick="resselect(1080,1920)" href="#select">iPhone</a>
						<a onClick="resselect(1125,2436)" href="#select">iPhone Plus/X</a>
						<a onClick="resselect(2960, 1440)" href="#select">Hi Spec Android (Generic Portait Ratio)</a>
						<a onClick="resselect(986, 480)" href="#select">Lower Spec Android (Generic Portait Ratio)</a>
					</p>
					<p>
						<a onClick="resselect(1024,768)" href="#select">1024x768</a>
						<a onClick="resselect(1152,864)" href="#select">1152x864</a>
						<a onClick="resselect(1280,1024)" href="#select">1280x1024</a>
						<a onClick="resselect(1280,800)" href="#select">1280x800</a>
						<a onClick="resselect(1280,960)" href="#select">1280x960</a>
						<a onClick="resselect(1366,768)" href="#select">1366x768</a>
						<a onClick="resselect(1440,900)" href="#select">1440x900</a>
						<a onClick="resselect(1600,900)" href="#select">1600x900</a>
						<a onClick="resselect(1600,1200)" href="#select">1600x1200</a>
						<a onClick="resselect(1680,1050)" href="#select">1680x1050</a>
						<a onClick="resselect(1920,1080)" href="#select">1920x1080</a>
						<a onClick="resselect(1920,1200)" href="#select">1920x1200</a>
						<a onClick="resselect(2560,1080)" href="#select">2560x1080</a>
						<a onClick="resselect(2560,1440)" href="#select">2560x1440</a>
						<a onClick="resselect(2560,1600)" href="#select">2560x1600</a>
						<a onClick="resselect(2560,1920)" href="#select">2560x1920</a>
					</p>


      </div>


    </form>

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
          <h5>Doing a little prep!</h5>
          <h6>This may take a while depending on image size, please do not refresh the page.</h6>
    </div>
  </div>
</div>


<?php include($php_base_directory . 'includes/footer.php');?>
<?php
//end of image nad session check check deleted
}?>
