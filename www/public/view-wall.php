<?php
$wallcount=0;
$mysqlquery="SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1";
$stmt = $dbconn->prepare($mysqlquery);
$stmt->bind_param('s',$typea);
$stmt->execute();
$wallres = $stmt->get_result();


while($wallrow=$wallres->fetch_assoc()) {
  $wallcount=1;

  $wall_id = $wallrow['id'];
  $create_time = $wallrow['create_time'];

  $title = $wallrow['title'];
  $owner = $wallrow['owner'];
  $image_credit = $wallrow['image_credit'];

  $downloadkey = $wallrow['downloadkey'];

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

      $mysqlquery="SELECT * FROM users WHERE id=? ORDER BY id DESC LIMIT 1";
      $stmt = $dbconn->prepare($mysqlquery);
      $stmt->bind_param('s',$owner);
      $stmt->execute();
      $res = $stmt->get_result();


      while($row=$res->fetch_assoc()) {

        $userid = $row['id'];
        $display_name = $row['display_name'];
        $avatar = $row['avatar'];
        $last_login = $row['last_login'];


          if($title == "") {
                  $title = "Wallpaper by " . $row['display_name'];
          }

      }

      $pagetitle = $title . " (" . $typea .")";
      $loadingcss = 1;
      $selectize = 1;
      $formfields=1;
      $fullscreena=1;
      $fullscreencolumn=1;
      $codes=1;
      $viewwall=1;
      include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-b">
<?php include($php_base_directory . 'ads/topad.php'); ?>
    <div class="full-site-container">

        <div class="right-column2">

          <?php if($logged_in_id > 0){ ?>
            <div id="feedback"></div>
            <?php
            $bookmarked = 0;

            $mysqlquery="SELECT * FROM bookmarked_walls WHERE user_id='$logged_in_id' AND wallpaper_id=? ORDER BY id DESC LIMIT 1";
            $stmt = $dbconn->prepare($mysqlquery);
            $stmt->bind_param('s',$wall_id);
            $stmt->execute();
            $resf = $stmt->get_result();

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
                        var url = "<?php echo $base_url ?>/bookmarkwall/<?php echo $wall_id; ?>/1/";
                        $(".feedback").load(url);
                      } else {
                        var url = "<?php echo $base_url ?>/bookmarkwall/<?php echo $wall_id; ?>/0/";
                        $(".feedback").load(url);
                      }

                  });
              });
              </script>
            <?php }?>


          <h1 class="header-index"><?php echo ucwords($title); ?></h1>

          <div class="content">

          <h3 style="width:100%; text-align:center; padding:0; margin:0;" class="bestmatch">The best match for your resolution of <script>document.write(screen.width+' by '+screen.height);</script></h3>
          <div style="width:100%; text-align:center; padding:0; margin:0;" class="bestmatchlink"></div>

<script>
  $(document).ready(function(){
    var thewidth = screen.width;
    var theheight = screen.height;

    var available480x853 = <?php if($wallrow['mobilesmall']==null){echo "0";}else{echo "1";}?>;
    var available720x1280 = <?php if($wallrow['mobilemedium']==null){echo "0";}else{echo "1";}?>;
    var available1080x1920 = <?php if($wallrow['mobilestandard']==null){echo "0";}else{echo "1";}?>;
    var available1800x3200 = <?php if($wallrow['mobilelarge']==null){echo "0";}else{echo "1";}?>;

    var available1024x768 = <?php if($wallrow['1024x768']==null){echo "0";}else{echo "1";}?>;
    var available1280x720 = <?php if($wallrow['1280x720']==null){echo "0";}else{echo "1";}?>;
    var available1280x800 = <?php if($wallrow['1280x800']==null){echo "0";}else{echo "1";}?>;
    var available1280x1024 = <?php if($wallrow['1280x1024']==null){echo "0";}else{echo "1";}?>;
    var available1400x1050 = <?php if($wallrow['1400x1050']==null){echo "0";}else{echo "1";}?>;
    var available1680x1050 = <?php if($wallrow['1680x1050']==null){echo "0";}else{echo "1";}?>;
    var available1920x1080 = <?php if($wallrow['1920x1080']==null){echo "0";}else{echo "1";}?>;
    var available1920x1200 = <?php if($wallrow['1920x1200']==null){echo "0";}else{echo "1";}?>;
    var available2048x1536 = <?php if($wallrow['2048x1536']==null){echo "0";}else{echo "1";}?>;
    var available2560x1440 = <?php if($wallrow['2560x1440']==null){echo "0";}else{echo "1";}?>;
    var available2560x1600 = <?php if($wallrow['2560x1600']==null){echo "0";}else{echo "1";}?>;
    var available2560x2048 = <?php if($wallrow['2560x2048']==null){echo "0";}else{echo "1";}?>;
    var available2800x2100 = <?php if($wallrow['2800x2100']==null){echo "0";}else{echo "1";}?>;
    var available3840x2160 = <?php if($wallrow['3840x2160']==null){echo "0";}else{echo "1";}?>;

    if (thewidth > 479 && thewidth < 720 ) {w480 = 1;} else {w480 = 0;}
    if (thewidth > 719 && thewidth < 1024) {w720 = 1;} else {w720 = 0;}
    if (thewidth > 1023 && thewidth < 1080) {w1024 = 1;} else {w1024 = 0;}
    if (thewidth > 1079 && thewidth < 1280) {w1080 = 1;} else {w1080 = 0;}
    if (thewidth > 1279 && thewidth < 1400) {w1280 = 1;} else {w1280 = 0;}
    if (thewidth > 1399 && thewidth < 1680) {w1400 = 1;} else {w1400 = 0;}
    if (thewidth > 1679 && thewidth < 1800) {w1680 = 1;} else {w1680 = 0;}
    if (thewidth > 1799 && thewidth < 1920) {w1800 = 1;} else {w1800 = 0;}
    if (thewidth > 1919 && thewidth < 2048) {w1920 = 1;} else {w1920 = 0;}
    if (thewidth > 2047 && thewidth < 2560) {w2048 = 1;} else {w2048 = 0;}
    if (thewidth > 2559 && thewidth < 2800) {w2560 = 1;} else {w2560 = 0;}
    if (thewidth > 2799 && thewidth < 3840) {w2800 = 1;} else {w2800 = 0;}
    if (thewidth > 3839 ) {w3840 = 1;} else {w3840 = 0;}

    if (theheight > 719 && theheight < 768) {h720 = 1;} else {h720 = 0;}
    if (theheight > 767 && theheight < 800) {h768 = 1;} else {h768 = 0;}
    if (theheight > 799 && theheight < 853) {h800 = 1;} else {h800 = 0;}
    if (theheight > 852 && theheight < 1024) {h853 = 1;} else {h853 = 0;}
    if (theheight > 1023 && theheight < 1050) {h1024 = 1;} else {h1024 = 0;}
    if (theheight > 1049 && theheight < 1080) {h1050 = 1;} else {h1050 = 0;}
    if (theheight > 1079 && theheight < 1200) {h1080 = 1;} else {h1080 = 0;}
    if (theheight > 1399 && theheight < 1280) {h1200 = 1;} else {h1200 = 0;}
    if (theheight > 1279 && theheight < 1440) {h1280 = 1;} else {h1280 = 0;}
    if (theheight > 1439 && theheight < 1536) {h1440 = 1;} else {h1440 = 0;}
    if (theheight > 1535 && theheight < 1600) {h1536 = 1;} else {h1536 = 0;}
    if (theheight > 1599 && theheight < 1920) {h1600 = 1;} else {h1600 = 0;}
    if (theheight > 1919 && theheight < 2048) {h1920 = 1;} else {h1920 = 0;}
    if (theheight > 2047 && theheight < 2100) {h2048 = 1;} else {h2048 = 0;}
    if (theheight > 2099 && theheight < 2160) {h2100 = 1;} else {h2100 = 0;}
    if (theheight > 2159 && theheight < 3200) {h2160 = 1;} else {h2160 = 0;}
    if (theheight > 3199) {h3200 = 1;} else {h3200 = 0;}

         if (w480 == 1 && h853 == 1 && available480x853 == 1) {
      $( ".w480x853" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilesmall/">480x853</a>' );
    }
    else if (w720 == 1 && h1280 == 1 && available720x1280 == 1) {
      $( ".w720x1280" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilesmall/">720x1280</a>' );
    }
    else if (w1080 == 1 && h1920 == 1 && available1080x1920 == 1) {
      $( ".w1080x1920" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilestandard/">1080x1920</a>' );
    }
    else if (w1800 == 1 && h3200 == 1 && available1800x3200 == 1) {
      $( ".w1800x3200" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilelarge/">1800x3200</a>' );
    }
    else if (w1024 == 1 && h768 == 1 && available1024x768 == 1) {
      $( ".w1024x768" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1024x768/">1024x768</a>' );
    }
    else if (w1280 == 1 && h720 == 1 && available1280x720 == 1) {
      $( ".w1280x720" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1280x720/">1280x720</a>' );
    }
    else if (w1280 == 1 && h800 == 1 && available1280x800 == 1) {
      $( ".w1280x800" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1280x800/">1280x800</a>' );
    }
    else if (w1280 == 1 && h1024 == 1 && available1280x1024 == 1) {
      $( ".w1280x1024" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1280x1024/">1280x1024</a>' );
    }
    else if (w1400 == 1 && h1050 == 1 && available1400x1050 == 1) {
      $( ".w1400x1050" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1400x1050/">1400x1050</a>' );
    }
    else if (w1680 == 1 && h1050 == 1 && available1680x1050 == 1) {
      $( ".w1680x1050" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1680x1050/">1680x1050</a>' );
    }
    else if (w1920 == 1 && h1080 == 1 && available1920x1080 == 1) {
      $( ".w1920x1080" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1920x1080/">1920x1080</a>' );
    }
    else if (w1920 == 1 && h1200 == 1 && available1920x1200 == 1) {
      $( ".w1920x1200" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1920x1200/">1920x1200</a>' );
    }
    else if (w2048 == 1 && h1536 == 1 && available2048x1536 == 1) {
      $( ".w2048x1536" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2048x1536/">2048x1536</a>' );
    }
    else if (w2560 == 1 && h1440 == 1 && available2560x1440 == 1) {
      $( ".w2560x1440" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2560x1440/">2560x1440</a>' );
    }
    else if (w2560 == 1 && h1600 == 1 && available2560x1600 == 1) {
      $( ".w2560x1600" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2560x1600/">2560x1600</a>' );
    }
    else if (w2560 == 1 && h2048 == 1 && available2560x2048 == 1) {
      $( ".w2560x2048" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2560x2048/">2560x2048</a>' );
    }
    else if (w2800 == 1 && h2100 == 1 && available2800x2100 == 1) {
      $( ".w2800x2100" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2800x2100/">2800x2100</a>' );
    }
    else if (w3840 == 1 && h2160 == 1 && available3840x2160 == 1) {
      $( ".w3840x2160" ).addClass( "flash" );
      $( ".bestmatchlink" ).html( '<a class="bestmatchlink" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/3840x2160/">3840x2160</a>' );
    }
    else {
      $(".bestmatch").css('display', 'none');
      $(".bestmatchlink").css('display', 'none');
    }
  });
</script>
          <div class="resoultion-block">

              <?php if($wallrow['mobilesmall']==null && $wallrow['mobilemedium']==null && $wallrow['mobilestandard']==null && $wallrow['mobilelarge']==null){}else{?>
                <?php if($mobile==1){?>
                    <div class="viewwallpreview">
                      <div class="thumbmobile" style="background:url('<?php echo $thumb_mobilethumb; ?>'); background-size:cover; background-repeat:no-repeat;"></div>
                      <div class="wall-links-box">
                        <h2>Mobile</h2>
                        <?php if($wallrow['mobilesmall']==null){}else{?><a class="w480x853" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilesmall/">480x853</a><?php } ?>
                        <?php if($wallrow['mobilemedium']==null){}else{?><a class="w720x1280" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilemedium/">720x1280</a><?php } ?>
                        <?php if($wallrow['mobilestandard']==null){}else{?><a class="w1080x1920" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilestandard/">1080x1920</a><?php } ?>
                        <?php if($wallrow['mobilelarge']==null){}else{?><a class="w1800x3200" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilelarge/">1800x3200</a><?php } ?>
                      </div>
                    </div>
                <?php }?>
              <?php }?>

              <?php if($wallrow['1280x720']==null && $wallrow['1920x1080']==null && $wallrow['2560x1440']==null && $wallrow['3840x2160']==null){}else{?>
                <div class="viewwallpreview">
                  <div class="thumb16x9" style="background:url('<?php echo $thumb_16by9thumb; ?>'); background-size:cover; background-repeat:no-repeat;"></div>
                  <div class="wall-links-box">
                    <h2>16 by 9</h2>
                    <?php if($wallrow['1280x720']==null){}else{?><a class="w1280x720" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1280x720/">1280x720</a><?php } ?>
                    <?php if($wallrow['1920x1080']==null){}else{?><a class="w1920x1080" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1920x1080/">1920x1080</a><?php } ?>
                    <?php if($wallrow['2560x1440']==null){}else{?><a class="w2560x1440" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2560x1440/">2560x1440</a><?php } ?>
                    <?php if($wallrow['3840x2160']==null){}else{?><a class="w3840x2160" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/3840x2160/">3840x2160</a><?php } ?>
                  </div>
                </div>
              <?php }?>

              <?php if($wallrow['1280x800']==null && $wallrow['1680x1050']==null && $wallrow['1920x1200']==null && $wallrow['2560x1600']==null){}else{?>
                <div class="viewwallpreview">
                  <div class="thumb16x10" style="background:url('<?php echo $thumb_16by10thumb; ?>'); background-size:cover; background-repeat:no-repeat;"></div>
                  <div class="wall-links-box">
                    <h2>16 by 10</h2>
                    <?php if($wallrow['1280x800']==null){}else{?><a class="w1280x800" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1280x800/">1280x800 </a><?php } ?>
                    <?php if($wallrow['1680x1050']==null){}else{?><a class="w1680x1050" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1680x1050/">1680x1050</a><?php } ?>
                    <?php if($wallrow['1920x1200']==null){}else{?><a class="w1920x1200" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1920x1200/">1920x1200</a><?php } ?>
                    <?php if($wallrow['2560x1600']==null){}else{?><a class="w2560x1600" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2560x1600/">2560x1600</a><?php } ?>
                  </div>
                </div>
              <?php }?>

              <?php if($wallrow['1024x768']==null && $wallrow['1400x1050']==null && $wallrow['2048x1536']==null && $wallrow['2800x2100']==null){}else{?>
                <div class="viewwallpreview">
                  <div class="thumb4x3" style="background:url('<?php echo $thumb_4by3thumb; ?>'); background-size:cover; background-repeat:no-repeat;"></div>
                  <div class="wall-links-box">
                    <h2>4 by 3</h2>
                    <?php if($wallrow['1024x768']==null){}else{?><a class="w1024x768" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1024x768/">1024x768</a><?php } ?>
                    <?php if($wallrow['1400x1050']==null){}else{?><a class="w1400x1050" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1400x1050/">1400x1050</a><?php } ?>
                    <?php if($wallrow['2048x1536']==null){}else{?><a class="w2048x1536" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2048x1536/">2048x1536</a><?php } ?>
                    <?php if($wallrow['2800x2100']==null){}else{?><a class="w2800x2100" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2800x2100/">2800x2100</a><?php } ?>
                  </div>
                </div>
              <?php }?>

              <?php if($wallrow['1280x1024']==null && $wallrow['2560x2048']==null){}else{?>
                <div class="viewwallpreview">
                  <div class="thumb5x4" style="background:url('<?php echo $thumb_5by4thumb; ?>'); background-size:cover; background-repeat:no-repeat;"></div>
                  <div class="wall-links-box">
                    <h2>5 by 4</h2>
                    <?php if($wallrow['1280x1024']==null){}else{?><a class="w1280x1024" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/1280x1024/">1280x1024</a><?php } ?>
                    <?php if($wallrow['2560x2048']==null){}else{?><a class="w2560x2048" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/2560x2048/">2560x2048</a><?php } ?>
                  </div>
                </div>
              <?php }?>


            <?php if($wallrow['mobilesmall']==null && $wallrow['mobilemedium']==null && $wallrow['mobilestandard']==null && $wallrow['mobilelarge']==null){}else{?>
                <?php if($mobile==0){?>
                <div class="viewwallpreview">
                  <div class="thumbmobile" style="background:url('<?php echo $thumb_mobilethumb; ?>'); background-size:cover; background-repeat:no-repeat;"></div>
                  <div class="wall-links-box">
                    <h2>Mobile</h2>
                    <?php if($wallrow['mobilesmall']==null){}else{?><a class="w480x853" class="" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilesmall/">480x853</a><?php } ?>
                    <?php if($wallrow['mobilemedium']==null){}else{?><a class="w720x1280" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilemedium/">720x1280</a><?php } ?>
                    <?php if($wallrow['mobilestandard']==null){}else{?><a class="w1080x1920" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilestandard/">1080x1920</a><?php } ?>
                    <?php if($wallrow['mobilelarge']==null){}else{?><a class="w1800x3200" href="<?php echo $base_url; ?>/downloadwall/<?php echo $wall_id; ?>/mobilelarge/">1800x3200</a><?php } ?>
                  </div>
                </div>
              <?php }?>
            <?php }?>

          </div>

          <h1 class="underlinetitle">SHARE THIS WALLPAPER</h1>

          <div class="bbcode-container">
            <div class="code-box">
              <h5 class="code-title">BBCode</h5>

              <h6 class="code-title">16 by 9 thumbnail (recommended)</h6>
              <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>][img]<?php echo $cdnthumb_16by9thumb; ?>[/img][/url]">

              <div class="sub-codes">
                <h6 class="code-title">Mobile Thumbnail</h6>
                <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>][img]<?php echo $cdnthumb_mobilethumb; ?>[/img][/url]">
                <h6 class="code-title">16 by 10 thubmnail</h6>
                <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>][img]<?php echo $cdnthumb_16by10thumb; ?>[/img][/url]">
              </div>

              <div class="sub-codes">
                <h6 class="code-title">4 by 3 thumbnail</h6>
                <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>][img]<?php echo $cdnthumb_4by3thumb; ?>[/img][/url]">
                <h6 class="code-title">5 by 4 thumbnail</h6>
                <input class="codebox" onclick="this.select()" type="text" value="[url=<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>][img]<?php echo $cdnthumb_5by4thumb; ?>[/img][/url]">
              </div>

            </div>

            <div class="code-box">
              <h5 class="code-title">HTML</h5>

              <h6 class="code-title">16 by 9 thumbnail (recommended)</h6>
              <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>"><img alt="<?php echo $title; ?>" src="<?php echo $cdnthumb_16by9thumb; ?>" border="0"/></a>'>

              <div class="sub-codes">
                <h6 class="code-title">Mobile Thumbnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>"><img alt="<?php echo $title; ?>" src="<?php echo $cdnthumb_mobilethumb; ?>" border="0"/></a>'>
              <h6 class="code-title">16 by 10 thubmnail</h6>
              <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>"><img alt="<?php echo $title; ?>" src="<?php echo $cdnthumb_16by10thumb; ?>" border="0"/></a>'>
              </div>

              <div class="sub-codes">
                <h6 class="code-title">4 by 3 thumbnail</h6>
                <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>"><img alt="<?php echo $title; ?>" src="<?php echo $cdnthumb_4by3thumb; ?>" border="0"/></a>'>
                <h6 class="code-title">5 by 4 thumbnail</h6>
                <input class="codebox" onclick="this.select()" type="text" value='<a href="<?php echo $base_url . "/view-wall/" . $wall_id .  "/"; ?>"><img alt="<?php echo $title; ?>" src="<?php echo $cdnthumb_5by4thumb; ?>" border="0"/></a>'>
              </div>

            </div>

          </div>

        </div>
        </div>


        <div class="left-column2">
              <div class="avatar2">
                <img class="avatar2-img" alt="<?php echo $title; ?>" src="<?php echo $static_url; ?>/avatars/<?php echo $avatar; ?>" alt="<?php echo $display_name; ?>" />
              </div>

              <div class="profile2">
                <h3>Wallpaper Created By</h3>
                <h1><a href="<?php echo $base_url; ?>/profile/<?php echo $userid; ?>/"><?php echo $display_name; ?></a></h1>
                <h2>Created on <?php echo gmdate('dS M Y', $create_time); ?></h2>
              </div>

              <div class="catsandtags">
                <h4>Categories</h4>
                <?php
                $res = $db->sql( "SELECT * FROM category_links INNER JOIN category ON category_links.category_id = category.id WHERE category_links.wallpaper_id=? ORDER BY category.cat_name ASC", 'i' , $wall_id );
                while($row=$res->fetch_assoc()) {
                  $cat_name = $row['cat_name'];
                  $cat_name = ucwords($cat_name);
                  $cat_slug = $row['slug'];
                  ?>
                  <a class="wallcatlink" rel="nofollow" href="<?php echo $base_url ?>/category/<?php echo $cat_slug; ?>/" ><?php echo $cat_name; ?></a>
                <?php }?>

                <?php
                $tagscount = 1;
                $res = $db->sql( "SELECT * FROM tag_links INNER JOIN tags ON tag_links.tag_id = tags.id WHERE tag_links.wallpaper_id=? ORDER BY tags.tag_name ASC", 'i' , $wall_id );
                while($row=$res->fetch_assoc()) {
                  $tag_name = $row['tag_name'];
                  $tag_name = ucwords($tag_name);
                  $tag_slug = $row['slug'];
                ?>
                <?php if($tagscount == 1){?>
                  <div class="tagspacer"></div>
                  <h4>Tags</h4>
                <?php }?>
                  <a class="taglink" rel="nofollow" href="<?php echo $base_url ?>/tag/<?php echo $tag_slug; ?>/" ><?php echo $tag_name; ?></a>
                <?php $tagscount = $tagscount+1; }?>

                <?php if($image_credit == null){}else{ ?>
                  <div class="tagspacer"></div>

                  <h4>Image source/credit</h4>
                  <p><?php echo $image_credit; ?></p>
                <?php }?>


                <?php if($logged_in_id > 0){ ?>
                <div class="tagspacer"></div>
                <div class="tagspacer"></div>

                <h4>Member Tools</h4>

                <form action="<?php echo $base_url; ?>/update/collection/<?php echo $wall_id ?>/" method="post">
                  <div class="dropdown-select">
                    <div class="control-group">

                      <select id="select-collection" placeholder="Add to collection" name="collection[]" multiple style="width:100%">
                        <?php
                        $resf = $db->sql( "SELECT * FROM collections WHERE owner_id=? ORDER BY name ASC", 'i' , $logged_in_id );
                        while($rowf=$resf->fetch_assoc()) {
                          $collection_id = $rowf['id'];
                          ?>

                          <?php $collection_count = 0;
                          $resg = $db->sql( "SELECT * FROM collection_links WHERE collection_id = ? AND wallpaper_id = ? ORDER BY id ASC", 'ii' , $collection_id, $wall_id );
                          while($rowg=$resg->fetch_assoc()) { $collection_count = 1; }?>

                          <option <?php if($collection_count == 1){echo "selected";} ?> value="<?php echo $rowf['name']; ?>"><?php echo $rowf['name']; ?></option>

                        <?php }?>
                      </select>
                      <div id="feedback"></div>
                    </div>

                    <input class="submit" type="submit" value="Update Collections" id="submit" onclick="loading();" />
                  </form>

                  <?php if($owner == $logged_in_id or $logged_in_id == 1){ ?>
                    <a style="margin:25px 0 0 0; text-align:center;" class="wallcatlink" rel="nofollow" href="<?php echo $base_url ?>/edit-wall/<?php echo $wall_id; ?>/" >Edit This Wallpaper</a>
                  <?php } ?>

                  <script>
                  $('#select-collection').selectize({
                      create: true,
                      sortField: {
                          field: 'text',
                          direction: 'asc'
                      },
                      dropdownParent: 'body'
                  });
                  </script>
                </div>

                <?php }?>

              </div>
        </div>


    </div>
</section>

<?php if($logged_in_id > 0){ ?>
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
<?php }
 if ($wallcount == 0){
   $location = "Location: " . $base_url;
    log_malicious();
   header($location);
   exit();
 }; ?>
