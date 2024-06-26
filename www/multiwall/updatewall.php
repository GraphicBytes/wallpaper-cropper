<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $id = null;
  $creation_id = null;

  $res = $db->sql("SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1", 'i', $typea);
  while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $owner = $row['owner'];

    $highlight = $row['highlight'];

    $creation_id = $row['creation_id'];

    $thumb16by9 = $row['16by9thumb'];
    $thumb16by10 = $row['16by10thumb'];
    $thumb4by3 = $row['4by3thumb'];
    $thumb5by4  = $row['5by4thumb'];
    $thumbmobile = $row['mobilethumb'];

    $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);
    $thumb16by10 = str_replace($php_base_directory, $base_url . "/", $thumb16by10);
    $thumb4by3 = str_replace($php_base_directory, $base_url . "/", $thumb4by3);
    $thumb5by4 = str_replace($php_base_directory, $base_url . "/", $thumb5by4);
    $thumbmobile = str_replace($php_base_directory, $base_url . "/", $thumbmobile);

    $replace = $base_url . "/";

    $title = $row['title'];
    $credit = $row['image_credit'];
  }



  if ($logged_in_id == $owner or $logged_in_id == 1) {






    $walltitle = $_POST['title'];
    $credit = $_POST['credit'];

    $db->sql("UPDATE wallpapers SET title = '$walltitle', image_credit='$credit' WHERE id='$typea'", 'ssi', $walltitle, $credit, $typea);

    //reset categorys
    $db->sql("DELETE FROM category_links WHERE wallpaper_id=?", 'i', $typea);

    //insert categorys
    $categories = $_POST['category'];
    foreach ($categories as $category) {

      $db->sql("INSERT INTO category_links SET category_id=?, wallpaper_id=?", 'ii', $category, $typea);
    }


    //get tags
    $db->sql("DELETE FROM tag_links WHERE wallpaper_id=?", 'i', $typea);

    $tags = $_POST['tags'];
    $tags = htmlspecialchars($tags, ENT_QUOTES);
    $tags = explode(",", $tags);
    foreach ($tags as $tag) {

      if ($tag == "") {
      } else {


        $tag = strtolower($tag);
        $slug = create_slug($tag);

        $tagcount = 0;
        $res->sql("SELECT * FROM tags WHERE tag_name=? ORDER BY id ASC", 's', $tag);
        while ($row = $res->fetch_assoc()) {
          $tagcount = 1;
          $tag_id = $row['id'];
        }

        if ($tagcount == 0) {
          $db->sql("INSERT INTO tags SET tag_name=?, slug=?", 'ss', $tag, $slug);

          $res = $db->sql("SELECT * FROM tags WHERE tag_name=? ORDER BY id ASC", 's', $tag);
          while ($row = $res->fetch_assoc()) {
            $tagcount = 1;
            $tag_id = $row['id'];
          }
        };

        $db->sql("INSERT INTO tag_links SET tag_id=?, wallpaper_id=?", 'si', $tag_id, $typea);
      }
    }




    $location = "Location: " . $base_url . "/view-wall/" . $typea . "/";
    header($location);
    exit();
  } else {
    $location = "Location: " . $base_url;
    log_malicious();
    header($location);
    exit();
  }
}
