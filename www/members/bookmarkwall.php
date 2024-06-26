<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $linkexists = 0;

  $mysqlquery="SELECT * FROM bookmarked_walls WHERE user_id='$logged_in_id' AND wallpaper_id='$typea' ORDER BY id DESC LIMIT 1";
  $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while($row=$res->fetch_assoc()) {
  $linkexists = 1;
  }


  if($typeb == 0){
    $mysqlquery="DELETE FROM bookmarked_walls WHERE user_id='$logged_in_id' AND wallpaper_id='$typea'";
    $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    echo "LIKE THIS WALLPAPER";
  }
  else if($typeb == 1){

    if($linkexists == 0){
      $bookmark_time=time();
      $mysqlquery="INSERT INTO bookmarked_walls SET user_id='$logged_in_id', wallpaper_id='$typea', bookmark_time='$bookmark_time'";
      $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
      echo "YOU LIKE THIS WALLPAPER";
    }

  }


}?>
