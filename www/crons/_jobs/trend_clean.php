<?php

$last_trend_clean = $system_data['last_trend_clean'];

if ((($request_time - 10800) > $last_trend_clean)) {

    $mysqlquery = "UPDATE system SET value='$request_time' WHERE name='last_trend_clean'";
    $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

    $mysqlquery = "SELECT id, trend, last_download FROM wallpapers WHERE trend > 0 ORDER BY trend DESC";
    $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $trend = $row['trend'];
        $last_download = $row['last_download'];

        if (($trend != 0) && (($request_time - $last_download) > 86400)) {
            $newtrend = $trend - 1;
            $dbconn->query("UPDATE wallpapers SET trend='$newtrend' WHERE id='$id'");
        }

    }

    echo "TREND CLEANED";
    echo "<br />";
}
