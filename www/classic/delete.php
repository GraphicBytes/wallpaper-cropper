<?php
session_start();
$session_id = session_id();

$iid = $typea;


$mysqlquery="SELECT * FROM classic WHERE ID='$iid' ORDER BY ID DESC LIMIT 1";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {
	$usersession_id = $row['session_id'];
	$imagefile = $row['imagefile'];
	$thumb = $row['thumb'];
	$wall = $row['wall'];
  $delete_status = $row['delete_status'];
	}


  $sessioncheck = 0;
  if ($usersession_id == $session_id){$sessioncheck = 1;}

  if ($delete_status == 1 or $sessioncheck == 0){
  log_malicious();
    $location = "Location: " . $base_url;
    header($location);
    exit();
  } else {

    $mysqlquery="UPDATE classic SET delete_status = 1 WHERE ID='$iid'";
    $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    unlink($imagefile);
    unlink($thumb);
    unlink($wall);

    $location = "Location: " . $base_url . "/start/deleted/";
    header($location);
    exit();

  }

?>
