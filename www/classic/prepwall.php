<?php
session_start();
$session_id = session_id();

$iid = $typea;
$userw = $_POST["width"];
$userh = $_POST["height"];
$time = time();

$mysqlquery="SELECT * FROM classic WHERE ID='$iid' ORDER BY ID DESC LIMIT 1";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {

	$usersession_id = $row['session_id'];
	$delete_status = $row['delete_status'];

	}

  $sessioncheck = 0;
  if ($usersession_id == $session_id){$sessioncheck = 1;}

  if ($delete_status == 1 or $sessioncheck == 0){
    $location = "Location: " . $base_url;
  log_malicious();
    header($location);
    exit();
  } else {





        $mysqlquery="UPDATE classic SET userw='$userw', userh='$userh', time='$time' WHERE ID='$iid'";
        $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

        echo $location = "Location: " . $base_url . "/stage3/" . $iid . "/";
        header($location);
        exit();





}
?>
