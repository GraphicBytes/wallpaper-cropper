<?php
if ($is_malicious == 0) {

  session_start();
  $session_id = session_id();

  include("functions/resize-class.php");

  // GET FIELDS
  $directimageurl = $_POST["file_url"];
  if ($directimageurl !== null && $directimageurl != "") {
    if ((substr($directimageurl, 0, 7) == "http://") or substr($directimageurl, 0, 8) == "https://") {
    } else {
      $directimageurl = "http://" . $directimageurl;
    }
  }


  $phototmp_name = $_FILES['files']['tmp_name'];
  $draggedfiles = $_FILES['draggedfiles']['tmp_name'];




  // IF NO URL OR IMAGE UPLOAD - BOUNCE BACK
  if (empty($directimageurl) && empty($phototmp_name) && empty($draggedfiles)) {
    log_malicious();
    $location = "Location: " . $base_url . "/start/nothingset/";
    header($location);
    exit();
  } // IF USER WANTS US TO FETCH IMAGE FROM URL
  else if (isset($directimageurl) && empty($phototmp_name) && empty($draggedfiles)) {

    // Check File Size of remote image
    if (strlen(file_get_contents($directimageurl)) < 10242880) {

      $save_to = $php_base_directory . "tempfiles/";

      $stack[] = $directimageurl;
      $urls = $stack;

      $uniqid = uniqid();

      $mh = curl_multi_init();
      foreach ($urls as $i => $url) {

        $basename = basename($url);

        if (str_contains($basename, '.jpeg') || str_contains($basename, '.jpg')) {
          $baseExt = ".jpg";
        } else if (str_contains($basename, '.png')) {
          $baseExt = ".png";
        } else if (str_contains($basename, '.webp')) {
          $baseExt = ".webp";
        } else if (str_contains($basename, '.bmp')) {
          $baseExt = ".bmp";
        } else if (str_contains($basename, '.tif') || str_contains($basename, '.tiff')) {
          $baseExt = ".tiff";
        } else if (str_contains($basename, '.gif')) {
          $baseExt = ".gif";
        } else {
          $location = "Location: " . $base_url . "/start/invalidfetch/";
          log_malicious();
          header($location);
          die();
        }



        $g = $save_to . $uniqid . $baseExt;
        $imagefile = $save_to . $uniqid . $baseExt;
        if (!is_file($g)) {
          $conn[$i] = curl_init($url);
          $fp[$i] = fopen($g, "w");
          curl_setopt($conn[$i], CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($conn[$i], CURLOPT_SSL_VERIFYHOST, 2);
          curl_setopt($conn[$i], CURLOPT_FILE, $fp[$i]);
          curl_setopt($conn[$i], CURLOPT_FOLLOWLOCATION, true);
          curl_setopt($conn[$i], CURLOPT_MAXREDIRS, 5);
          curl_setopt($conn[$i], CURLOPT_HTTPGET, false);
          curl_setopt($conn[$i], CURLOPT_HEADER, 0);
          curl_setopt($conn[$i], CURLOPT_REFERER, 'https://wallpapercropper.com/');
          curl_setopt($conn[$i], CURLOPT_CONNECTTIMEOUT, 60);
          curl_multi_add_handle($mh, $conn[$i]);
        }
      }
      do {
        $n = curl_multi_exec($mh, $active);
      } while ($active);
      foreach ($urls as $i => $url) {
        curl_multi_remove_handle($mh, $conn[$i]);
        curl_close($conn[$i]);
        fclose($fp[$i]);
      }
      curl_multi_close($mh);

      $target = $imagefile;

      $info = getimagesize($target);

      if ($info === FALSE) {
        //unlink($target);
        $location = "Location: " . $base_url . "/start/invalidfetch/";
        log_malicious();
        header($location);
        exit();
      } else {


        list($imgwidth, $imgheight) = getimagesize($target);

        $thumb = $imagefile;
        $thumb = str_replace(".jpg", '_thumb.jpg', $thumb);
        $thumb = str_replace(".jpeg", '_thumb.jpeg', $thumb);
        $thumb = str_replace(".png", '_thumb.png', $thumb);
        $thumb = str_replace(".gif", '_thumb.gif', $thumb);

        $time = time();


        $resizeObj = new resize($imagefile);
        $resizeObj->resizeImage(200, 360, 'auto');
        $resizeObj->saveImage($thumb, 70);

        list($thumbw, $thumbh) = getimagesize($thumb);



        $mysqlquery = "INSERT INTO classic SET imagefile='$imagefile', session_id='$session_id', imgwidth='$imgwidth', imgheight='$imgheight', thumb='$thumb', thumbw='$thumbw', thumbh='$thumbh', time='$time'";
        $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

        $mysqlquery = "SELECT ID FROM classic WHERE imagefile='$imagefile' ORDER BY ID DESC LIMIT 1";
        $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
        while ($row = $res->fetch_assoc()) {
          $idd = $row['ID'];
        }

        $location = "Location: " . $base_url . "/stage2/" . $idd . "/";
        header($location);
        exit();
      }
    } else {
      $location = "Location: " . $base_url . "/start/filetoobig/";
      log_malicious();
      header($location);
      exit();
    }
  } else if (empty($directimageurlcheck) && (isset($phototmp_name) or isset($draggedfiles))) {


    if ($_FILES['files']['size'] / 1024 > 15360 or $_FILES['draggedfiles']['size'] / 1024 > 15360) {
      $location = "Location: " . $base_url . "/start/filetoobig/";
      log_malicious();
      header($location);
      exit();
    } else {

      //its a standard upload
      if ($phototmp_name == "") {
      } else {

        $imagetypes = array(
          'image/png' => '.png',
          'image/gif' => '.gif',
          'image/jpeg' => '.jpg',
          'image/bmp' => '.bmp'
        );
        $ext = $imagetypes[$_FILES['files']['type']];

        $target = "tempfiles/";
        $target = $target . basename($_FILES['files']['tmp_name'] . $ext);
        move_uploaded_file($_FILES['files']['tmp_name'], $target);
      }

      //its a drag an drop upload
      if ($draggedfiles == "") {
      } else {

        $imagetypes = array(
          'image/png' => '.png',
          'image/gif' => '.gif',
          'image/jpeg' => '.jpg',
          'image/bmp' => '.bmp'
        );
        $ext = $imagetypes[$_FILES['draggedfiles']['type']];

        $target = "tempfiles/";
        $target = $target . basename($_FILES['draggedfiles']['tmp_name'] . $ext);
        move_uploaded_file($_FILES['draggedfiles']['tmp_name'], $target);
      }

      $ok = 1;

      $info = getimagesize($target);
      if ($info === FALSE) {
        unlink($target);
        $location = "Location: " . $base_url . "/start/invalidimagetype/";
        log_malicious();
        header($location);
        exit();
      } else {


        list($imgwidth, $imgheight) = getimagesize($target);

        $imagefile = "" . $target;
        $thumb = $imagefile;
        $thumb = str_replace(".jpg", '_thumb.jpg', $thumb);
        $thumb = str_replace(".jpeg", '_thumb.jpeg', $thumb);
        $thumb = str_replace(".png", '_thumb.png', $thumb);
        $thumb = str_replace(".gif", '_thumb.gif', $thumb);

        $resizeObj = new resize($imagefile);
        $resizeObj->resizeImage(200, 160, 'auto');
        $resizeObj->saveImage($thumb, 70);

        list($thumbw, $thumbh) = getimagesize($thumb);

        $time = time();

        $imagefile = $php_base_directory . $imagefile;
        $thumb = $php_base_directory . $thumb;

        $mysqlquery = "INSERT INTO classic SET imagefile='$imagefile', imagetype='$ext', session_id='$session_id', imgwidth='$imgwidth', imgheight='$imgheight', thumb='$thumb', thumbw='$thumbw', thumbh='$thumbh', time='$time'";
        $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

        $mysqlquery = "SELECT ID FROM classic WHERE imagefile='$imagefile' ORDER BY ID DESC LIMIT 1";
        $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
        while ($row = $res->fetch_assoc()) {
          $idd = $row['ID'];
        }

        $db->sql("DELETE FROM malicious_ips WHERE ip_address=?", 's', $user_ip);
        $db->sql("DELETE FROM malicious_useragents WHERE agent_ip=?", 's', $user_ip);

        $location = "Location: " . $base_url . "/stage2/" . $idd . "/";
        header($location);
        exit();
      }
    }
  }
} else {
  log_malicious();
  $location = "Location: " . $base_url;
  header($location);
  exit();
}
