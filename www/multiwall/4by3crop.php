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
    $targ_h = 120;

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

        $db->sql( "UPDATE wall_generation SET 4by3_share=? WHERE id=?", 'si' , $Ifileroot, $iid );
    }




    //Thumbnail
    $targ_w = 320;
    $targ_h = 240;

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

        $db->sql( "UPDATE wall_generation SET 4by3thumb=? WHERE id=?", 'si' , $Ifileroot, $iid );
    }



    //XGA
    $targ_w = 1024;
    $targ_h = 768;

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

        $db->sql( "UPDATE wall_generation SET 1024x768=? WHERE id=?", 'si' , $Ifileroot, $iid );
    }



    //SXGA+
    $targ_w = 1400;
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

        $db->sql( "UPDATE wall_generation SET 1400x1050=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }



    //Quad XGA
    $targ_w = 2048;
  	$targ_h = 1536;

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

        $db->sql( "UPDATE wall_generation SET 2048x1536=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }



    //Quad SXGA+
    $targ_w = 2800;
    $targ_h = 2100;

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

        $db->sql( "UPDATE wall_generation SET 2800x2100=? WHERE id=?", 'si' , $Ifileroot, $iid );

    }


    $current_time = time();
    $db->sql( "UPDATE wall_generation SET create_time=? WHERE id=?", 'si' , $current_time, $iid );

    $current_time = time();
    $db->sql( "UPDATE wall_generation SET 4by3_recrop='1' WHERE id=?", 'i' , $iid );

    $done_4by3_recrop =1;

    $location = "Location: " . $base_url . "/5by4select/" . $iid . "/";

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
