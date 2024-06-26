<?php

function track_user(){

  global $db;
  global $user_ip;
  global $logged_in_id;
  global $mobile;
  global $is_user_a_bot;
  global $user_agent;

  // count hits
  if ($logged_in_id > 0) {

    //logged in user
    if ($mobile==1) {
      $db->sql( "INSERT INTO track_daily_hits SET ip_address=?, type=1, hits=1, mobile=1, logged_in=1 ON DUPLICATE KEY UPDATE hits=hits+1, mobile=mobile+1, logged_in=logged_in+1", 's' , $user_ip );
    } else {
      $db->sql( "INSERT INTO track_daily_hits SET ip_address=?, type=1, hits=1, logged_in=1 ON DUPLICATE KEY UPDATE hits=hits+1, logged_in=logged_in+1", 's' , $user_ip );
    }

  } else if($is_user_a_bot==1) {

    //bot
     $db->sql( "INSERT INTO track_daily_hits SET ip_address=?, type=2, hits=1 ON DUPLICATE KEY UPDATE hits=hits+1", 's' , $user_ip );

  } else {

    // logged out user
    if ($mobile==1) {
      $db->sql( "INSERT INTO track_daily_hits SET ip_address=?, type=1, hits=1, mobile=1 ON DUPLICATE KEY UPDATE hits=hits+1, mobile=mobile+1", 's' , $user_ip );
    } else {
      $db->sql( "INSERT INTO track_daily_hits SET ip_address=?, type=1, hits=1 ON DUPLICATE KEY UPDATE hits=hits+1", 's' , $user_ip );
    }

  }


  // Log referers
  if (!isset($_SERVER['HTTP_REFERER'])) {
    $HTTP_REFERER = 0;
  } else {
    $HTTP_REFERER = $_SERVER['HTTP_REFERER'];
  }

  $log_this = 1;
  if (str_contains($HTTP_REFERER, 'wallpapercropper.com')) {
    $log_this = 0;
  }
  if (str_contains($HTTP_REFERER, 'localhost')) {
    $log_this = 0;
  }
  if ($HTTP_REFERER==0) {
    $log_this = 0;
  }

  if ($log_this == 1) {
    $HTTP_REFERER_MD5 = md5($HTTP_REFERER);
    $db->sql( "INSERT INTO track_referrals SET url_md5=?, referral_url=?, visits=1 ON DUPLICATE KEY UPDATE visits=visits+1", 'ss' , $HTTP_REFERER_MD5, $HTTP_REFERER );
  }



  //track individual page hits
  $page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if (!empty($_GET)) {
   $page_url = strtok($page_url, '?');
  }

  $REQUEST_URI_MD5 = md5($page_url);

  if ($is_user_a_bot==0) {
    if ($mobile==1) {
      $db->sql( "INSERT INTO track_page_hits SET url_md5=?, the_url=?, m_hits=1 ON DUPLICATE KEY UPDATE m_hits=m_hits+1", 'ss' , $REQUEST_URI_MD5, $page_url );
    } else {
      $db->sql( "INSERT INTO track_page_hits SET url_md5=?, the_url=?, d_hits=1 ON DUPLICATE KEY UPDATE d_hits=d_hits+1", 'ss' , $REQUEST_URI_MD5, $page_url );
    }
  }




  //track user agents
  $user_agent_MD5 = md5($user_agent);
  $db->sql( "INSERT INTO track_useragents SET agent_md5=?, user_agent=?, hits=1 ON DUPLICATE KEY UPDATE hits=hits+1", 'ss' , $user_agent_MD5, $user_agent );




 return TRUE;
}
