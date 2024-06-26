<?php
$res = $db->sql( "SELECT * FROM collections WHERE id =? ORDER BY id ASC", 'i' , $typea );
while($row=$res->fetch_assoc()) {
$collection_id = $row['id'];
$collection_name = $row['name'];
$collection_owner = $row['owner_id'];
}


$resb = $db->sql( "SELECT * FROM users WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $collection_owner );
while($rowb=$resb->fetch_assoc()) {
  $avatar = $rowb['avatar'];
  $display_name = $rowb['display_name'];
  $last_login = $rowb['last_login'];
  $bio = $rowb['bio'];
}


      $pagetitle = $collection_name . " by " . $display_name;
      if($typeb == null){}else{$pagetitle = $pagetitle . " (Page " . $typeb . ")";}
      $loadingcss = 1;
      $pagenate = 1;
      $formfields=1;
      $fullscreena=1;
      $fullscreencolumn=1;
      $codes=1;
      include($php_base_directory . 'includes/header.php');
      ?>

<section id="fullscreen-b">
  <div class="responsive-container"></div>

    <div class="full-site-container">

      <div class="right-column2">

        <h1 class="header-index"><?php echo $pagetitle; ?></h1>

          <div class="content">

              <div class="wallpaper-thumb-container">

                <div class="wallpaper-thumb-container-profile">

                      <?php
                      $total = $db->sql( "SELECT * FROM collection_links WHERE collection_id = ? ORDER BY id DESC", 'i' , $typea );
                      $total = $total->num_rows;
                      $limit = 18;
                      $pages = ceil($total / $limit);

                      $page = $typeb;
                      if ($page == null) {$page = 1;}
                      $offset = ($page - 1)  * $limit;
                      ?>

                      <div class="pagenavi1">
                        <?php $prefix="collection/" . $typea; include('includes/pagenate.php'); ?>
                      </div>

                        <?php
                        $resb = $db->sql( "SELECT * FROM collection_links INNER JOIN wallpapers ON collection_links.wallpaper_id = wallpapers.id WHERE collection_links.collection_id = ? ORDER BY collection_links.wallpaper_id DESC LIMIT $limit OFFSET $offset", 'i' , $typea );
                        while($rowb=$resb->fetch_assoc()) {

                                 if ($defaultratio == "16by9"){$thumb = $rowb['16by9thumb'];}
                            else if ($defaultratio == "16by10"){$thumb = $rowb['16by10thumb'];}
                            else if ($defaultratio == "4by3"){$thumb = $rowb['4by3thumb'];}
                            else if ($defaultratio == "5by4"){$thumb = $rowb['5by4thumb'];}
                            else if ($defaultratio == "mobile"){$thumb = $rowb['mobilethumb'];}
                            else {$thumb = $rowb['16by9thumb'];}

                            $thumb = str_replace($php_base_directory,$static_url."/",$thumb);

                          ?>

                          <div class="wall-box-profile">
                            <div class="wall-box-inner-profile">
                              <a class="walllink" href="<?php echo $base_url ?>/view-wall/<?php echo $rowb['id'];?>/"><img alt="<?php echo $rowb['title']; ?>" class="wall-box-image-profile" src="<?php echo $thumb; ?>" />
                              <?php if ($rowb['title'] == "" or $rowb['title'] == null ) {} else {?>
                                <span class="walltitle"><?php echo $rowb['title']; ?></span>
                              <?php } ?></a>
                              <?php if($logged_in_id == $collection_owner){ ?>
                                <a class="delete-collection" href="<?php echo $base_url ?>/update/delete-from-collection/<?php echo $collection_id;?>/<?php echo $rowb['id'];?>/" onclick="loading();"></a>
                              <?php } ?>
                            </div>
                          </div>

                        <?php $firstlink=0; } ?>

                        <div class="pagenavi2">
                          <?php $prefix="collection/" . $typea; include('includes/pagenate.php'); ?>
                        </div>


                  </div>

              </div>

              <h1 class="underlinetitle">SHARE THIS COLLECTION</h1>


              <?php

              $bb16by9 = "";
              $bbmobile = "";
              $bb4by3 = "";
              $bb16by10 = "";
              $bb5by4 = "";

              $html16by9 = "";
              $htmlmobile = "";
              $html4by3 = "";
              $html16by10 = "";
              $html5by4 = "";

              $resb = $db->sql( "SELECT * FROM collection_links INNER JOIN wallpapers ON collection_links.wallpaper_id = wallpapers.id WHERE collection_links.collection_id = ? ORDER BY collection_links.wallpaper_id DESC", 'i' , $typea );
              while($rowb=$resb->fetch_assoc()) {

                  $cdnthumb_16by9thumb = str_replace($php_base_directory, $cdn_url . "/", $rowb['16by9_share']);
                  $cdnthumb_16by10thumb = str_replace($php_base_directory, $cdn_url . "/", $rowb['16by10_share']);
                  $cdnthumb_4by3thumb = str_replace($php_base_directory, $cdn_url . "/", $rowb['4by3_share']);
                  $cdnthumb_5by4thumb = str_replace($php_base_directory, $cdn_url . "/", $rowb['5by4_share']);
                  $cdnthumb_mobilethumb = str_replace($php_base_directory, $cdn_url . "/", $rowb['mobile_share']);

                  $bb16by9 = $bb16by9 . '[url=' . $base_url . '/view-wall/' . $rowb['id'] .  '/][img]' . $cdnthumb_16by9thumb . '[/img][/url]';
                  $bbmobile = $bbmobile . '[url=' . $base_url . '/view-wall/' . $rowb['id'] .  '/][img]' . $cdnthumb_mobilethumb . '[/img][/url]';
                  $bb4by3 = $bb4by3 . '[url=' . $base_url . '/view-wall/' . $rowb['id'] .  '/][img]' . $cdnthumb_4by3thumb . '[/img][/url]';
                  $bb16by10 = $bb16by10 . '[url=' . $base_url . '/view-wall/' . $rowb['id'] .  '/][img]' . $cdnthumb_16by10thumb . '[/img][/url]';
                  $bb5by4 = $bb5by4 . '[url=' . $base_url . '/view-wall/' . $rowb['id'] .  '/][img]' . $cdnthumb_5by4thumb . '[/img][/url]';

                  $html16by9 = $html16by9 . '<a href="'. $base_url . '/view-wall/' . $rowb['id'] .  '/"><img src="' . $cdnthumb_16by9thumb . '" border="0"/></a>';
                  $htmlmobile = $htmlmobile . '<a href="'. $base_url . '/view-wall/' . $rowb['id'] .  '/"><img src="' . $cdnthumb_mobilethumb . '" border="0"/></a>';
                  $html4by3 = $html4by3 . '<a href="'. $base_url . '/view-wall/' . $rowb['id'] .  '/"><img src="' . $cdnthumb_4by3thumb . '" border="0"/></a>';
                  $html16by10 = $html16by10 . '<a href="'. $base_url . '/view-wall/' . $rowb['id'] .  '/"><img src="' . $cdnthumb_16by10thumb . '" border="0"/></a>';
                  $html5by4 = $html5by4 . '<a href="'. $base_url . '/view-wall/' . $rowb['id'] .  '/"><img src="' . $cdnthumb_5by4thumb . '" border="0"/></a>';


              }
              ?>

              <div class="bbcode-container">
                <div class="code-box">
                  <h5 class="code-title">BBCode</h5>

                  <h6 class="code-title">16 by 9 thumbnails (recommended)</h6>
                  <input class="codebox" onclick="this.select()" type="text" value="<?php echo $bb16by9; ?>">

                  <div class="sub-codes">
                    <h6 class="code-title">Mobile Thumbnails</h6>
                    <input class="codebox" onclick="this.select()" type="text" value="<?php echo $bbmobile; ?>">
                    <h6 class="code-title">16 by 10 thubmnails</h6>
                    <input class="codebox" onclick="this.select()" type="text" value="<?php echo $bb16by10; ?>">
                  </div>

                  <div class="sub-codes">
                    <h6 class="code-title">4 by 3 thumbnails</h6>
                    <input class="codebox" onclick="this.select()" type="text" value="<?php echo $bb4by3; ?>">
                    <h6 class="code-title">5 by 4 thumbnails</h6>
                    <input class="codebox" onclick="this.select()" type="text" value="<?php echo $bb5by4; ?>">
                  </div>

                </div>

                <div class="code-box">
                  <h5 class="code-title">HTML</h5>

                  <h6 class="code-title">16 by 9 thumbnails (recommended)</h6>
                  <input class="codebox" onclick="this.select()" type="text" value='<?php echo $html16by9; ?>'>

                  <div class="sub-codes">
                    <h6 class="code-title">Mobile Thumbnails</h6>
                  <input class="codebox" onclick="this.select()" type="text" value='<?php echo $htmlmobile; ?>'>
                  <h6 class="code-title">16 by 10 thubmnails</h6>
                  <input class="codebox" onclick="this.select()" type="text" value='<?php echo $html16by10; ?>'>
                  </div>

                  <div class="sub-codes">
                    <h6 class="code-title">4 by 3 thumbnails</h6>
                    <input class="codebox" onclick="this.select()" type="text" value='<?php echo $html4by3; ?>'>
                    <h6 class="code-title">5 by 4 thumbnails</h6>
                    <input class="codebox" onclick="this.select()" type="text" value='<?php echo $html5by4; ?>'>
                  </div>

                </div>


              </div>



          </div>
        </div>


        <div class="left-column2">

              <div class="avatar2">
                <img class="avatar2-img" src="<?php echo $static_url; ?>/avatars/<?php echo $avatar; ?>" alt="<?php echo $display_name; ?>" />
              </div>

              <div class="profile2">
                <h1><?php echo $collection_name; ?></h1>
                <h3>A Collection By <a href="<?php echo $base_url; ?>/profile/<?php echo $collection_owner; ?>/"><?php echo $display_name; ?></a></h3>
                <h6>Last active <?php echo lastactive($last_login); ?></h6>
              </div>

              <?php if($logged_in_id == $collection_owner){ ?>
              <div class="catsandtags">
                <h4>Owner Tools</h4>
                <form action="<?php echo $base_url; ?>/update/collection-details/<?php echo $collection_id; ?>/" method="post">

                  <label for="title">Collection Name</label>
                  <input class="form-field" type="text" name="name" value="<?php echo $collection_name; ?>">

                  <input class="submit" type="submit" value="Update Collection" id="submit" onclick="loading();" />
                </form>

                <a class="delete-a" style="display:block;width:100%;font-size: 12px; cursor:pointer; padding:5px 0; margin:50px auto 0 auto;color:#fff; background:#000;font-weight: bold;text-decoration: none;text-align: center;
                " onclick="deleteswitch();">DELETE COLLECTION</a>

                <a class="delete-b" style="display: none;width:100%;font-size: 12px;padding:5px 0; margin:50px auto 0 auto;color:#fff; background:#ed2024;font-weight: bold;text-decoration: none;text-align: center;
                " onclick="loading();" href="<?php echo $base_url ?>/update/delete-collection/<?php echo $collection_id;?>/">DELETE COLLECTION</a>
              </div>
              <?php }?>

        </div>

    </div>

</section>

<script>
function deleteswitch(){
  $(".delete-a").css("display", "none");
  $(".delete-b").css("display", "block");
}
</script>

<?php if($logged_in_id == $collection_owner){ ?>
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
<?php }?>

<?php include($php_base_directory . 'includes/footer.php');?>
