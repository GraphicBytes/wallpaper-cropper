<?php
$cookie_id = random_str(100);
$time = time();
$mysqlquery="UPDATE users SET cookie_id='$cookie_id', cookie_age='$time' WHERE id='$logged_in_id'";
$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

unset($_COOKIE['wallpapercropper_id']);
unset($_COOKIE['wallpapercropper_email']);
unset($_COOKIE['wallpapercropper_session_id']);
setcookie('wallpapercropper_id', null, -1, '/');
setcookie('wallpapercropper_email', null, -1, '/');
setcookie('wallpapercropper_session_id', null, -1, '/');

$location = "Location: " . $base_url;
header($location);
exit();

?>
