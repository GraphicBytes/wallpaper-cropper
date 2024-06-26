<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('../config/db.php');
include('../functions/login-check.php');
include('../functions/lastactive.php');
include('../config/globals.php');
include('../functions/random_str.php');
include("../functions/resize-class.php");

$logged_in_id = login_check($base_url,$dbhost,$dbuser,$dbpw,$dbname);


      $mysqlquery="SELECT * FROM wallpapers ORDER BY id DESC";
      $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
      while($row=$res->fetch_assoc()) {

            $w_id=$row['id'];

            $_16by9thumb =str_replace("/var/websites","/var/www/html",$row['16by9thumb']);
            $_16by10thumb =str_replace("/var/websites","/var/www/html",$row['16by10thumb']);
            $_4by3thumb =str_replace("/var/websites","/var/www/html",$row['4by3thumb']);
            $_5by4thumb =str_replace("/var/websites","/var/www/html",$row['5by4thumb']);
            $_mobilethumb =str_replace("/var/websites","/var/www/html",$row['mobilethumb']);
            $_16by9_share =str_replace("/var/websites","/var/www/html",$row['16by9_share']);
            $_16by10_share =str_replace("/var/websites","/var/www/html",$row['16by10_share']);
            $_4by3_share =str_replace("/var/websites","/var/www/html",$row['4by3_share']);
            $_5by4_share =str_replace("/var/websites","/var/www/html",$row['5by4_share']);
            $_mobile_share =str_replace("/var/websites","/var/www/html",$row['mobile_share']);
            $_3840x2160 =str_replace("/var/websites","/var/www/html",$row['3840x2160']);
            $_2560x1440 =str_replace("/var/websites","/var/www/html",$row['2560x1440']);
            $_1920x1080 =str_replace("/var/websites","/var/www/html",$row['1920x1080']);
            $_1280x720 =str_replace("/var/websites","/var/www/html",$row['1280x720']);
            $_2560x1600 =str_replace("/var/websites","/var/www/html",$row['2560x1600']);
            $_1920x1200 =str_replace("/var/websites","/var/www/html",$row['1920x1200']);
            $_1680x1050 =str_replace("/var/websites","/var/www/html",$row['1680x1050']);
            $_1280x800 =str_replace("/var/websites","/var/www/html",$row['1280x800']);
            $_2800x2100 =str_replace("/var/websites","/var/www/html",$row['2800x2100']);
            $_2048x1536 =str_replace("/var/websites","/var/www/html",$row['2048x1536']);
            $_1400x1050 =str_replace("/var/websites","/var/www/html",$row['1400x1050']);
            $_1024x768 =str_replace("/var/websites","/var/www/html",$row['1024x768']);
            $_2560x2048 =str_replace("/var/websites","/var/www/html",$row['2560x2048']);
            $_1280x1024 =str_replace("/var/websites","/var/www/html",$row['1280x1024']);
            $_mobilesmall =str_replace("/var/websites","/var/www/html",$row['mobilesmall']);
            $_mobilemedium =str_replace("/var/websites","/var/www/html",$row['mobilemedium']);
            $_mobilestandard =str_replace("/var/websites","/var/www/html",$row['mobilestandard']);
            $_mobilelarge =str_replace("/var/websites","/var/www/html",$row['mobilelarge']);

            $mysqlqueryb="UPDATE wallpapers SET
            16by9thumb = '$_16by9thumb',
            16by10thumb = '$_16by10thumb',
            4by3thumb = '$_4by3thumb',
            5by4thumb = '$_5by4thumb',
            mobilethumb = '$_mobilethumb',
            16by9_share = '$_16by9_share',
            16by10_share = '$_16by10_share',
            4by3_share = '$_4by3_share',
            5by4_share = '$_5by4_share',
            mobile_share = '$_mobile_share',
            3840x2160 = '$_3840x2160',
            2560x1440 = '$_2560x1440',
            1920x1080 = '$_1920x1080',
            1280x720 = '$_1280x720',
            2560x1600 = '$_2560x1600',
            1920x1200 = '$_1920x1200',
            1680x1050 = '$_1680x1050',
            1280x800 = '$_1280x800',
            2800x2100 = '$_2800x2100',
            2048x1536 = '$_2048x1536',
            1400x1050 = '$_1400x1050',
            1024x768 = '$_1024x768',
            2560x2048 = '$_2560x2048',
            1280x1024 = '$_1280x1024',
            mobilesmall = '$_mobilesmall',
            mobilemedium = '$_mobilemedium',
            mobilestandard = '$_mobilestandard',
            mobilelarge = '$_mobilelarge'
            WHERE id='$w_id'";
            $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

      }



?>
