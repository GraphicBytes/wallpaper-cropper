<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

$pagetitle = "Wallpapers You Like";
$pagedescription = "Wallpapers You Like";
$loadingcss = 1;
$pagenate = 1;
$fullscreena=1;
$fullscreencolumn=1;
include($php_base_directory . 'includes/header.php');
?>




<section id="fullscreen-b">
<?php include($php_base_directory . 'ads/topad.php'); ?>
  <div class="full-site-container">

    <h1 class="header-index"><?php echo $pagetitle; ?></h1>

    <div class="wallpaper-thumb-container-index">

      <?php
      $mysqlquery="SELECT * FROM bookmarked_walls WHERE user_id = '$logged_in_id' ORDER BY id DESC";

      $total = $dbconn->query($mysqlquery);
      $total = $total->num_rows;
      $limit = 24;
      $pages = ceil($total / $limit);

      $page = $typea;
      if ($page == null) {$page = 1;}
      $offset = ($page - 1)  * $limit;?>

      <div class="pagenavi1">
        <?php $prefix="likes"; include('includes/pagenate.php'); ?>
      </div>

      <?php
      $mysqlquery="SELECT * FROM bookmarked_walls WHERE user_id = '$logged_in_id' ORDER BY id DESC LIMIT $limit OFFSET $offset";
      $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
      while($row=$res->fetch_assoc()) {
      $wallpaper_id = $row['wallpaper_id'];
      ?>

          <?php $empty=0; $mysqlqueryb="SELECT * FROM wallpapers WHERE id='$wallpaper_id' ORDER BY id DESC LIMIT 1";
          $resb=$dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
          while($rowb=$resb->fetch_assoc()) {

            $wall_title = $rowb['title'];

                if ($defaultratio == "16by9"){$thumb = $rowb['16by9thumb'];}
           else if ($defaultratio == "16by10"){$thumb = $rowb['16by10thumb'];}
           else if ($defaultratio == "4by3"){$thumb = $rowb['4by3thumb'];}
           else if ($defaultratio == "5by4"){$thumb = $rowb['5by4thumb'];}
           else if ($defaultratio == "mobile"){$thumb = $rowb['mobilethumb'];}
           else {$thumb = $rowb['16by9thumb'];}

           $thumb = str_replace($php_base_directory,$static_url."/",$thumb);

           $empty=1; } ?>

            <div class="wall-box-index">
              <div class="wall-box-inner-index">
                <a class="walllink" href="<?php echo $base_url ?>/view-wall/<?php echo $wallpaper_id;?>/"><img class="wall-box-image-index" src="<?php echo $thumb; ?>" />
                <span class="walltitle"><?php echo $wall_title; ?></a>
                <?php if($empty == 0){ ?><a class="delete-collection" href="<?php echo $base_url ?>/update/delete-collection/<?php echo $collection_id;?>/" onclick="loading();"></a><?php } ?>
              </div>
            </div>


      <?php } ?>

      <div class="pagenavi2">
        <?php $prefix="likes"; include('includes/pagenate.php'); ?>
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
          <h5>Updating!</h5>
          <h6>Pease do not refresh the page.</h6>
    </div>
  </div>
</div>



<?php include($php_base_directory . 'includes/footer.php'); }?>
