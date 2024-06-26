<?php
function bgfetch(){

  global $dbconn;
  global $mobile;


  if ($dbconn->connect_error) {die("Database Connection failed: ");}

  include('config/globals.php');

  $mysqlquery="SELECT * FROM bg WHERE id='1' ORDER BY id DESC LIMIT 1";
  $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while($row=$res->fetch_assoc()) {
      if ($mobile == 1) {
        $file = $row['mobile_bg'];
        $file = str_replace($php_base_directory,$static_url."/",$file);
        return $file;
      } else if ($mobile == 0) {
        $file = $row['current_bg'];
        $file = str_replace($php_base_directory,$static_url."/",$file);
        return $file;
      }
  }
}?>
