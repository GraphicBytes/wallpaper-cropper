<?php
if ($is_malicious == 0) {



  if ($logged_in_id == 0) {
    $location = "Location: " . $base_url;
    log_malicious();
    header($location);
    exit();
  } else {

    if ($logged_in_id == 1) {
      $maxsize = 1000242880;
    } else {
      $maxsize = 50242880;
    }
    if ($logged_in_id == 1) {
      $maxsize2 = 1000000;
    } else {
      $maxsize2 = 50000;
    }

    // GET FIELDS
    $directimageurl = $_POST["file_url"];
    if ((substr($directimageurl, 0, 7) == "http://") or substr($directimageurl, 0, 8) == "https://") {
    } else {
      $directimageurl = "http://" . $directimageurl;
    }

    $phototmp_name = $_FILES['files']['tmp_name'];
    $draggedfiles = $_FILES['draggedfiles']['tmp_name'];


    // IF NO URL OR IMAGE UPLOAD - BOUNCE BACK
    if (empty($directimageurl) && empty($phototmp_name) && empty($draggedfiles)) {
      $location = "Location: " . $base_url . "/createwall/nothingset/";
      log_malicious();
      header($location);
      exit();
    }



    // IF USER WANTS US TO FETCH IMAGE FROM URL
    else if (isset($directimageurl) && empty($phototmp_name) && empty($draggedfiles)) {



      // Check File Size of remote image
      if (strlen(file_get_contents($directimageurl)) < $maxsize) {

        $save_to = $php_base_directory . "tempfiles2/";

        $stack[] = $directimageurl;
        $urls = $stack;

        $uniqid = random_str(10);

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
            $location = "Location: " . $base_url . "/createwall/invalidfetch/";
            log_malicious();
            header($location);
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
          $location = "Location: " . $base_url . "/createwall/invalidfetch/";
          log_malicious();
          header($location);
          exit();
        } else {


          list($imgwidth, $imgheight) = getimagesize($target);



          $current_time = time();
          $db->sql("INSERT INTO wall_generation SET owner=?, imagefile=?, imgwidth=?, imgheight=?, create_time=?", 'issss', $logged_in_id, $imagefile, $imgwidth, $imgheight, $current_time);

          $res = $db->sql("SELECT ID FROM wall_generation WHERE imagefile=? ORDER BY ID DESC LIMIT 1", 's', $imagefile);
          while ($row = $res->fetch_assoc()) {
            $idd = $row['ID'];
          }

          $location = "Location: " . $base_url . "/16by9select/" . $idd . "/";
          header($location);
          exit();
        }
      } else {
        $location = "Location: " . $base_url . "/createwall/filetoobig/";
        log_malicious();
        header($location);
        exit();
      }
    } else if (empty($directimageurlcheck) && (isset($phototmp_name) or isset($draggedfiles))) {

      $uniqid = random_str(10);

      if ($_FILES['files']['size'] / 1024 > 15360 or $_FILES['draggedfiles']['size'] / 1024 > 15360) {
        $location = "Location: " . $base_url . "/createwall/filetoobig/";
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

          $target = "tempfiles2/";
          $target = $target . $uniqid . basename($_FILES['files']['tmp_name'] . $ext);
          move_uploaded_file($_FILES['files']['tmp_name'], $target);

          echo $target;
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

          $target = "tempfiles2/";
          $target = $target . $uniqid . basename($_FILES['draggedfiles']['tmp_name'] . $ext);
          move_uploaded_file($_FILES['draggedfiles']['tmp_name'], $target);
        }

        $ok = 1;

        $info = getimagesize($target);
        if ($info === FALSE) {
          unlink($target);
          $location = "Location: " . $base_url . "/createwall/invalidimagetype/";
          log_malicious();
          header($location);
          exit();
        } else {


          list($imgwidth, $imgheight) = getimagesize($target);


          $imagefile = "" . $target;

          $imagefile = $php_base_directory . $imagefile;

          $res = $db->sql("INSERT INTO wall_generation SET owner= ? , imagefile= ? , imgwidth= ? , imgheight= ? ", 'isii', $logged_in_id, $imagefile, $imgwidth, $imgheight);

          $res = $db->sql("SELECT ID FROM wall_generation WHERE imagefile=? ORDER BY ID DESC LIMIT 1", 's', $imagefile);
          while ($row = $res->fetch_assoc()) {
            $idd = $row['ID'];
          }

          $db->sql("DELETE FROM malicious_ips WHERE ip_address=?", 's', $user_ip);
          $db->sql("DELETE FROM malicious_useragents WHERE agent_ip=?", 's', $user_ip);

          $location = "Location: " . $base_url . "/16by9select/" . $idd . "/";
          header($location);
          exit();
        }
      }
    }
  }
} else {
  log_malicious();
  $location = "Location: " . $base_url;
  header($location);
  exit();
}
