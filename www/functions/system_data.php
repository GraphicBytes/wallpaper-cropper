<?php

function system_data(){

  global $db;

  $system_data = array();
  $res = $db->sql( "SELECT * FROM system ORDER BY id ASC");
  while($row=$res->fetch_assoc()) {
    $meta_name = $row['name'];
    $meta_value = $row['value'];
    $system_data[$meta_name]=$meta_value;
  }

  return $system_data;

}







?>
