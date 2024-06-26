<?php

$last_bg_rotate = $system_data['last_bg_rotate'];

if ((($request_time - 600) > $last_bg_rotate)) {

  $mysqlquery = "UPDATE system SET value='$request_time' WHERE name='last_bg_rotate'";
  $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

  $rotated_done = 0;
  $mysqlquery = "SELECT * FROM wallpapers WHERE highlight='1' AND highlighted='0' ORDER BY id ASC LIMIT 1";
  $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $current_bg = $row['1920x1080'];
    $mobile_bg = $row['mobilemedium'];

    $mysqlquery2 = "UPDATE wallpapers SET highlighted = highlighted + 1 WHERE id ='$id'";
    $dbconn->query($mysqlquery2) or die(mysqli_error($dbconn));

    $mysqlquery2 = "UPDATE bg SET current_bg = '$current_bg', mobile_bg = '$mobile_bg' WHERE id ='1'";
    $dbconn->query($mysqlquery2) or die(mysqli_error($dbconn));

    $rotated_done = 1;
  }

  if ($rotated_done == 0) {
    $mysqlquery2 = "UPDATE wallpapers SET highlighted = 0";
    $dbconn->query($mysqlquery2) or die(mysqli_error($dbconn));
  }


  echo "BG ROTATED";
  echo "<br />";
}
