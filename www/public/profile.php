<?php

$mysqlquery="SELECT * FROM users WHERE id='$typea' ORDER BY ? DESC LIMIT 1";
$stmt = $dbconn->prepare($mysqlquery);
$stmt->bind_param('s',$typea);
$stmt->execute();
$res = $stmt->get_result();

while($row=$res->fetch_assoc()) {

$display_name = $row['display_name'];
$avatar = $row['avatar'];
$display_name = $row['display_name'];
$last_login = $row['last_login'];
$bio = $row['bio'];
$facebook_url = $row['facebook_url'];
$twitter = $row['twitter'];
$website_url = $row['website_url'];

}

if ($typec == "category") {

  $rescat = $db->sql( "SELECT * FROM category WHERE slug=? ORDER BY id DESC LIMIT 1", 's' , $typed );
  while($rowcat=$rescat->fetch_assoc()) {
    $cat_id = $rowcat['id'];
  }
  $mysqlquery="SELECT * FROM category_links INNER JOIN wallpapers ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id='$cat_id' AND wallpapers.owner=? ORDER BY category_links.wallpaper_id DESC";

} else if ($typec == "tag") {

    $rescat = $db->sql( "SELECT * FROM tags WHERE slug=? ORDER BY id DESC LIMIT 1", 's' , $typed );
    while($rowcat=$rescat->fetch_assoc()) {
      $tag_id = $rowcat['id'];
    }
    $mysqlquery="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id='$tag_id' AND wallpapers.owner=? ORDER BY tag_links.wallpaper_id DESC";

} else {
  $mysqlquery="SELECT id FROM wallpapers WHERE owner=?";
}

$total = $db->sql( $mysqlquery, 'i' , $typea );
$total = $total->num_rows;
$limit = 18;
$pages = ceil($total / $limit);

$page = $typeb;
if ($page == null) {$page = 1;}
$offset = ($page - 1)  * $limit;

if($total == 0){
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
}else{

      $pagetitle = "Profile: $display_name";
      $pagenate = 1;
      $fullscreena=1;
      $fullscreencolumn=1;
      $formfields=1;
      include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-b">
  <div class="responsive-container"></div>

    <div class="full-site-container">

        <div class="right-column">

          <h1 class="header-index"><?php echo $pagetitle; ?></h1>

          <div class="content">

              <div class="wallpaper-thumb-container">

                <div class="wallpaper-thumb-container-profile">

                      <div class="pagenavi1">
                        <?php
                        if ($typec == "category" or $typec == "tag") {
                          $prefix="profile/" . $typea; $postfix=$typec . "/" . $typed .  "/" ; include('includes/pagenate.php');
                        } else {
                          $prefix="profile/" . $typea; include('includes/pagenate.php');
                        }?>
                      </div>

                        <?php
                        if ($typec == "category") {
                          $mysqlquery="SELECT * FROM category_links INNER JOIN wallpapers ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id='$cat_id' AND wallpapers.owner=? ORDER BY wallpaper_id DESC LIMIT $limit OFFSET $offset";
                        }
                        else if ($typec == "tag") {
                          $mysqlquery="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id='$tag_id' AND wallpapers.owner=? ORDER BY wallpaper_id DESC LIMIT $limit OFFSET $offset";
                        } else {
                          $mysqlquery="SELECT * FROM wallpapers WHERE owner=? ORDER BY id DESC LIMIT $limit OFFSET $offset";
                        }

                        $res = $db->sql( $mysqlquery, 'i' , $typea );
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

                        <div class="pagenavi2">
                          <?php
                          if ($typec == "category" or $typec == "tag") {
                            $prefix="profile/" . $typea; $postfix=$typec . "/" . $typed .  "/" ; include('includes/pagenate.php');
                          } else {
                            $prefix="profile/" . $typea; include('includes/pagenate.php');
                          }?>
                        </div>


                  </div>

              </div>

          </div>
        </div>


        <div class="left-column">

              <div class="avatar">
                <img alt="<?php $row['title']; ?>" class="avatar-img" src="<?php echo $static_url; ?>/avatars/<?php echo $avatar; ?>" alt="<?php echo $display_name; ?>" />
              </div>

              <div class="profile">
                <h1><?php echo $display_name; ?></h1>
                <h6>Last active <?php echo lastactive($last_login); ?></h6>
                <p><?php echo $bio; ?></p>

                <div class="profile-social">
                  <?php if ($facebook_url == ""){} else {?>
                  <a class="social-link" rel="nofollow" target="blank" href="<?php echo $facebook_url; ?>" rel="nofollow"><img alt="<?php $row['title']; ?>" class="social-icon" src="<?php echo $static_url; ?>/static/images/facebook-icon.png" /></a>
                  <?php }; ?>

                  <?php if ($twitter == ""){} else {?>
                  <a class="social-link" rel="nofollow" target="blank" href="<?php echo $twitter; ?>" rel="nofollow"><img alt="<?php $row['title']; ?>" class="social-icon" src="<?php echo $static_url; ?>/static/images/twitter-icon.png" /></a>
                  <?php }; ?>

                  <?php if ($website_url == ""){} else {?>
                  <a class="social-link" rel="nofollow" target="blank" href="<?php echo $website_url; ?>" rel="nofollow"><img alt="<?php $row['title']; ?>" class="social-icon" src="<?php echo $static_url; ?>/static/images/web-icon.png" /></a>
                  <?php }; ?>

                </div>

              </div>


              <div class="catsandtags">
                  <h4>Filter by Category</h4>
                  <select class="styled-select blue semi-square" id="catfilter">
                  <option value="<?php echo $base_url; ?>/profile/<?php echo $typea; ?>/">VIEW ALL</option>
                  <?php
                  $res = $db->sql( "SELECT * FROM category ORDER BY cat_name ASC");
                  while($row=$res->fetch_assoc()) {

                    $cat_id=$row['id'];
                    $showcat = 0;

                        $resb = $db->sql( "SELECT * FROM category_links WHERE category_id=? ORDER BY id ASC", 'i' , $cat_id );
                        while($rowb=$resb->fetch_assoc()) {
                          $wallpaperid=$rowb['wallpaper_id'];

                              $resc = $db->sql( "SELECT owner FROM wallpapers WHERE id=? ORDER BY id ASC LIMIT 1", 'i' , $wallpaperid );
                              while($rowc=$resc->fetch_assoc()) {
                                if ($rowc['owner'] == $typea){$showcat = 1;}
                              }


                        }

                  if($showcat == 1){ ?>
                  <option value="<?php echo $base_url; ?>/profile/<?php echo $typea; ?>/1/category/<?php echo $row['slug']; ?>/" <?php if($typed==$row['slug']){echo "selected";} ?>><?php echo $row['cat_name']; ?></option>
                  <?php } } ?>
                  </select>
              </div>



              <div class="catsandtags">
                  <h4>Filter by Tag</h4>
                  <select class="styled-select blue semi-square" id="tagfilter">
                  <option value="<?php echo $base_url; ?>/profile/<?php echo $typea; ?>/">VIEW ALL</option>
                  <?php
                  $wallpaperid=null;

                  $res = $db->sql( "SELECT * FROM tags ORDER BY tag_name ASC");
                  while($row=$res->fetch_assoc()) {

                    $tag_id=$row['id'];
                    $showtag = 0;

                        $resb = $db->sql( "SELECT * FROM tag_links WHERE tag_id=? ORDER BY id ASC", 'i' , $tag_id );
                        while($rowb=$resb->fetch_assoc()) {
                          $wallpaperid=$rowb['wallpaper_id'];
                              $resc = $db->sql( "SELECT owner FROM wallpapers WHERE id=? ORDER BY id ASC LIMIT 1", 'i' , $wallpaperid );
                              while($rowc=$resc->fetch_assoc()) {
                                if ($rowc['owner'] == $typea){$showtag = 1;}
                              }
                        }

                  if($showtag == 1){ ?>
                  <option value="<?php echo $base_url; ?>/profile/<?php echo $typea; ?>/1/tag/<?php echo $row['slug']; ?>/" <?php if($typed==$row['slug']){echo "selected";} ?>><?php echo ucwords($row['tag_name']); ?></option>
                  <?php } } ?>
                  </select>
              </div>



              <script>
              $(document).ready(function() {
                  $('#catfilter').change(function() {
                      var url = this.value;
                      window.location.href = url;
                  });
              });
              $(document).ready(function() {
                  $('#tagfilter').change(function() {
                      var url = this.value;
                      window.location.href = url;
                  });
              });
              </script>

        </div>

    </div>




</section>
<?php include($php_base_directory . 'includes/footer.php'); }?>
