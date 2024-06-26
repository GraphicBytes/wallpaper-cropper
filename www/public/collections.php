<?php
$pagetitle = "Wallpaper Cropper Collections";
$pagedescription = "Browse our user's wallpaper collections";
$pagenate = 1;
$fullscreena=1;
$fullscreenb=1;
include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-b">
<div class="tagspacer"></div>
<?php include($php_base_directory . 'ads/topad.php'); ?>
  <div class="full-site-container">

    <h1 class="header-index"><?php echo $pagetitle; ?></h1>

    <div class="wallpaper-thumb-container-index">
      <?php
      if ($nsfw == 1){
        $mysqlquery="SELECT * FROM collections WHERE count > 0 ORDER BY thumbs DESC";
      } else {
        $mysqlquery="SELECT * FROM collections WHERE sfw = 1 AND count > 0 ORDER BY thumbs DESC";
      }

      $total = $db->sql( $mysqlquery );
      $total = $total->num_rows;
      $limit = 24;
      $pages = ceil($total / $limit);

      $page = $typea;
      if ($page == null) {$page = 1;}
      $offset = ($page - 1)  * $limit;
      ?>

      <div class="pagenavi1">
        <?php $prefix="collections"; include('includes/pagenate.php'); ?>
      </div>

      <?php
      if ($nsfw == 1){
        $mysqlquery="SELECT * FROM collections WHERE count > 0 ORDER BY thumbs DESC, count DESC LIMIT $limit OFFSET $offset";
      } else {
        $mysqlquery="SELECT * FROM collections WHERE sfw = 1 AND count > 0 ORDER BY thumbs DESC, count DESC LIMIT $limit OFFSET $offset";
      }

      $res = $db->sql( $mysqlquery );
      while($row=$res->fetch_assoc()) {
      $collection_id = $row['id'];
      $collection_name = $row['name'];
      $collection_owner = $row['owner_id'];
      ?>

          <?php
          $resb = $db->sql( "SELECT * FROM collection_links INNER JOIN wallpapers ON collection_links.wallpaper_id = wallpapers.id  WHERE collection_links.collection_id = ? ORDER BY wallpapers.id DESC LIMIT 1", 'i' , $collection_id );
          while($rowb=$resb->fetch_assoc()) {

                if ($defaultratio == "16by9"){$thumb = $rowb['16by9thumb'];}
           else if ($defaultratio == "16by10"){$thumb = $rowb['16by10thumb'];}
           else if ($defaultratio == "4by3"){$thumb = $rowb['4by3thumb'];}
           else if ($defaultratio == "5by4"){$thumb = $rowb['5by4thumb'];}
           else if ($defaultratio == "mobile"){$thumb = $rowb['mobilethumb'];}
           else {$thumb = $rowb['16by9thumb'];}

           $thumb = str_replace($php_base_directory,$static_url."/",$thumb);?>

           <?php
           $resc = $db->sql( "SELECT * FROM users WHERE id = ? ORDER BY id ASC LIMIT 1", 'i' , $collection_owner );
           while($rowc=$resc->fetch_assoc()) {$usercredit=$rowc['display_name'];}?>

            <div class="wall-box-index">
              <div class="wall-box-inner-index">
                <a class="walllink" href="<?php echo $base_url ?>/collection/<?php echo $collection_id;?>/"><img alt="<?php echo $resb['title']; ?>" class="wall-box-image-index" src="<?php echo $thumb; ?>" />
                <span class="walltitle"><?php echo $collection_name; ?><br />
                <small>By <?php echo $usercredit; ?></small></span></a>
              </div>
            </div>
          <?php } ?>

      <?php } ?>

      <div class="pagenavi2">
        <?php $prefix="collections"; include('includes/pagenate.php'); ?>
      </div>

    </div>
  </div>
</section>

<?php include($php_base_directory . 'includes/footer.php');?>
