<?php
$dbhost= getenv('MYSQL_HOST');

$dbuser= getenv('MYSQL_USER');
$dbpw= getenv('MYSQL_PASSWORD');
$dbname= getenv('MYSQL_DATABASE');

$dbconn = new mysqli($dbhost, $dbuser, $dbpw, $dbname);
mysqli_set_charset($dbconn, "utf8mb4");
if ($dbconn->connect_error) {die("Database Connection failed: " . $dbconn->connect_error);}

class db
{

  function sql($prepare, $types = null, $val = null, $va2 = null, $va3 = null, $va4 = null, $va5 = null, $va6 = null, $va7 = null, $va8 = null, $va9 = null, $va10 = null, $va11 = null, $va12 = null, $va13 = null, $va14 = null, $va15 = null)
  {

    global $dbconn;

    $stmt = $dbconn->prepare($prepare);

    if ($types != null) {
      if ($val !== null && $va2 === null) {
        $stmt->bind_param($types, $val);
      } else if ($va2 !== null && $va3 === null) {
        $stmt->bind_param($types, $val, $va2);
      } else if ($va3 !== null && $va4 === null) {
        $stmt->bind_param($types, $val, $va2, $va3);
      } else if ($va4 !== null && $va5 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4);
      } else if ($va5 !== null && $va6 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5);
      } else if ($va6 !== null && $va7 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6);
      } else if ($va7 !== null && $va8 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7);
      } else if ($va8 !== null && $va9 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8);
      } else if ($va9 !== null && $va10 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8, $va9);
      } else if ($va10 !== null && $va11 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8, $va9, $va10);
      } else if ($va11 !== null && $va12 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8, $va9, $va10, $va11);
      } else if ($va12 !== null && $va13 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8, $va9, $va10, $va11, $va12);
      } else if ($va13 !== null && $va14 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8, $va9, $va10, $va11, $va12, $va13);
      } else if ($va14 !== null && $va15 === null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8, $va9, $va10, $va11, $va12, $va13, $va14);
      } else if ($va15 !== null) {
        $stmt->bind_param($types, $val, $va2, $va3, $va4, $va5, $va6, $va7, $va8, $va9, $va10, $va11, $va12, $va13, $va14, $va15);
      }
    }
    $stmt->execute();
    $return = $stmt->get_result();
    return $return;
  }

  function clean($data)
  {
    global $dbconn;
    $data =  htmlspecialchars($data);
    return $data;
  }
}

//$res = $db->select( $prepare, $types , $vals );
$db = new db;