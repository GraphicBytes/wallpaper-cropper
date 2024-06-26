<?php

$saved_date=$system_data['current_date'];
$new_date = date("d-m-Y", $request_time);

if ($saved_date != $new_date) {

  $unique_bots = 0;
  $total_bots = 0;

  $user_hits_total = 0;
  $user_hits_unique = 0;

  $user_mobile_hits_total=0;
  $user_mobile_unique=0;

  $user_logged_in_total=0;
  $user_logged_in_unique=0;

  $mysqlquery="SELECT * FROM track_daily_hits ORDER BY id";
  $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while($row=$res->fetch_assoc()) {

    $hits_type=$row['type'];
    $hits=$row['hits'];
    $mobile_hits=$row['mobile'];
    $logged_in_hits=$row['logged_in'];

    if ($hits_type == 2) {
      $unique_bots = $unique_bots + 1;
      $total_bots = $total_bots + $hits;
    }

    if ($hits_type == 1) {
      $user_hits_unique = $user_hits_unique + 1;
      $user_hits_total = $user_hits_total + $hits;

      if ($logged_in_hits > 0) {
        $user_logged_in_unique = $user_logged_in_unique + 1;
        $user_logged_in_total = $user_logged_in_total + $logged_in_hits;
      }

      if ($mobile_hits > 0) {
        $user_mobile_unique = $user_mobile_unique + 1;
        $user_mobile_hits_total = $user_mobile_hits_total + $mobile_hits;
      }
    }

  }


  $unique_t = $user_hits_unique;

  if ($user_hits_unique == 0) {
    $unique_mp = 0;
  } else {
    $unique_mp = round( ($user_mobile_unique/$user_hits_unique)*100 , 3);
  }

  if ($user_hits_unique == 0) {
    $unique_lp = 0;
  } else {
    $unique_lp = round( ($user_logged_in_unique/$user_hits_unique)*100 , 3);
  }

  $hits_t = $user_hits_total;

  if ($user_hits_total == 0) {
    $hits_mp = 0;
  } else {
    $hits_mp = round( ($user_mobile_hits_total/$user_hits_total)*100 , 3);
  }

  if ($user_hits_total == 0) {
    $hits_lp = 0;
  } else {
    $hits_lp = round( ($user_logged_in_total/$user_hits_total)*100 , 3);
  }

  $bot_u = $unique_bots;
  $bot_t = $total_bots;


  // $referals=array();
  // $referal_count = 0;
  // $mysqlquery="SELECT * FROM track_referrals ORDER BY visits DESC";
  // $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  // while($row=$res->fetch_assoc()) {
  //   $referral_url = $row['referral_url'];
  //   $referral_visits = $row['visits'];
  //   $referals[$referal_count][$referral_visits] = $referral_url;
  //   $referal_count = $referal_count + 1;
  // }

  // $referals = serialize($referals);

// print_r($saved_date);
// print_r($unique_t);
// print_r($unique_mp);
// print_r($unique_lp);
// print_r($hits_t);
// print_r($hits_mp);
// print_r($hits_lp);
// print_r($bot_u);
// print_r($bot_t);


  $sql = "INSERT INTO track_daily_totals SET the_date='$saved_date', unique_t='$unique_t', unique_mp='$unique_mp', unique_lp='$unique_lp', hits_t='$hits_t', hits_mp='$hits_mp', hits_lp='$hits_lp', bot_u='$bot_u', bot_t='$bot_t'";
  $db->sql($sql);

  //$db->sql("TRUNCATE TABLE track_referrals");
  $db->sql("TRUNCATE TABLE track_daily_hits");
  $db->sql("UPDATE system SET value=? WHERE name=?", "ss", $new_date, "current_date");

  echo "TRACKING LOGGED FOR ANOTHER DAY<br />";

}


?>
