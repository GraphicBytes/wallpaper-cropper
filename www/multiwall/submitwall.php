<?php

include($php_base_directory . 'config/smtp.php');
require $php_base_directory . 'functions/PHPMailer/src/Exception.php';
require $php_base_directory . 'functions/PHPMailer/src/PHPMailer.php';
require $php_base_directory . 'functions/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);



if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $iid = $typea;

  //$mysqlquery="SELECT * FROM wall_generation WHERE id='$iid' AND complete = '0' ORDER BY ID DESC LIMIT 1";
  $res = $db->sql("SELECT * FROM wall_generation WHERE id=? ORDER BY ID DESC LIMIT 1", 'i', $iid);
  while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $owner = $row['owner'];

    $thumb16by9 = $row['thumbnail'];
    $thumb16by10 = $row['16by10thumb'];
    $thumb4by3 = $row['4by3thumb'];
    $thumb5by4 = $row['5by4thumb'];
    $thumbmobile = $row['mobilethumb'];
    $file_3840x2160 = $row['3840x2160'];
    $file_2560x1440 = $row['2560x1440'];
    $file_1920x1080 = $row['1920x1080'];
    $file_1280x720 = $row['1280x720'];
    $file_2560x1600 = $row['2560x1600'];
    $file_1920x1200 = $row['1920x1200'];
    $file_1680x1050 = $row['1680x1050'];
    $file_1280x800 = $row['1280x800'];
    $file_2800x2100 = $row['2800x2100'];
    $file_2048x1536 = $row['2048x1536'];
    $file_1400x1050 = $row['1400x1050'];
    $file_1024x768 = $row['1024x768'];
    $file_2560x2048 = $row['2560x2048'];
    $file_1280x1024 = $row['1280x1024'];
    $file_mobilesmall = $row['mobilesmall'];
    $file_mobilemedium = $row['mobilemedium'];
    $file_mobilestandard = $row['mobilestandard'];
    $file_mobilelarge = $row['mobilelarge'];

    $file_16by9_share = $row['16by9_share'];
    $file_16by10_share = $row['16by10_share'];
    $file_4by3_share = $row['4by3_share'];
    $file_5by4_share = $row['5by4_share'];
    $file_mobile_share = $row['mobile_share'];
  }
  if ($logged_in_id == $owner) {

    //is category set
    if (!isset($_POST['category'])) {
      $location = "Location: " . $base_url . "/review/" . $iid . "/notcat/";
      header($location);
      exit();
    } else {

      $permanant_home = $php_base_directory . "wallpapers/" . date("Y") . "/" . date("m") . "/" . date("d") . "/" . $id . "/";

      //Create Directory
      if (!file_exists($permanant_home)) {
        mkdir($permanant_home, 0777, true);
      }

      //Move files to their new home
      if ($thumb16by9 == "") {
        $newhomethumb16by9 = null;
      } else {
        $newhomethumb16by9 = $permanant_home . "thumb16by9.jpg";
        rename($thumb16by9, $newhomethumb16by9);
      }
      if ($thumb16by10 == "") {
        $newhomethumb16by10 = null;
      } else {
        $newhomethumb16by10 = $permanant_home . "thumb16by10.jpg";
        rename($thumb16by10, $newhomethumb16by10);
      }
      if ($thumb4by3 == "") {
        $newhomethumb4by3 = null;
      } else {
        $newhomethumb4by3 = $permanant_home . "thumb4by3.jpg";
        rename($thumb4by3, $newhomethumb4by3);
      }
      if ($thumb5by4 == "") {
        $newhomethumb5by4 = null;
      } else {
        $newhomethumb5by4 = $permanant_home . "thumb5by4.jpg";
        rename($thumb5by4, $newhomethumb5by4);
      }
      if ($thumbmobile == "") {
        $newhomethumbmobile = null;
      } else {
        $newhomethumbmobile = $permanant_home . "thumbmobile.jpg";
        rename($thumbmobile, $newhomethumbmobile);
      }

      if ($file_16by9_share == "") {
        $newhomeshare16by9 = null;
      } else {
        $newhomeshare16by9 = $permanant_home . "share16by9.jpg";
        rename($file_16by9_share, $newhomeshare16by9);
      }
      if ($file_16by10_share == "") {
        $newhomeshare16by10 = null;
      } else {
        $newhomeshare16by10 = $permanant_home . "share16by10.jpg";
        rename($file_16by10_share, $newhomeshare16by10);
      }
      if ($file_4by3_share == "") {
        $newhomeshare4by3 = null;
      } else {
        $newhomeshare4by3 = $permanant_home . "share4by3.jpg";
        rename($file_4by3_share, $newhomeshare4by3);
      }
      if ($file_5by4_share == "") {
        $newhomeshare5by4 = null;
      } else {
        $newhomeshare5by4 = $permanant_home . "share5by4.jpg";
        rename($file_5by4_share, $newhomeshare5by4);
      }
      if ($file_mobile_share == "") {
        $newhomesharemobile = null;
      } else {
        $newhomesharemobile = $permanant_home . "sharemobile.jpg";
        rename($file_mobile_share, $newhomesharemobile);
      }

      if ($file_3840x2160 == "") {
        $newhome3840x2160 = null;
      } else {
        $newhome3840x2160 = $permanant_home . random_str(5) . "3840x2160.jpg";
        rename($file_3840x2160, $newhome3840x2160);
      }
      if ($file_2560x1440 == "") {
        $newhome2560x1440 = null;
      } else {
        $newhome2560x1440 = $permanant_home . random_str(5) . "2560x1440.jpg";
        rename($file_2560x1440, $newhome2560x1440);
      }
      if ($file_1920x1080 == "") {
        $newhome1920x1080 = null;
      } else {
        $newhome1920x1080 = $permanant_home . random_str(5) . "1920x1080.jpg";
        rename($file_1920x1080, $newhome1920x1080);
      }
      if ($file_1280x720 == "") {
        $newhome1280x720 = null;
      } else {
        $newhome1280x720 = $permanant_home . random_str(5) . "1280x720.jpg";
        rename($file_1280x720, $newhome1280x720);
      }
      if ($file_2560x1600 == "") {
        $newhome2560x1600 = null;
      } else {
        $newhome2560x1600 = $permanant_home . random_str(5) . "2560x1600.jpg";
        rename($file_2560x1600, $newhome2560x1600);
      }
      if ($file_1920x1200 == "") {
        $newhome1920x1200 = null;
      } else {
        $newhome1920x1200 = $permanant_home . random_str(5) . "1920x1200.jpg";
        rename($file_1920x1200, $newhome1920x1200);
      }
      if ($file_1680x1050 == "") {
        $newhome1680x1050 = null;
      } else {
        $newhome1680x1050 = $permanant_home . random_str(5) . "1680x1050.jpg";
        rename($file_1680x1050, $newhome1680x1050);
      }
      if ($file_1280x800 == "") {
        $newhome1280x800 = null;
      } else {
        $newhome1280x800 = $permanant_home . random_str(5) . "1280x800.jpg";
        rename($file_1280x800, $newhome1280x800);
      }
      if ($file_2800x2100 == "") {
        $newhome2800x2100 = null;
      } else {
        $newhome2800x2100 = $permanant_home . random_str(5) . "2800x2100.jpg";
        rename($file_2800x2100, $newhome2800x2100);
      }
      if ($file_2048x1536 == "") {
        $newhome2048x1536 = null;
      } else {
        $newhome2048x1536 = $permanant_home . random_str(5) . "2048x1536.jpg";
        rename($file_2048x1536, $newhome2048x1536);
      }
      if ($file_1400x1050 == "") {
        $newhome1400x1050 = null;
      } else {
        $newhome1400x1050 = $permanant_home . random_str(5) . "1400x1050.jpg";
        rename($file_1400x1050, $newhome1400x1050);
      }
      if ($file_1024x768 == "") {
        $newhome1024x768 = null;
      } else {
        $newhome1024x768 = $permanant_home . random_str(5) . "1024x768.jpg";
        rename($file_1024x768, $newhome1024x768);
      }
      if ($file_2560x2048 == "") {
        $newhome2560x2048 = null;
      } else {
        $newhome2560x2048 = $permanant_home . random_str(5) . "2560x2048.jpg";
        rename($file_2560x2048, $newhome2560x2048);
      }
      if ($file_1280x1024 == "") {
        $newhome1280x1024 = null;
      } else {
        $newhome1280x1024 = $permanant_home . random_str(5) . "1280x1024.jpg";
        rename($file_1280x1024, $newhome1280x1024);
      }
      if ($file_mobilestandard == "") {
        $newhomemobilestandard = null;
      } else {
        $newhomemobilestandard = $permanant_home . random_str(5) . "mobilestandard.jpg";
        rename($file_mobilestandard, $newhomemobilestandard);
      }
      if ($file_mobilelarge == "") {
        $newhomemobilelarge = null;
      } else {
        $newhomemobilelarge = $permanant_home . random_str(5) . "mobilelarge.jpg";
        rename($file_mobilelarge, $newhomemobilelarge);
      }
      if ($file_mobilemedium == "") {
        $newhomemobilemedium = null;
      } else {
        $newhomemobilemedium = $permanant_home . random_str(5) . "mobilemedium.jpg";
        rename($file_mobilemedium, $newhomemobilemedium);
      }
      if ($file_mobilesmall == "") {
        $newhomemobilesmall = null;
      } else {
        $newhomemobilesmall = $permanant_home . random_str(5) . "mobilesmall.jpg";
        rename($file_mobilesmall, $newhomemobilesmall);
      }

      $walltitle = $_POST['title'];
      $credit = $_POST['credit'];

      $current_time = time();

      $download_key = random_str(5);

      $mysqlquery = "INSERT INTO wallpapers SET
            creation_id='$iid',
            owner='$logged_in_id',
            title=?,
            16by9thumb='$newhomethumb16by9',
            16by10thumb='$newhomethumb16by10',
            4by3thumb='$newhomethumb4by3',
            5by4thumb='$newhomethumb5by4',
            mobilethumb='$newhomethumbmobile',
            16by9_share='$newhomeshare16by9',
            16by10_share='$newhomeshare16by10',
            4by3_share='$newhomeshare4by3',
            5by4_share='$newhomeshare5by4',
            mobile_share='$newhomesharemobile',
            3840x2160='$newhome3840x2160',
            2560x1440='$newhome2560x1440',
            1920x1080='$newhome1920x1080',
            1280x720 ='$newhome1280x720',
            2560x1600='$newhome2560x1600',
            1920x1200='$newhome1920x1200',
            1680x1050='$newhome1680x1050',
            1280x800='$newhome1280x800',
            2800x2100='$newhome2800x2100',
            2048x1536='$newhome2048x1536',
            1400x1050='$newhome1400x1050',
            1024x768='$newhome1024x768',
            2560x2048='$newhome2560x2048',
            1280x1024='$newhome1280x1024',
            mobilesmall='$newhomemobilesmall',
            mobilemedium='$newhomemobilemedium',
            mobilestandard='$newhomemobilestandard',
            mobilelarge='$newhomemobilelarge',
            create_time='$current_time',
            image_credit=?,
            downloadkey='$download_key'";

      if ($credit === null or $credit == "") {
        $credit = " ";
      }

      $db->sql($mysqlquery, 'ss', $walltitle, $credit);

      $db->sql("UPDATE users SET tutorial_seen = 1 WHERE id=?", 'i', $logged_in_id);

      $db->sql("UPDATE wall_generation SET complete = 1, reviewed = 1 WHERE id=?", 'i', $iid);

      $res = $db->sql("SELECT * FROM wallpapers WHERE creation_id=? ORDER BY id DESC LIMIT 1", 'i', $iid);
      while ($row = $res->fetch_assoc()) {
        $wallpaper_id = $row['id'];
      }

      //reset categorys
      $db->sql("DELETE FROM category_links WHERE wallpaper_id=?", 'i', $wallpaper_id);

      //insert categorys
      $categories = $_POST['category'];
      foreach ($categories as $category) {

        $db->sql("INSERT INTO category_links SET category_id=?, wallpaper_id=?", 'ii', $category, $wallpaper_id);
      }


      //get tags
      $db->sql("DELETE FROM tag_links WHERE wallpaper_id=?", 'i', $wallpaper_id);

      $tags = $_POST['tags'];
      $tags = htmlspecialchars($tags, ENT_QUOTES);
      $tags = explode(",", $tags);
      foreach ($tags as $tag) {

        if ($tag == "") {
        } else {


          $tag = strtolower($tag);
          $slug = create_slug($tag);

          $tagcount = 0;
          $res = $db->sql("SELECT * FROM tags WHERE tag_name=? ORDER BY id ASC", 's', $tag);
          while ($row = $res->fetch_assoc()) {
            $tagcount = 1;
            $tag_id = $row['id'];
          }

          if ($tagcount == 0) {
            $db->sql("INSERT INTO tags SET tag_name=?, slug=?", 'ss', $tag, $slug);

            $res = $db->sql("SELECT * FROM tags WHERE tag_name=? ORDER BY id ASC", 's', $tag);
            while ($row = $res->fetch_assoc()) {
              $tag_id = $row['id'];
            }
          };

          $db->sql("INSERT INTO tag_links SET tag_id=?, wallpaper_id=?", 'ii', $tag_id, $wallpaper_id);
        }
      }




      //collections
      if (isset($_POST['collection'])) {
        $collections = $_POST['collection'];
        foreach ($collections as $collection) {

          $collectiontitle = htmlspecialchars($collection, ENT_QUOTES);

          $collectionslug = htmlspecialchars($collection, ENT_QUOTES);
          $collectionslug = strtolower($collectionslug);
          $collectionslug = create_slug($collectionslug);

          //does collection already exist
          $collectioncount = 0;
          $res = $db->sql("SELECT * FROM collections WHERE slug=? AND owner_id=? ORDER BY id ASC", 'si', $collectionslug, $logged_in_id);
          while ($row = $res->fetch_assoc()) {
            $collectioncount = 1;
            $collection_id = $row['id'];
          }

          if ($collectioncount == 0) {
            $db->sql("INSERT INTO collections SET owner_id=?, name=?, slug=?, count='1'", 'iss', $logged_in_id, $collectiontitle, $collectionslug);

            $res = $db->sql("SELECT * FROM collections WHERE slug= ? AND owner_id = ? ORDER BY id ASC", 'si', $collectionslug, $logged_in_id);
            while ($row = $res->fetch_assoc()) {
              $collection_id = $row['id'];
            }
          };

          $db->sql("UPDATE collections SET sfw='0' WHERE id = ?", 'i', $collection_id);

          $db->sql("DELETE FROM collection_links WHERE collection_id = ? AND wallpaper_id=?", 'ii', $collection_id, $wallpaper_id);

          $db->sql("INSERT INTO collection_links SET collection_id=?, wallpaper_id=?", 'ii', $collection_id, $wallpaper_id);
        }
      }



      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = $smtp_host;
      $mail->SMTPAuth = true;
      $mail->Username = $smtp_username;
      $mail->Password = $smtp_password;
      $mail->SMTPSecure = $smtp_ssltype;
      $mail->Port = $smtp_port;
      // $mail->SMTPOptions = array(
      //   'ssl' => array(
      //     'verify_peer' => false,
      //     'verify_peer_name' => false,
      //     'allow_self_signed' => true
      //   )
      // );

      $mail->setFrom($smtp_from, $smtp_fromname);
      $mail->addAddress("kookynetwork@protonmail.com", "Wallpaper Cropper");


      $mail->isHTML(true);

      $themessage = '<table width="500" style="display:block; width:500px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
      $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:500px; display:block; margin:0 0 20px 0;" />';
      $themessage = $themessage . '<h1 style="color:#3a7bd5; font-weight:bold; font-size:20pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">NEW WALLPAPER</h1>';
      $themessage = $themessage . '</th></tr></table>';

      $mail->Subject = "NEW WALLPAPER";
      $mail->Body = $themessage;
      $mail->AltBody = 'NEW WALLPAPER';

      if (!$mail->send()) {
      }




      $location = "Location: " . $base_url . "/view-wall/" . $wallpaper_id . "/";
      header($location);
      exit();
    };
  } else {
    $location = "Location: " . $base_url;
    log_malicious();
    header($location);
    exit();
  }
}
