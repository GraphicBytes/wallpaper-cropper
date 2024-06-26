<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

$pagetitle = "Your Wallpaper collections";
$pagedescription = "Your Wallpaper collections";
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
      $total = $db->sql( "SELECT * FROM collections WHERE owner_id = ? ORDER BY id DESC", 'i' , $logged_in_id );
      $total = $total->num_rows;
      $limit = 24;
      $pages = ceil($total / $limit);

      $page = $typea;
      if ($page == null) {$page = 1;}
      $offset = ($page - 1)  * $limit;
      ?>

      <div class="pagenavi1">
        <?php $prefix="your-collections"; include('includes/pagenate.php'); ?>
      </div>

      <?php
      $res = $db->sql( "SELECT * FROM collections WHERE owner_id = ? ORDER BY id DESC LIMIT $limit OFFSET $offset", 'i' , $logged_in_id );
      while($row=$res->fetch_assoc()) {
      $collection_id = $row['id'];
      $collection_name = $row['name'];
      $collection_owner = $row['owner_id'];

            if ($defaultratio == "16by9"){$thumb = $static_url."/wallpapers/thumb16by9.jpg";}
       else if ($defaultratio == "16by10"){$thumb = $static_url."/wallpapers/thumb16by9.jpg";}
       else if ($defaultratio == "4by3"){$thumb = $static_url."/wallpapers/thumb16by9.jpg";}
       else if ($defaultratio == "5by4"){$thumb = $static_url."/wallpapers/thumb16by9.jpg";}
       else if ($defaultratio == "mobile"){$thumb = $static_url."/wallpapers/thumb16by9.jpg";}
       else {$thumb = $static_url."/wallpapers/thumb16by9.jpg";}
      ?>

          <?php
          $empty=0;
          
          $resb = $db->sql( "SELECT * FROM collection_links INNER JOIN wallpapers ON collection_links.wallpaper_id = wallpapers.id  WHERE collection_links.collection_id = ? ORDER BY wallpapers.id DESC LIMIT 1", 'i' , $collection_id );
          while($rowb=$resb->fetch_assoc()) {

                if ($defaultratio == "16by9"){$thumb = $rowb['16by9thumb'];}
           else if ($defaultratio == "16by10"){$thumb = $rowb['16by10thumb'];}
           else if ($defaultratio == "4by3"){$thumb = $rowb['4by3thumb'];}
           else if ($defaultratio == "5by4"){$thumb = $rowb['5by4thumb'];}
           else if ($defaultratio == "mobile"){$thumb = $rowb['mobilethumb'];}
           else {$thumb = $rowb['16by9thumb'];}

           $thumb = str_replace($php_base_directory,$static_url."/",$thumb);?>

           <?php $empty=1; } ?>

            <div class="wall-box-index">
              <div class="wall-box-inner-index">
                <a class="walllink" href="<?php echo $base_url ?>/collection/<?php echo $collection_id;?>/"><img class="wall-box-image-index" src="<?php echo $thumb; ?>" />
                <span class="walltitle"><?php echo $collection_name; ?></a>
                <?php if($empty == 0){ ?><a class="delete-collection" href="<?php echo $base_url ?>/update/delete-collection/<?php echo $collection_id;?>/" onclick="loading();"></a><?php } ?>
              </div>
            </div>


      <?php } ?>

      <div class="pagenavi2">
        <?php $prefix="your-collections"; include('includes/pagenate.php'); ?>
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
