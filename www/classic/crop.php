<?php
session_start();
$session_id = session_id();

$iid = $typea;
$userw = $_POST["width"];
$userh = $_POST["height"];
$user_width = $_POST["user_width"];
$time = time();

$mysqlquery="SELECT * FROM classic WHERE ID='$iid' ORDER BY ID DESC LIMIT 1";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {

  $usersession_id = $row['session_id'];
  $imagefile = $row['imagefile'];
  $imagetype = $row['imagetype'];
  $imgwidth = $row['imgwidth'];
  $userw = $row['userw'];
  $userh = $row['userh'];
  $delete_status = $row['delete_status'];
  $wall = $row['wall'];

	}

  $sessioncheck = 0;
  if ($usersession_id == $session_id){$sessioncheck = 1;}

  if ($delete_status == 1 or $sessioncheck == 0){
	log_malicious();
    $location = "Location: " . $base_url;
    header($location);
    exit();
  } else {




            $src = $imagefile;
            $extension = strtolower(strrchr($src, '.'));

            	$Iwidth = $imgwidth;
            	$ratioo = $Iwidth/$user_width;


            	$targ_w = $userw;
            	$targ_h = $userh;




            	if ($imagetype == ".jpg" or $imagetype == ".jpeg"){
            		$jpeg_quality = 90;
            		$img_r = imagecreatefromjpeg($src);
            		}

            	else if ($imagetype == ".png"){
            		$jpeg_quality = 90;
            		$img_r = imagecreatefrompng($src);
            		}

            	else if ($imagetype == ".gif"){
            		$jpeg_quality = 90;
            		$img_r = imagecreatefromgif($src);
            		}

            	else {
            		$jpeg_quality = 90;
            		$img_r = imagecreatefromjpeg($src);
            		}



            	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

            	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x']*$ratioo,$_POST['y']*$ratioo,
            	$targ_w,$targ_h,$_POST['w']*$ratioo,$_POST['h']*$ratioo);


            	$Ifile = $userw . "x" . $userh . "-" .uniqid() . ".jpg";
            	$Ifile = "tempfiles/" . $Ifile;
            	$IfileURL = $base_url . "/tempfiles/" . $Ifile;

            	imagejpeg($dst_r, $Ifile, $jpeg_quality);


            $time = time();
            $mysqlquery="UPDATE classic SET wall='$Ifile', wallw='$userw', wallh='$userh', time='$time' WHERE ID='$iid'";
            $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

            echo $location = "Location: " . $base_url . "/complete/" . $iid . "/";
            header($location);
            exit();


}
?>
