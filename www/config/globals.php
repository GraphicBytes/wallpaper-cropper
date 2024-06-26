<?php

$server_name = $_SERVER['SERVER_NAME'];
$websitesalt = "################";
$php_base_directory = "/var/www/html/";
$request_time = time();

if ($server_name == "192.168.1.66") {
    $env=0;
    $base_url = "http://192.168.1.66:1098";
    $static_url = "http://192.168.1.66:1098";
    $thumb_url = "http://192.168.1.66:1098";
    $wall_url = "http://192.168.1.66:1098";
    $cdn_url = "http://192.168.1.66:1098";
} else if ($server_name == "116.203.178.189") {
    $env = 0;
    $base_url = "http://116.203.178.189:1098";
    $static_url = "http://116.203.178.189:1098";
    $thumb_url = "http://116.203.178.189:1098";
    $wall_url = "http://116.203.178.189:1098";
    $cdn_url = "http://116.203.178.189:1098";
} else if ($server_name == "37.27.40.90:1044") {
    $env = 0;
    $base_url = "https://37.27.40.90:1044";
    $static_url = "https://37.27.40.90:1044";
    $thumb_url = "https://37.27.40.90:1044";
    $wall_url = "https://37.27.40.90:1044";
    $cdn_url = "https://37.27.40.90:1044";
} else {
    $env = 1;
    $base_url = "https://wallpapercropper.com";
    $static_url = "https://wallpapercropper.com";
    $thumb_url = "https://wallpapercropper.com";
    $wall_url = "https://wallpapercropper.com";
    $cdn_url = "https://wallpapercropper.com";
}


if ($env == 0) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}



//######################################
//############### SYSYEM ###############
//######################################
$server_name = $_SERVER['SERVER_NAME'];
if (isset($_SERVER['HTTP_X_REAL_IP'])) {
    $user_ip = $_SERVER['HTTP_X_REAL_IP'];
} else {
    $user_ip = $_SERVER['REMOTE_ADDR'];
}
$user_agent = "";
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
}
