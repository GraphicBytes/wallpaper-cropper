<?php

$last_temp_clean = $system_data['last_temp_clean'];
if ((($request_time - 900) > $last_temp_clean)) {

    $mysqlquery = "UPDATE system SET value='$request_time' WHERE name='last_temp_clean'";
    $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));



    //delete classic DB
    $time = time();
    $time = $time - (60 * 60);

    //delete old walls
    $mysqlquery = "SELECT * FROM classic ORDER BY id DESC";
    $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    while ($row = $res->fetch_assoc()) {
        if ($row['time'] < $time) {

            $id = $row['id'];

            $mysqlqueryz = "DELETE FROM classic WHERE id='$id'";
            $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));
        }
    }




    $path = $php_base_directory . 'tempfiles/';

    // Open the directory
    if ($handle = opendir($path)) {
        // Loop through the directory
        while (false !== ($file = readdir($handle))) {
            // Check the file we're doing is actually a file
            if (is_file($path . $file)) {
                // Check if the file is older than X days old
                if (filemtime($path . $file) < (time() - (60 * 60))) {
                    $fileext = substr(strrchr($file, '.'), 1);

                    if ($fileext == "php") {
                    } else {
                        unlink($path . $file);
                    }
                }
            }
        }
    }




    //delete incomplete profile photos
    $time = time();
    $time = $time - (60 * 60 * 24 * 7);

    $mysqlquery = "SELECT * FROM newprofilephotos WHERE complete = '0' ORDER BY id DESC LIMIT 1";
    $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    while ($row = $res->fetch_assoc()) {

        if ($row['uploadtime'] < $time) {

            $id = $row['id'];

            $mysqlqueryb = "DELETE FROM newprofilephotos WHERE id='$id'";
            $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
        }
    }




    //delete incomplete multiwalls
    $time = time();
    $time = $time - (60 * 60 * 24 * 7);

    $mysqlquery = "SELECT * FROM wall_generation ORDER BY id DESC";
    $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    while ($row = $res->fetch_assoc()) {
        if ($row['create_time'] < $time) {

            $id = $row['id'];

            $mysqlqueryz = "DELETE FROM wall_generation WHERE id='$id'";
            $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));
        }
    }




    $path = $php_base_directory . 'tempfiles2/';

    // Open the directory
    if ($handle = opendir($path)) {
        // Loop through the directory
        while (false !== ($file = readdir($handle))) {
            // Check the file we're doing is actually a file
            if (is_file($path . $file)) {
                // Check if the file is older than X days old
                if (filemtime($path . $file) < (time() - (60 * 60 * 24 * 7))) {
                    $fileext = substr(strrchr($file, '.'), 1);

                    if ($fileext == "php") {
                    } else {
                        unlink($path . $file);
                    }
                }
            }
        }
    }

    echo "TEMP FILES CLEANED";
    echo "<br />";
}
