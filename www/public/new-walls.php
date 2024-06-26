<?php
$pagetitle = "Our Latest Wallpapers";
if($typea == null){}else{$pagetitle = $pagetitle . " (Page " . $typea . ")";}
$pagedescription = "Browse our newest and latest wallpaper collection";
$pagenate = 1;
$fullscreena=1;
include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-b">
<?php include($php_base_directory . 'ads/topad.php'); ?>

    <div class="full-site-container">

      <h1 class="header-index"><?php echo $pagetitle; ?></h1>

      <div class="wallpaper-thumb-container-index">
        <?php

        if($resfilter==null or $resfilter=="") {$filter="";} else{
          $filter=" AND " . $resfilter . " IS NOT NULL AND " . $resfilter . " <> ''";
        }


        if ($nsfw == 1){
          $mysqlquery="SELECT wallpapers.id FROM wallpapers WHERE NOT EXISTS (SELECT * FROM category_links WHERE category_id='4' AND wallpaper_id = wallpapers.id) AND hq='1' AND moderated='1' $filter";
        } else {
          $mysqlquery="SELECT wallpapers.id FROM wallpapers WHERE NOT EXISTS (SELECT * FROM category_links WHERE category_id='4' AND wallpaper_id = wallpapers.id) AND hq='1' AND moderated='1' AND sfw='1' $filter";
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
          <?php $prefix="new-walls"; include('includes/pagenate.php'); ?>
        </div>



          <?php




          if ($nsfw == 1){
            $mysqlquery="SELECT wallpapers.* FROM wallpapers WHERE NOT EXISTS (SELECT * FROM category_links WHERE category_id='4' AND wallpaper_id = wallpapers.id) AND hq='1' AND moderated='1' $filter ORDER BY id DESC LIMIT 24 OFFSET $offset";
          } else {
            $mysqlquery="SELECT wallpapers.* FROM wallpapers WHERE NOT EXISTS (SELECT * FROM category_links WHERE category_id='4' AND wallpaper_id = wallpapers.id) AND hq='1' AND moderated='1' AND sfw='1' $filter ORDER BY id DESC LIMIT 24 OFFSET $offset";
          }

          $res = $db->sql( $mysqlquery );
          while($row=$res->fetch_assoc()) {

                   if ($defaultratio == "16by9"){$thumb = $row['16by9thumb'];}
              else if ($defaultratio == "16by10"){$thumb = $row['16by10thumb'];}
              else if ($defaultratio == "4by3"){$thumb = $row['4by3thumb'];}
              else if ($defaultratio == "5by4"){$thumb = $row['5by4thumb'];}
              else if ($defaultratio == "mobile"){$thumb = $row['mobilethumb'];}
              else {
                if ($mobile==1){$thumb = $row['mobilethumb'];}
                        else {$thumb = $row['16by9thumb'];}
              }

              $thumb = str_replace($php_base_directory,$static_url."/",$thumb);

            ?>

              <div class="wall-box-index">
                <div class="wall-box-inner-index">
                  <a class="walllink" href="<?php echo $base_url ?>/view-wall/<?php echo $row['id'];?>/"><img alt="<?php $row['title']; ?>" class="wall-box-image-index" src="<?php echo $thumb; ?>" />
                  <?php if ($row['title'] == "" or $row['title'] == null ) {} else {?>
                    <span class="walltitle"><?php echo $row['title']; ?></span>
                  <?php } ?></a>
                </div>
              </div>

          <?php $firstlink=0; } ?>

          <div class="pagenavi2">
            <?php $prefix="new-walls"; include('includes/pagenate.php'); ?>
          </div>

      </div>

    </div>


</section>


<?php include($php_base_directory . 'includes/footer.php');?>
