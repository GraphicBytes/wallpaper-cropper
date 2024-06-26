<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $iid = $typea;
  $user_width = $_POST["user_width"];

  $res=$db->sql( "SELECT * FROM newprofilephotos WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $iid );
  while($row=$res->fetch_assoc()) {
    $id = $row['id'];
    $owner = $row['user_id'];
    $imagefile = $row['file'];
    $imgwidth = $row['imgwidth'];
    $imgheight = $row['imgheight'];

    $replace=$base_url . "/";
    $imagefile2 = str_replace($php_base_directory,$replace, $imagefile);
  }
  if ($logged_in_id == $owner) {

    include("functions/resize-class.php");

    $src = $imagefile;

    $extension = strtolower(strrchr($src, '.'));


    $Iwidth = $imgwidth;
    $ratioo = $Iwidth/$user_width;


    $permanant_home=$php_base_directory."avatars/". $logged_in_id. "/";

    //Create Directory
    if (!file_exists($permanant_home)) {
        mkdir($permanant_home, 0777, true);
    }


    //Thumbnail
    $targ_w = 336;
    $targ_h = 336;

    $targ_w_mini = 50;
    $targ_h_mini = 50;

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

        $random=random_str(10);

        $Ifile = $random . "_avatar.jpg";
        $Ifileroot = $permanant_home . $Ifile;

        $bdfile = $logged_in_id. "/" . $Ifile;

        imagejpeg($dst_r, $Ifileroot, $jpeg_quality);






        if ($extension == '.jpg' or $extension == '.jpeg' ) {$img_r_mini = imagecreatefromjpeg($src);}
        if ($extension == '.png' ) {$img_r_mini = imagecreatefrompng($src);}
        if ($extension == '.gif' ) {$img_r_mini = imagecreatefromgif($src);}

        $dst_r_mini = ImageCreateTrueColor( $targ_w_mini, $targ_h_mini );

        imagecopyresampled($dst_r_mini,$img_r_mini,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
        $targ_w_mini,$targ_h_mini,$_POST['w']*$ratioo,$_POST['h']*$ratioo);

        $random=random_str(10);

        $Ifile_mini = $random . "_avatar_mini.jpg";
        $Ifileroot_mini = $permanant_home . $Ifile_mini;

        $bdfile_mini = $logged_in_id. "/" . $Ifile_mini;

        imagejpeg($dst_r_mini, $Ifileroot_mini, $jpeg_quality);





        $resz=$db->sql( "SELECT * FROM users WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $logged_in_id );
        while($rowz=$resz->fetch_assoc()) {
          $getrid = $rowz['avatar'];
          $getrid_mini = $rowz['avatar_mini'];

          $getridfull = $php_base_directory . "avatars/" . $getrid;
          $getridminifull = $php_base_directory . "avatars/" . $getrid_mini;

          if ($getrid == "default.jpg"){}else{
            unlink($getridfull);
          }
          if ($getrid_mini == "default_mini.jpg"){}else{
            unlink($getridminifull);
          }
        }



        $db->sql( "UPDATE users SET avatar=?, avatar_mini=? WHERE id=?", 'ssi' , $bdfile, $bdfile_mini, $logged_in_id );

        $db->sql( "UPDATE newprofilephotos SET file=null, complete=1 WHERE id=?", 'i' , $iid );

    }



    $location = "Location: " . $base_url . "/overview/";
    header($location);
    exit();



  } else {
    $location = "Location: " . $base_url;
    log_malicious();
    header($location);
    exit();
  }

}?>
