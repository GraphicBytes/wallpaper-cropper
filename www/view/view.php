<?php
include('../config/db.php');
include('../config/globals.php');

$downloadkey = $_GET['downloadkey'];
$downloadkey = str_replace("view/", "", $downloadkey);

$id = $_GET['id'];
$resolution = $_GET['resolution'];

$default = $php_base_directory . "view/default.jpg";

$mysqlquery="SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1";
$stmt = $dbconn->prepare($mysqlquery);
$stmt->bind_param('s',$id);
$stmt->execute();
$wallres = $stmt->get_result();


while($wallrow=$wallres->fetch_assoc()) {


      if($downloadkey == $wallrow['downloadkey']) {
        $filePath = $wallrow[$resolution];
      } else {
        $filePath = $default;
      }

}

  if(file_exists($filePath)) {

        $mysqlqueryb= "UPDATE wallpapers SET downloads=downloads+1, trend=trend+1, last_download=? WHERE id=?";
        $stmt = $dbconn->prepare($mysqlqueryb);
        $stmt->bind_param('si', $request_time, $id);
        $stmt->execute();


        $timestamp = time();
        $tsstring = gmdate('D, d M Y H:i:s ', $timestamp) . 'GMT';
        $etag = md5($timestamp);
        header("Last-Modified: $tsstring");
        header("ETag: \"{$etag}\"");
        header('Expires: Thu, 01-Jan-70 00:00:01 GMT');
        header( 'Expires: Sat, 31 Dec 2050 05:00:00 GMT' );
        header('Content-Type: image/jpeg');
        header("Accept-Ranges: bytes");
        readfile($filePath);




  } else {

    $timestamp = time();
    $tsstring = gmdate('D, d M Y H:i:s ', $timestamp) . 'GMT';
    $etag = md5($timestamp);
    header("Last-Modified: $tsstring");
    header("ETag: \"{$etag}\"");
    header('Expires: Thu, 01-Jan-70 00:00:01 GMT');
    header( 'Expires: Sat, 31 Dec 2050 05:00:00 GMT' );
    header('Content-Type: image/jpeg');
    header("Accept-Ranges: bytes");
    readfile($default);


  }
?>
