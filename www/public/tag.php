<?php
  $pagetitle = "Wallpaper Cropper";

  $res = $db->sql( "SELECT * FROM tags WHERE slug=? ORDER BY id DESC LIMIT 1", 's' , $typea );
  while($row=$res->fetch_assoc()) {
    $pagetitle = $pagetitle . " - " . ucwords($row['tag_name']);
    $tag_id = $row['id'];

  }
      $pagenate = 1;
      $fullscreena=1;
      $fullscreencolumn=1;
      include($php_base_directory . 'includes/header.php');
  ?>

<section id="fullscreen-b" >

    <div class="full-site-container">

        <div class="right-column">
          <div class="content">

              <div class="wallpaper-thumb-container">

                <div class="wallpaper-thumb-container-profile">

                      <?php

                      if($resfilter==null or $resfilter=="") {$filter="";} else{
                        $filter=" AND wallpapers." . $resfilter . " IS NOT NULL AND wallpapers." . $resfilter . " <> ''";
                      }


                      if($nsfw == 1){
                        $mysqlquery="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id=? $filter ORDER BY wallpaper_id DESC";
                      }
                      else{
                        $mysqlquery="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id=? $filter ORDER BY wallpaper_id DESC";
                      }
                      $total = $db->sql( $mysqlquery, 'i' , $tag_id );
                      $total = $total->num_rows;
                      $limit = 24;
                      $pages = ceil($total / $limit);

                      $page = $typeb;
                      if ($page == null) {$page = 1;}
                      $offset = ($page - 1)  * $limit;
                      ?>

                      <div class="pagenavi1">
                        <?php $prefix="tag/" . $typea; include('includes/pagenate.php'); ?>
                      </div>

                      <?php
                      if($nsfw == 1){
                        $mysqlquerymain="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id=? ORDER BY wallpaper_id DESC LIMIT 24 OFFSET $offset";
                      }
                      else{
                        $mysqlquerymain="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id=? ORDER BY wallpaper_id DESC LIMIT 24 OFFSET $offset";
                      }

                      $resa = $db->sql( $mysqlquerymain, 'i' , $tag_id );
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
                                        <a class="walllink" href="<?php echo $base_url ?>/view-wall/<?php echo $row['id'];?>/"><img alt="<?php $row['title']; ?>" class="wall-box-image-profile" src="<?php echo $thumb; ?>" />
                                        <?php if ($row['title'] == "" or $row['title'] == null ) {} else {?>
                                          <span class="walltitle"><?php echo $row['title']; ?></span>
                                        <?php } ?></a>
                                      </div>
                                    </div>

                                  <?php $firstlink=0; } ?>
                      <?php } ?>

                        <div class="pagenavi2">
                          <?php $prefix="tag/" . $typea; include('includes/pagenate.php'); ?>
                        </div>


                  </div>

              </div>

          </div>
        </div>


        <div class="left-column">
          <div class="catsandtags2">
              <h4>Popular Tags</h4>
              <div class="tag-cluster">
                  <?php
                  $res = $db->sql( "SELECT * FROM tags ORDER BY total DESC LIMIT 50");
                  while($row=$res->fetch_assoc()) {
                    $tag_name = $row['tag_name'];
                    $tag_name = ucwords($tag_name);
                    $tag_slug = $row['slug'];
                    ?>
                    <a class="taglink2" rel="nofollow" href="<?php echo $base_url ?>/tag/<?php echo $tag_slug; ?>/" ><?php echo $tag_name; ?></a>
                  <?php }?>
              </div>
          </div>
        </div>

    </div>




</section>

      <?php include($php_base_directory . 'includes/footer.php');?>
