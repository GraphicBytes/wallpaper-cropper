<?php
$config =array(
"base_url" => "https://wallpapercropper.com/functions/hybridauth/index.php",
"providers" => array (
"Facebook" => array (
"enabled" => true,
"keys" => array ( "id" => "###############", "secret" => "###############" ),
),
"Twitter" => array (
"enabled" => true,
"keys" => array ( "key" => "###############", "secret" => "###############" )
),
),
"debug_mode" => false,
"debug_file" => "/var/www/wallpapercropper.com/config/debug.log",
);
