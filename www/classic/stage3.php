<?php
session_start();
$session_id = session_id();

$iid = $typea;

$mysqlquery = "SELECT * FROM classic WHERE ID='$iid' ORDER BY ID DESC LIMIT 1";
$res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while ($row = $res->fetch_assoc()) {

	$usersession_id = $row['session_id'];
	$imagefile = $row['imagefile'];
	$imgwidth = $row['imgwidth'];
	$imgheight = $row['imgheight'];
	$userw = $row['userw'];
	$userh = $row['userh'];
	$delete_status = $row['delete_status'];

	$replace = $base_url . "/";
	$imagefile = str_replace($php_base_directory, $replace, $imagefile);
}

$sessioncheck = 0;
if ($usersession_id == $session_id) {
	$sessioncheck = 1;
}

if ($delete_status == 1 or $sessioncheck == 0) {
	$location = "Location: " . $base_url;
	log_malicious();
	header($location);
	exit();
} else {


	$pagetitle = "Wallpaper Cropper - Stage 3";
	$loadingcss = 1;
	$classic = 1;
	$mainoptions = 1;
	$fullscreenb = 1;
	$jcrop = 1;
	$formfields = 1;
	include($php_base_directory . 'includes/header.php');
?>

	<script>
		$(function() {

			$('#cropbox').Jcrop({
				aspectRatio: <?php echo $userw / $userh; ?>,
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

			<h1 class="header-index-b">Stage Three<br />Select the area of the image you wish to crop</h1>

			<div class="fullscreen-container-b">

				<?php include($php_base_directory . 'ads/classicad.php'); ?>

				<div class="tagspacer"></div>


				<img src="<?php echo $imagefile ?>" class="cropbox" id="cropbox" alt="Your Image" data-pagespeed-no-defer data-pagespeed-no-transform />

				<form action="<?php echo $base_url; ?>/crop/<?php echo $iid ?>/" method="post" onsubmit="return checkCoords();">
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />

					<input type="hidden" id="user_width" name="user_width" value="650" />

					<input class="submit3" type="submit" value="Submit &amp; Generate Wallpaper" id="submit" onclick="loading();" />
				</form>

				<script>
					$(window).load(function() {
						var loadedcropperwidth = $("#cropbox").width();
						$("#user_width").val(loadedcropperwidth);
						console.log(loadedcropperwidth);
					});
					$(window).resize(function() {
						var cropperwidth = $("#cropbox").width();
						$("#user_width").val(loadedcropperwidth);
						console.log(cropperwidth);
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

	<script>
		function loading() {
			$("#submit").hide();
			$("#loading").fadeIn("fast", function() {
				// Animation complete
			});
		}
	</script>


	<?php include($php_base_directory . 'includes/footer.php'); ?>
<?php
	//end of image nad session check check deleted
} ?>