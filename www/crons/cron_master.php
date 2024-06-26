<?php

$last_cron_ping = $system_data['last_cron_ping'];
$timeout_ignore = 1;

if ((($request_time - 30) > $last_cron_ping) or $timeout_ignore == 1) {

    $mysqlquery = "UPDATE system SET value='$request_time' WHERE name='last_cron_ping'";
    $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

    //bgrotate
    include('_jobs/bgrotate.php');

    //category_count
    include('_jobs/category_count.php');

    //clean_temp_files
    include('_jobs/clean_temp_files.php');

    //malicious_ip_clean
    include('_jobs/malicious_ip_clean.php');

    //tracking_updates
    include('_jobs/tracking_updates.php');

    //trend_clean
    include('_jobs/trend_clean.php');


} else {
    $timeleft = 30 - ($request_time - $last_cron_ping);
    echo "TIMEOUT:" . $timeleft;
}