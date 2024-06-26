<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  if ($logged_in_id == 1) {$maxsize=1000242880;}else{$maxsize=10242880;}
  if ($logged_in_id == 1) {$maxsize2=1000000;}else{$maxsize2=10000;}


  $phototmp_name = $_FILES['files']['tmp_name'];
  $draggedfiles = $_FILES['draggedfiles']['tmp_name'];


  // IF NO URL OR IMAGE UPLOAD - BOUNCE BACK
  if (empty($phototmp_name) && empty($draggedfiles)) {
    $location = "Location: " . $base_url . "/overview/";
    header($location);
    exit();
  }



  if ( isset($phototmp_name) or isset($draggedfiles)  ) {

          $uniqid = random_str(10);

          if($_FILES['files']['size'] / 1024>$maxsize2 or $_FILES['draggedfiles']['size'] / 1024>$maxsize2){
            $location = "Location: " . $base_url . "/overview/";
            header($location);
            exit();
          } else {

                    //its a standard upload
                    if ($phototmp_name == "") {} else {

                          $imagetypes = array(
                              'image/png' => '.png',
                              'image/gif' => '.gif',
                              'image/jpeg' => '.jpg',
                              'image/bmp' => '.bmp');
                          $ext = $imagetypes[$_FILES['files']['type']];

                          $target = "tempfiles/";
                          $target = $target . $uniqid . basename( $_FILES['files']['tmp_name'].$ext) ;
                          move_uploaded_file($_FILES['files']['tmp_name'], $target);

                          echo $target;

                    }

                    //its a drag an drop upload
                    if ($draggedfiles == "") {} else {

                        $imagetypes = array(
                            'image/png' => '.png',
                            'image/gif' => '.gif',
                            'image/jpeg' => '.jpg',
                            'image/bmp' => '.bmp');
                        $ext = $imagetypes[$_FILES['draggedfiles']['type']];

                        $target = "tempfiles/";
                        $target = $target . $uniqid . basename( $_FILES['draggedfiles']['tmp_name'].$ext) ;
                        move_uploaded_file($_FILES['draggedfiles']['tmp_name'], $target);

                    }

                    $ok=1;

                    $info = getimagesize($target);
                    if ($info === FALSE) {
                    	unlink($target);
                      $location = "Location: " . $base_url . "/overview/";
                      header($location);
                      exit();
                    } else {


                    list($imgwidth, $imgheight) = getimagesize($target);


                    $imagefile = "" . $target;

                    $imagefile = $php_base_directory . $imagefile;

                    $current_time = time();

                    $db->sql( "INSERT INTO newprofilephotos SET user_id=?, file=?, imgwidth=?, imgheight=?, uploadtime=?", 'isiii' , $logged_in_id, $imagefile, $imgwidth, $imgheight, $current_time );

  								  $res=$db->sql( "SELECT id FROM newprofilephotos WHERE file=? ORDER BY id DESC LIMIT 1", 's' , $imagefile );
  								  while($row=$res->fetch_assoc()) {$idd = $row['id'];}


                    echo $location = "Location: " . $base_url . "/crop-profile/" . $idd . "/";
                    header($location);
                    exit();

                  }



          }


  }




 }?>
