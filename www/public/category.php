<?php
  $pagetitle = "Wallpaper Category: ";

  $res = $db->sql( "SELECT * FROM category WHERE slug=? ORDER BY id DESC LIMIT 1", 's' , $typea );
  while($row=$res->fetch_assoc()) {
    $pagetitle = $pagetitle . " " . ucwords($row['cat_name']);
    $cat_id = $row['id'];

  }
      if($typeb == null){}else{$pagetitle = $pagetitle . " (Page " . $typeb . ")";}
      $pagenate = 1;
      $fullscreena=1;
      $fullscreenb=1;
      $fullscreencolumn=1;
      include($php_base_directory . 'includes/header.php');
  ?>

<section id="fullscreen-b">
<?php include($php_base_directory . 'ads/topad.php'); ?>
    <div class="full-site-container">

        <div class="right-column">

          <h1 class="header-index"><?php echo $pagetitle; ?></h1>

          <div class="content">

              <div class="wallpaper-thumb-container">

                <div class="wallpaper-thumb-container-profile">

                      <?php

                      if($resfilter==null or $resfilter=="") {$filter="";} else{
                        $filter=" AND wallpapers." . $resfilter . " IS NOT NULL AND wallpapers." . $resfilter . " <> ''";
                      }

                      if($nsfw == 1){
                        $mysqlquery="SELECT * FROM category_links INNER JOIN wallpapers ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id=? AND wallpapers.hq='1' AND wallpapers.moderated='1'$filter ORDER BY wallpaper_id DESC";
                      }
                      else{
                        $mysqlquery="SELECT * FROM category_links INNER JOIN wallpapers ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id=? AND wallpapers.hq='1' AND wallpapers.moderated='1' AND wallpapers.sfw='1'$filter ORDER BY wallpaper_id DESC";
                      }

                      $total = $db->sql( $mysqlquery, 'i' , $cat_id );
                      $total = $total->num_rows;
                      $limit = 24;
                      $pages = ceil($total / $limit);

                      $page = $typeb;
                      if ($page == null) {$page = 1;}
                      $offset = ($page - 1)  * $limit;
                      ?>

                      <div class="pagenavi1">
                        <?php $prefix="category/" . $typea; include('includes/pagenate.php'); ?>
                      </div>

                      <?php
                      if($nsfw == 1){
                        $mysqlquerymain="SELECT * FROM category_links INNER JOIN wallpapers  ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id=? AND wallpapers.hq='1' AND wallpapers.moderated='1'$filter ORDER BY wallpaper_id DESC LIMIT 24 OFFSET $offset";
                      }
                      else{
                        $mysqlquerymain="SELECT * FROM category_links INNER JOIN wallpapers  ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id=? AND wallpapers.hq='1' AND wallpapers.moderated='1'$filter AND wallpapers.sfw='1' ORDER BY wallpaper_id DESC LIMIT 24 OFFSET $offset";
                      }


                      $resa = $db->sql( $mysqlquerymain, 'i' , $cat_id );
                      while($rowa=$resa->fetch_assoc()) {
                        $wallid = $rowa['wallpaper_id'];
                      ?>
                                  <?php
                                  $res = $db->sql( "SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $wallid );
                                  while($row=$res->fetch_assoc()) {

                                           if ($defaultratio == "16by9"){$thumb = $row['16by9thumb'];}
                                      else if ($defaultratio == "16by10"){$thumb = $row['16by10thumb'];}
                                      else if ($defaultratio == "4by3"){$thumb = $row['4by3thumb'];}
                                      else if ($defaultratio == "5by4"){$thumb = $row['5by4thumb'];}
                                      else if ($defaultratio == "mobile"){$thumb = $row['mobilethumb'];}
                                      else {$thumb = $row['16by9thumb'];}

                                      $thumb = str_replace($php_base_directory,$static_url."/",$thumb);

                                    ?>

                                    <div class="wall-box-profile">
                                      <div class="wall-box-inner-profile">
                                        <a class="walllink" href="<?php echo $base_url ?>/view-wall/<?php echo $row['id'];?>/"><img class="wall-box-image-profile" src="<?php echo $thumb; ?>" />
                                        <?php if ($row['title'] == "" or $row['title'] == null ) {} else {?>
                                          <span class="walltitle"><?php echo $row['title']; ?></span>
                                        <?php } ?></a>
                                      </div>
                                    </div>

                                  <?php $firstlink=0; } ?>
                      <?php } ?>

                        <div class="pagenavi2">
                          <?php $prefix="category/" . $typea; include('includes/pagenate.php'); ?>
                        </div>


                  </div>

              </div>

          </div>
        </div>


        <div class="left-column">
          <?php
          $firstlink=1;
          $res = $db->sql( "SELECT * FROM category ORDER BY cat_name ASC");
          while($row=$res->fetch_assoc()) {
            $showcat = 0;

            if ($row['total']==0 && $row['nsfw_total']==0){$showcat = 0;}
            if ($row['nsfw_total']>0 && $nsfw == 1 ){$showcat = 1;}
            if ($row['total']>0){$showcat = 1;}

            if ($showcat == 1) {?>

            <a class="archive-cat-link<?php if($row['slug'] == $typea){echo " current";} ?>" href="<?php echo $base_url; ?>/category/<?php echo $row['slug']; ?>/"><?php echo $row['cat_name']; ?> <small>(<?php

            if ($nsfw == 1) {echo $row['total'] + $row['nsfw_total'];} else {echo $row['total'];}

            ?> Wallpapers)</small></a>

          <?php $firstlink=0; }} ?>
        </div>


    </div>




</section>

      <?php include($php_base_directory . 'includes/footer.php');?>
