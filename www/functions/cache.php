<?php
class cache
{

  var $tokens = "";

  function set_cache($key, $mobile, $data)
  {

    global $db;
    global $request_time;

    if ($mobile == 0) {

      $query = "INSERT INTO site_cache (cache_key, mobile, cache_data, data_age) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE cache_data = ?, data_age = ?";
      $db->sql($query, "sisssi", $key, $mobile, $data, $request_time, $data, $request_time);

      return true;

    } else if ($mobile == 1) {
      
      $query = "INSERT INTO site_cache (cache_key, mobile, cache_data_mobile, data_age_mobile) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE cache_data_mobile = ?, data_age_mobile = ?";
      $db->sql($query, "sisssi", $key, $mobile, $data, $request_time, $data, $request_time);

      return false;
    } else {
      return false;
    }
  }

  function get_cache($key, $mobile)
  { 

    $return = false;

    global $db;
    global $request_time;

    if ($mobile == 0) {

      $res = $db->sql("SELECT id, cache_key, mobile, cache_data, data_age FROM site_cache WHERE cache_key=? AND mobile=? LIMIT 1", "si", $key, $mobile);
      while ($row = $res->fetch_assoc()) {

        $data_age = $row['data_age'];  
        $cut_off_time = $data_age + 300;

        if ($cut_off_time > $request_time) {
          $return = $row['cache_data'];
        } 

      } 

    } else if ($mobile == 1) {

      $res = $db->sql("SELECT id, cache_key, mobile, cache_data_mobile, data_age_mobile FROM site_cache WHERE cache_key=? AND mobile=? LIMIT 1", "si", $key, $mobile);
      while ($row = $res->fetch_assoc()) {

        $data_age_mobile = $row['data_age_mobile'];  
        $cut_off_time = $data_age_mobile + 3600;

        if ($cut_off_time > $request_time) {
          $return = $row['cache_data_mobile'];
        } 

      }

    }
    
    return $return;
  }

  function clear()
  {
    global $db;
    $db->sql("UPDATE site_cache SET data_age=0, data_age_mobile=0");
  }
}
