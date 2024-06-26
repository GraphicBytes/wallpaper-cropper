<?php

$last_cat_count = $system_data['last_cat_count'];

if ((($request_time - 3600) > $last_cat_count)) {

  $mysqlquery = "UPDATE system SET value='$request_time' WHERE name='last_cat_count'";
  $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

  //count-cats

  $mysqlquery = "SELECT * FROM category ORDER BY id DESC";
  $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while ($row = $res->fetch_assoc()) {

    $cat_id = $row['id'];

    $count = 0;
    $nsfwcount = 0;
    $mysqlqueryb = "SELECT * FROM category_links WHERE category_id = '$cat_id' ORDER BY id DESC";
    $resb = $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
    while ($rowb = $resb->fetch_assoc()) {

      $wallid = $rowb['wallpaper_id'];

      $mysqlqueryc = "SELECT * FROM wallpapers WHERE hq='1' AND id='$wallid' ORDER BY id DESC";
      $resc = $dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
      while ($rowc = $resc->fetch_assoc()) {

        if ($rowc['sfw'] == 1) {
          $count = $count + 1;
        }
        if ($rowc['sfw'] == 0) {
          $nsfwcount = $nsfwcount + 1;
        }
      }
    }

    $mysqlqueryz = "UPDATE category SET total ='$count', nsfw_total ='$nsfwcount' WHERE id='$cat_id'";
    $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));
  }



  //count-tags

  $mysqlquery = "SELECT * FROM tags ORDER BY id DESC";
  $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while ($row = $res->fetch_assoc()) {

    $tag_id = $row['id'];

    $count = 0;
    $nsfwcount = 0;
    $mysqlqueryb = "SELECT * FROM tag_links WHERE tag_id = '$tag_id' ORDER BY id DESC";
    $resb = $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
    while ($rowb = $resb->fetch_assoc()) {

      $wallid = $rowb['wallpaper_id'];

      $mysqlqueryc = "SELECT * FROM wallpapers WHERE hq='1' AND id='$wallid' ORDER BY id DESC";
      $resc = $dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
      while ($rowc = $resc->fetch_assoc()) {

        if ($rowc['sfw'] == 1) {
          $count = $count + 1;
        }
        if ($rowc['sfw'] == 0) {
          $nsfwcount = $nsfwcount + 1;
        }
      }
    }

    $mysqlqueryz = "UPDATE tags SET total ='$count', nsfw_total ='$nsfwcount' WHERE id='$tag_id'";
    $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));
  }



  //count-collections
  $mysqlquery = "SELECT * FROM collections ORDER BY id DESC";
  $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while ($row = $res->fetch_assoc()) {

    $collection_count = 0;
    $sfw = 1;

    $collection_id = $row['id'];

    $mysqlqueryb = "SELECT * FROM collection_links WHERE collection_id='$collection_id' ORDER BY id DESC";
    $resb = $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
    while ($rowb = $resb->fetch_assoc()) {

      $wallpaper_id = $rowb['wallpaper_id'];

      $mysqlqueryc = "SELECT sfw FROM wallpapers WHERE id='$wallpaper_id' ORDER BY id DESC";
      $resc = $dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
      while ($rowc = $resc->fetch_assoc()) {

        if ($rowc['sfw'] == 0) {
          $sfw = 0;
        }
      }

      $collection_count = $collection_count + 1;
    }

    $mysqlqueryz = "UPDATE collections SET count ='$collection_count', sfw ='$sfw' WHERE id='$collection_id'";
    $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));
  }



  //count-bookmarks

  $mysqlquery = "SELECT * FROM wallpapers ORDER BY id DESC";
  $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
  while ($row = $res->fetch_assoc()) {

    $bookmarks_id = $row['id'];

    $count = 0;

    $mysqlqueryb = "SELECT * FROM bookmarked_walls WHERE wallpaper_id = '$bookmarks_id' ORDER BY id DESC";
    $resb = $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
    while ($rowb = $resb->fetch_assoc()) {
      $count = $count + 1;
    }

    $mysqlqueryz = "UPDATE wallpapers SET thumbs_up ='$count' WHERE id='$bookmarks_id'";
    $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));
  }

  echo "CATEGORIES COUNTED";
  echo "<br />";
}
