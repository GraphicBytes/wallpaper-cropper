<?php

$last_malicious_ip_clean = $system_data['last_malicious_ip_clean'];
$time_compare_target = $request_time - $last_malicious_ip_clean;
$malicious_ips_total = 0;
$this_cron_has_run = 0;

$dilute_rate = 10;

$this_cron_job_timeout = 30;
$dilute_timeout = 300;

if ($time_compare_target > $this_cron_job_timeout) {

  $mysqlquery = "SELECT * FROM malicious_ips ORDER BY id DESC";
  $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while ($row = $res->fetch_assoc()) {

    $log_id = $row['id'];
    $attempts = $row['attempts'];
    $last_attempt = $row['last_attempt'];

    if ((($request_time - $last_attempt) > $dilute_timeout)) {

      $diluted_attempts = $attempts - $dilute_rate;

      if ($diluted_attempts > 0) {
        $updatequery = "UPDATE malicious_ips SET attempts='$diluted_attempts' WHERE id = '$log_id'";
      } else {
        $updatequery = "DELETE FROM malicious_ips WHERE id = '$log_id'";
      }

      $malicious_ips_total = $malicious_ips_total + 1;
      $dbconn->query($updatequery) or die(mysqli_error($dbconn));
    }
  }

  



  //remove very old user agent catches
  $user_agent_clean_time = $request_time - 15780000;
  $updatequery = "DELETE FROM malicious_useragents WHERE last_attempt <'$request_time'";





  echo $malicious_ips_total . " MALICIOUS IPs CLEANED";
  echo "<br />";

  $mysqlquery = "UPDATE system SET value='$request_time' WHERE name='last_malicious_ip_clean'";
  $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
}
