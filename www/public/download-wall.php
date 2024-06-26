<?php
$wallcount=0;
$wallres = $db->sql( "SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $typea );
while($wallrow=$wallres->fetch_assoc()) {

  $title=$wallrow['title'];
  $owner=$wallrow['owner'];

  $res = $db->sql("UPDATE wallpapers SET views=views+1 WHERE id=?", 'i' , $typea );
  $wallcount=1;

  $downloadkey = $wallrow['downloadkey'];



  
  $resolution = $typeb;

  $sfw = $wallrow['sfw'];
  if($sfw == 0){$nsfw = 1;}

  $thumb_16by9thumb = $wallrow['16by9thumb'];
  $thumb_16by10thumb = $wallrow['16by10thumb'];
  $thumb_4by3thumb = $wallrow['4by3thumb'];
  $thumb_5by4thumb = $wallrow['5by4thumb'];
  $thumb_mobilethumb = $wallrow['mobilethumb'];


  $cdnthumb_16by9thumb = str_replace($php_base_directory, $cdn_url . "/", $wallrow['16by9_share']);
  $cdnthumb_16by10thumb = str_replace($php_base_directory, $cdn_url . "/", $wallrow['16by10_share']);
  $cdnthumb_4by3thumb = str_replace($php_base_directory, $cdn_url . "/", $wallrow['4by3_share']);
  $cdnthumb_5by4thumb = str_replace($php_base_directory, $cdn_url . "/", $wallrow['5by4_share']);
  $cdnthumb_mobilethumb = str_replace($php_base_directory, $cdn_url . "/", $wallrow['mobile_share']);

  $thumb_16by9thumb = str_replace($php_base_directory, $static_url . "/", $thumb_16by9thumb);
  $thumb_16by10thumb = str_replace($php_base_directory, $static_url . "/", $thumb_16by10thumb);
  $thumb_4by3thumb = str_replace($php_base_directory, $static_url . "/", $thumb_4by3thumb);
  $thumb_5by4thumb = str_replace($php_base_directory, $static_url . "/", $thumb_5by4thumb);
  $thumb_mobilethumb = str_replace($php_base_directory, $static_url . "/", $thumb_mobilethumb);

  if ($resolution == "mobilesmall") {$titleresolution = "MOBILE 480 by 853";}
  else if ($resolution == "mobilemedium") {$titleresolution = "MOBILE 720 by 1280";}
  else if ($resolution == "mobilestandard") {$titleresolution = "MOBILE 1080 by 1920";}
  else if ($resolution == "mobilelarge") {$titleresolution = "MOBILE 1800 by 3200";}
  else {$titleresolution = str_replace("x", " by ", $resolution);}

      if($title == "") {
            $res = $db->sql( "SELECT * FROM users WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $owner );
            while($row=$res->fetch_assoc()) {
              $title = "Wallpaper by " . $row['display_name'];
            }

      }


      $pagetitle = "Wallpaper Cropper - $title $titleresolution ($typea)";
      $fullscreena=1;
      $viewwall=1;
      $codes=1;
      include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-b">
<?php include($php_base_directory . 'ads/topad.php'); ?>



  <div class="full-site-container">

    <div class="header-for-bookmark-wall-box">
      <?php if($logged_in_id > 0){ ?>
        <div id="feedback"></div>
        <?php
        $bookmarked = 0;
        $resf = $db->sql( "SELECT * FROM bookmarked_walls WHERE user_id=? AND wallpaper_id=? ORDER BY id DESC LIMIT 1", 'ii' , $logged_in_id, $typea );
        while($rowf=$resf->fetch_assoc()) {
        $bookmarked = 1;
        }?>
        <div class="bookmark-wall-box">
          <label class="bookmark">
            <input id="bookmarked" type="checkbox" <?php if($bookmarked == 1){echo "checked";} ?>>
            <span class="bookmarked star"></span>
          </label>

          <div class="feedback"><?php if($bookmarked == 1){ ?><?php } else {?>LIKE THIS WALLPAPER<?php } ?></div>
        </div>

          <script>
          $(document).ready(function() {
              //set initial state.
              $('#bookmarked').change(function() {

                  if($(this).is(':checked')) {
                    var url = "<?php echo $base_url ?>/bookmarkwall/<?php echo $typea; ?>/1/";
                    $(".feedback").load(url);
                  } else {
                    var url = "<?php echo $base_url ?>/bookmarkwall/<?php echo $typea; ?>/0/";
                    $(".feedback").load(url);
                  }

              });
          });
          </script>
        <?php }?>


      <h1 class="header-index"><?php echo $title; ?> at <?php echo $titleresolution; ?></h1>
    </div>

    <div class="wallpaper-thumb-container-index">

        <img alt="<?php echo $title;  ?>" src="<?php echo $cdn_url; ?>/view/<?php echo $downloadkey; ?>-<?php echo $typea; ?>-<?php echo $resolution; ?>.jpg" style="width:100%;" data-pagespeed-no-transform />

          <h1 class="underlinetitle">ALSO AVAILABLE IN THESE RESOLUTIONS</h1>

        <div class="resoultion-block2">

          <?php if($wallrow['mobilesmall']==null && $wallrow['mobilemedium']==null && $wallrow['mobilestandard']==null && $wallrow['mobilelarge']==null){}else{?>
              <div class="viewwallpreview">
                <div class="wall-links-box">
                  <h2>Mobile</h2>
                  <?php if($wallrow['mobilesmall']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/mobilesmall/">480x853</a><?php } ?>
                  <?php if($wallrow['mobilemedium']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/mobilemedium/">720x1280</a><?php } ?>
                  <?php if($wallrow['mobilestandard']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/mobilestandard/">1080x1920</a><?php } ?>
                  <?php if($wallrow['mobilelarge']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/mobilelarge/">1800x3200</a><?php } ?>
                </div>
              </div>
            <?php }?>

            <?php if($wallrow['1280x720']==null && $wallrow['1920x1080']==null && $wallrow['2560x1440']==null && $wallrow['3840x2160']==null){}else{?>
              <div class="viewwallpreview">
                <div class="wall-links-box">
                  <h2>16 by 9</h2>
                  <?php if($wallrow['1280x720']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1280x720/">1280x720</a><?php } ?>
                  <?php if($wallrow['1920x1080']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1920x1080/">1920x1080</a><?php } ?>
                  <?php if($wallrow['2560x1440']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/2560x1440/">2560x1440</a><?php } ?>
                  <?php if($wallrow['3840x2160']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/3840x2160/">3840x2160</a><?php } ?>
                </div>
              </div>
            <?php }?>

            <?php if($wallrow['1280x800']==null && $wallrow['1680x1050']==null && $wallrow['1920x1200']==null && $wallrow['2560x1600']==null){}else{?>
              <div class="viewwallpreview">
                <div class="wall-links-box">
                  <h2>16 by 10</h2>
                  <?php if($wallrow['1280x800']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1280x800/">1280x800 </a><?php } ?>
                  <?php if($wallrow['1680x1050']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1680x1050/">1680x1050</a><?php } ?>
                  <?php if($wallrow['1920x1200']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1920x1200/">1920x1200</a><?php } ?>
                  <?php if($wallrow['2560x1600']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/2560x1600/">2560x1600</a><?php } ?>
                </div>
              </div>
            <?php }?>

            <?php if($wallrow['1024x768']==null && $wallrow['1400x1050']==null && $wallrow['2048x1536']==null && $wallrow['2800x2100']==null){}else{?>
              <div class="viewwallpreview">
                <div class="wall-links-box">
                  <h2>4 by 3</h2>
                  <?php if($wallrow['1024x768']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1024x768/">1024x768</a><?php } ?>
                  <?php if($wallrow['1400x1050']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1400x1050/">1400x1050</a><?php } ?>
                  <?php if($wallrow['2048x1536']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/2048x1536/">2048x1536</a><?php } ?>
                  <?php if($wallrow['2800x2100']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/2800x2100/">2800x2100</a><?php } ?>
                </div>
              </div>
            <?php }?>

            <?php if($wallrow['1280x1024']==null && $wallrow['2560x2048']==null){}else{?>
              <div class="viewwallpreview">
                <div class="wall-links-box">
                  <h2>5 by 4</h2>
                  <?php if($wallrow['1280x1024']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/1280x1024/">1280x1024</a><?php } ?>
                  <?php if($wallrow['2560x2048']==null){}else{?><a href="<?php echo $base_url; ?>/downloadwall/<?php echo $wallrow['id']; ?>/2560x2048/">2560x2048</a><?php } ?>
                </div>
              </div>
            <?php }?>

        </div>


        <h1 class="underlinetitle">SHARE THIS WALLPAPER</h1>

        <div class="bbcode-container">
          <div class="code-box">
            <h5 class="code-title">BBCode</h5>

            <h6 class="code-title">16 by 9 thumbnail (recommended)</h6>
            <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>][img]<?php echo $cdnthumb_16by9thumb; ?>[/img][/url]">

            <div class="sub-codes">
              <h6 class="code-title">Mobile Thumbnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>][img]<?php echo $cdnthumb_mobilethumb; ?>[/img][/url]">
              <h6 class="code-title">16 by 10 thubmnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>][img]<?php echo $cdnthumb_16by10thumb; ?>[/img][/url]">
            </div>

            <div class="sub-codes">
              <h6 class="code-title">4 by 3 thumbnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>][img]<?php echo $cdnthumb_4by3thumb; ?>[/img][/url]">
              <h6 class="code-title">5 by 4 thumbnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>][img]<?php echo $cdnthumb_5by4thumb; ?>[/img][/url]">
            </div>

          </div>

          <div class="code-box">
            <h5 class="code-title">HTML</h5>

            <h6 class="code-title">16 by 9 thumbnail (recommended)</h6>
            <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>"><img src="<?php echo $cdnthumb_16by9thumb; ?>" border="0"/></a>'>

            <div class="sub-codes">
              <h6 class="code-title">Mobile Thumbnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>"><img src="<?php echo $cdnthumb_mobilethumb; ?>" border="0"/></a>'>
              <h6 class="code-title">16 by 10 thubmnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>"><img src="<?php echo $cdnthumb_16by10thumb; ?>" border="0"/></a>'>
            </div>

            <div class="sub-codes">
              <h6 class="code-title">4 by 3 thumbnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>"><img src="<?php echo $cdnthumb_4by3thumb; ?>" border="0"/></a>'>
              <h6 class="code-title">5 by 4 thumbnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wallrow['id'] .  "/"; ?>"><img alt="<?php echo $wallrow['title']; ?>" alt="<?php echo $wallrow['id']; ?>" src="<?php echo $cdnthumb_5by4thumb; ?>" border="0"/></a>'>
            </div>

          </div>
        </div>



    </div>
  </div>
</section>

<?php include($php_base_directory . 'includes/footer.php');?>
<?php }
 if ($wallcount == 0){
   $location = "Location: " . $base_url;
  log_malicious();
   header($location);
   exit();
 }; ?>
