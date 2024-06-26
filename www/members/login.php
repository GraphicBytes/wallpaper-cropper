<?php
if ($typea == "email" && $is_malicious == 0) {

  $password = $_POST['password'];
  $password = hash('sha256', $password . $websitesalt);

  $account_exists = 0;

  $mysqlquery = "SELECT * FROM users WHERE email= ? AND email_verfied = 1 ORDER BY id DESC LIMIT 1";
  $stmt = $dbconn->prepare($mysqlquery);
  $stmt->bind_param('s', $_POST['email']);
  $stmt->execute();
  $res = $stmt->get_result();

  while ($row = $res->fetch_assoc()) {

    $cookie_id = $row['cookie_id'];
    if ($cookie_id == null) {
      $cookie_id = random_str(100);
    }

    $user_id = $row['id'];
    $user_email = $row['email'];
    $user_password = $row['password'];
    $login_fail = $row['login_fail'];

    $account_exists = 1;
  }

  //does account exist
  if ($account_exists == 1 and $login_fail < 10) {

    //does password match
    if ($password == $user_password) {

      $time = time();

      $mysqlquery = "UPDATE users SET cookie_id=?, cookie_age=?, last_login=?, login_fail ='0', cookie_fail='0' WHERE id=?";
      $stmt = $dbconn->prepare($mysqlquery);
      $stmt->bind_param('ssss', $cookie_id, $time, $time, $user_id);
      $stmt->execute();
      $res = $stmt->get_result();


      setcookie("wallpapercropper", $cookie_id, time() + 31536000, "/");

      $db->sql("DELETE FROM malicious_ips WHERE ip_address=?", 's', $user_ip);
      $db->sql("DELETE FROM malicious_useragents WHERE agent_ip=?", 's', $user_ip);

      $location = "Location: " . $base_url . "/overview/";
      header($location);
      exit();
    } else {

      if ($_POST['password'] == "") {
      } else {
        $login_fail = $login_fail + 1;
      }

      $mysqlquery = "UPDATE users SET login_fail= ? WHERE id= ?";
      $stmt = $dbconn->prepare($mysqlquery);
      $stmt->bind_param('ss', $login_fail, $user_id);
      $stmt->execute();


      $location = "Location: " . $base_url . "/join-login/passwordfail/";
      log_malicious();
      header($location);
      exit();
    }
  } else { //account does not exist
    log_malicious();
    $location = "Location: " . $base_url . "/join-login/noaccount/";
    header($location);
    exit();
  }
} else {
  log_malicious();
  $location = "Location: " . $base_url;
  header($location);
  exit();
}
