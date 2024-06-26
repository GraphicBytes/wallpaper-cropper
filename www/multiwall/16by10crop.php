<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $iid = $typea;
  $user_width = $_POST["user_width"];

  $res = $db->sql( "SELECT * FROM wall_generation WHERE id=? AND complete = '0' ORDER BY ID DESC LIMIT 1", 'i' , $iid );
  while($row=$res->fetch_assoc()) {
    $id = $row['id'];
    $owner = $row['owner'];
    $imagefile = $row['imagefile'];
    $imgwidth = $row['imgwidth'];
    $imgheight = $row['imgheight'];

    $done_16by9_recrop = $row['16by9_recrop'];
    $done_16by10_recrop = $row['16by10_recrop'];
    $done_4by3_recrop = $row['4by3_recrop'];
    $done_5by4_recrop = $row['5by4_recrop'];
    $done_mobile_recrop = $row['mobile_recrop'];
    $done_reviewed = $row['reviewed'];


    $replace=$base_url . "/";
    $imagefile2 = str_replace($php_base_directory,$replace, $imagefile);
  }
  if ($logged_in_id == $owner) {

    include("functions/resize-class.php");

    $src = $imagefile;
    $extension = strtolower(strrchr($src, '.'));

    $Iwidth = $imgwidth;
    $ratioo = $Iwidth/$user_width;



    //share cdn
    $targ_w = 160;
    $targ_h = 100;

    $checkwidth = $_POST['w']*$ratioo;
    $checkheight = $_POST['h']*$ratioo;

    if ($checkwidth > $targ_w and $checkheight >$targ_h){

        $jpeg_quality = 65;
        if ($extension == '.jpg' or $extension == '.jpeg' ) {$img_r = imagecreatefromjpeg($src);}
        if ($extension == '.png' ) {$img_r = imagecreatefrompng($src);}
        if ($extension == '.gif' ) {$img_r = imagecreatefromgif($src);}

        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

        imagecopyresampled($dst_r,$img_r,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
        $targ_w,$targ_h,$_POST['w']*$ratioo,$_POST['h']*$ratioo);

        $Ifile = random_str(50) . ".jpg";
        $Ifileroot = $php_base_directory . "tempfiles2/" . $Ifile;

        imagejpeg($dst_r, $Ifileroot, $jpeg_quality);

        $db->sql( "UPDATE wall_generation SET 16by10_share=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }



    //Thumbnail
    $targ_w = 320;
    $targ_h = 200;

    $checkwidth = $_POST['w']*$ratioo;
    $checkheight = $_POST['h']*$ratioo;

    if ($checkwidth > $targ_w and $checkheight >$targ_h){

        $jpeg_quality = 80;
        if ($extension == '.jpg' or $extension == '.jpeg' ) {$img_r = imagecreatefromjpeg($src);}
        if ($extension == '.png' ) {$img_r = imagecreatefrompng($src);}
        if ($extension == '.gif' ) {$img_r = imagecreatefromgif($src);}

        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

        imagecopyresampled($dst_r,$img_r,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
        $targ_w,$targ_h,$_POST['w']*$ratioo,$_POST['h']*$ratioo);

        $Ifile = random_str(50) . ".jpg";
        $Ifileroot = $php_base_directory . "tempfiles2/" . $Ifile;

        imagejpeg($dst_r, $Ifileroot, $jpeg_quality);

        $db->sql( "UPDATE wall_generation SET 16by10thumb=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }




    //WXGA
    $targ_w = 1280;
    $targ_h = 800;

    $checkwidth = $_POST['w']*$ratioo;
    $checkheight = $_POST['h']*$ratioo;

    if ($checkwidth > $targ_w and $checkheight >$targ_h){

        $jpeg_quality = 90;
        if ($extension == '.jpg' or $extension == '.jpeg' ) {$img_r = imagecreatefromjpeg($src);}
        if ($extension == '.png' ) {$img_r = imagecreatefrompng($src);}
        if ($extension == '.gif' ) {$img_r = imagecreatefromgif($src);}

        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

        imagecopyresampled($dst_r,$img_r,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
        $targ_w,$targ_h,$_POST['w']*$ratioo,$_POST['h']*$ratioo);

        $Ifile = random_str(50) . ".jpg";
        $Ifileroot = $php_base_directory . "tempfiles2/" . $Ifile;

        imagejpeg($dst_r, $Ifileroot, $jpeg_quality);

        $db->sql( "UPDATE wall_generation SET 1280x800=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }



    //WSXGA+
    $targ_w = 1680;
  	$targ_h = 1050;

  	$checkwidth = $_POST['w']*$ratioo;
  	$checkheight = $_POST['h']*$ratioo;

    if ($checkwidth > $targ_w and $checkheight >$targ_h){

      	$jpeg_quality = 90;
      	if ($extension == '.jpg' or $extension == '.jpeg' ) {$img_r = imagecreatefromjpeg($src);}
        if ($extension == '.png' ) {$img_r = imagecreatefrompng($src);}
        if ($extension == '.gif' ) {$img_r = imagecreatefromgif($src);}

      	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

      	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
      	$targ_w,$targ_h,$_POST['w']*$ratioo,$_POST['h']*$ratioo);

       	$Ifile = random_str(50) . ".jpg";
      	$Ifileroot = $php_base_directory . "tempfiles2/" . $Ifile;

      	imagejpeg($dst_r, $Ifileroot, $jpeg_quality);

        $db->sql( "UPDATE wall_generation SET 1680x1050=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }



    //WUXGA
    $targ_w = 1920;
  	$targ_h = 1200;

  	$checkwidth = $_POST['w']*$ratioo;
  	$checkheight = $_POST['h']*$ratioo;

    if ($checkwidth > $targ_w and $checkheight >$targ_h){

      	$jpeg_quality = 90;
      	if ($extension == '.jpg' or $extension == '.jpeg' ) {$img_r = imagecreatefromjpeg($src);}
        if ($extension == '.png' ) {$img_r = imagecreatefrompng($src);}
        if ($extension == '.gif' ) {$img_r = imagecreatefromgif($src);}

      	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

      	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
      	$targ_w,$targ_h,$_POST['w']*$ratioo,$_POST['h']*$ratioo);

       	$Ifile = random_str(50) . ".jpg";
      	$Ifileroot = $php_base_directory . "tempfiles2/" . $Ifile;

      	imagejpeg($dst_r, $Ifileroot, $jpeg_quality);

        $db->sql( "UPDATE wall_generation SET 1920x1200=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }



    //WQXGA
    $targ_w = 2560;
    $targ_h = 1600;

    $checkwidth = $_POST['w']*$ratioo;
    $checkheight = $_POST['h']*$ratioo;

    if ($checkwidth > $targ_w and $checkheight >$targ_h){

        $jpeg_quality = 90;
        if ($extension == '.jpg' or $extension == '.jpeg' ) {$img_r = imagecreatefromjpeg($src);}
        if ($extension == '.png' ) {$img_r = imagecreatefrompng($src);}
        if ($extension == '.gif' ) {$img_r = imagecreatefromgif($src);}

        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

        imagecopyresampled($dst_r,$img_r,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
        $targ_w,$targ_h,$_POST['w']*$ratioo,$_POST['h']*$ratioo);

        $Ifile = random_str(50) . ".jpg";
        $Ifileroot = $php_base_directory . "tempfiles2/" . $Ifile;

        imagejpeg($dst_r, $Ifileroot, $jpeg_quality);

        $db->sql( "UPDATE wall_generation SET 2560x1600=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }



    $current_time = time();
    $db->sql( "UPDATE wall_generation SET create_time=? WHERE id=?", 'si' , $current_time, $iid );

    $current_time = time();
    $db->sql( "UPDATE wall_generation SET 16by10_recrop='1' WHERE id=?", 'i' , $iid );

    $done_16by10_recrop = 1;

    $location = "Location: " . $base_url . "/4by3select/" . $iid . "/";

         if($done_16by9_recrop == 0){$location = "Location: " . $base_url . "/16by9select/" . $iid . "/";}
    else if($done_16by10_recrop == 0){$location = "Location: " . $base_url . "/16by10select/" . $iid . "/";}
    else if($done_4by3_recrop == 0){$location = "Location: " . $base_url . "/4by3select/" . $iid . "/";}
    else if($done_5by4_recrop == 0){$location = "Location: " . $base_url . "/5by4select/" . $iid . "/";}
    else if($done_mobile_recrop == 0){$location = "Location: " . $base_url . "/mobileselect/" . $iid . "/";}
    else if($done_reviewed == 0){$location = "Location: " . $base_url . "/review/" . $iid . "/";}

    header($location);
    exit();



  } else {
    $location = "Location: " . $base_url;
    log_malicious();
    header($location);
    exit();
  }

}?>
