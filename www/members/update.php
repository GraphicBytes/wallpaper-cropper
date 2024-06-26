<?php
if ($logged_in_id == 0) {
  exit();
} else {


  if ($typea=="notificationread") {
    $db->sql( "UPDATE notifications SET viewed=1 WHERE id=? AND user_id=?", 'ii' , $typeb, $logged_in_id );
    exit();
  }


  if ($typea=="nsfw") {
    $mysqlquery="UPDATE users SET nsfw=$typeb WHERE id='$logged_in_id'";
    $db->sql( "UPDATE users SET nsfw=? WHERE id=?", 'ii' , $typeb, $logged_in_id );
    exit();
  }


  if ($typea=="defaultratio") {

    if($typeb=="default") {$typeb = null;}
    $db->sql( "UPDATE users SET defaultratio=? WHERE id=?", 'si' , $typeb, $logged_in_id );
    exit();
  }


  if ($typea=="resfilter") {

    if($typeb=="default") {$typeb = null;}

    $mysqlquery="UPDATE users SET resfilter='$typeb' WHERE id='$logged_in_id'";
    $db->sql( "UPDATE users SET resfilter=? WHERE id=?", 'si' , $typeb, $logged_in_id );
    exit();
  }


  if ($typea=="delete-collection") {


    $mysqlquery="SELECT * FROM collections WHERE id = '$typeb' AND owner_id = $logged_in_id ORDER BY id ASC";
    $res = $db->sql( "SELECT * FROM collections WHERE id = ? AND owner_id = ? ORDER BY id ASC", 'ii' , $typeb, $logged_in_id );
    while($row=$res->fetch_assoc()) {

          $db->sql( "DELETE FROM collection_links WHERE collection_id=?", 'i' , $typeb );

          $db->sql( "DELETE FROM collections WHERE id=?", 'i' , $typeb );
      }

    $location = "Location: " . $base_url . "/your-collections/";
    header($location);
    exit();

  }


  if ($typea=="delete-from-collection") {

    $res = $db->sql( "SELECT * FROM collections WHERE id = ? AND owner_id = ? ORDER BY id ASC", 'ii' , $typeb, $logged_in_id);
    while($row=$res->fetch_assoc()) {

      $db->sql( "DELETE FROM collection_links WHERE collection_id = ? AND wallpaper_id = ?", 'ii' , $typeb, $typec );

      $db->sql( "UPDATE collections SET count=count-1 WHERE id=?", 'i' , $typeb );

    }

    $location = "Location: " . $base_url . "/collection/" . $typeb . "/";
    header($location);
    exit();

  }



  if ($typea=="collection-details") {

    $mysqlquery="SELECT * FROM collections WHERE id = '$typeb' AND owner_id = $logged_in_id ORDER BY id ASC";
    $res = $db->sql( "SELECT * FROM collections WHERE id = ? AND owner_id =  ? ORDER BY id ASC", 'ii' , $typeb, $logged_in_id );
    while($row=$res->fetch_assoc()) {

      $newname = $_POST['name'];

      $db->sql( "UPDATE collections SET name=? WHERE id=?", 'si' , $newname, $typeb );

      }

    $location = "Location: " . $base_url . "/collection/" . $typeb . "/";
    header($location);
    exit();

  }


  if ($typea=="collection") {

            $wallpaper_id = $typeb;

            $res = $db->sql( "SELECT * FROM collections WHERE owner_id = ? ORDER BY id ASC", 'i' , $logged_in_id );
            while($row=$res->fetch_assoc()) {
              $clear_id = $row['id'];

              $resq=$db->sql( "SELECT id FROM collection_links WHERE collection_id = ? AND wallpaper_id=? ORDER BY id ASC", 'ii' , $clear_id, $wallpaper_id );
              while($rowq=$resq->fetch_assoc()) { $deleteid=$rowq['id'];

                  $db->sql( "DELETE FROM collection_links WHERE id = ?", 'i' , $deleteid );

                  $db->sql( "UPDATE collections SET count=count-1 WHERE id=?", 'i' , $clear_id );
              }
            }


            if(!isset($_POST['collection'])){

                  $location = "Location: " . $base_url . "/view-wall/" . $wallpaper_id . "/";
                  header($location);
                  exit();

            } else {

                        $collections = $_POST['collection'];
                        foreach ($collections as $collection) {

                                      $collectiontitle = htmlspecialchars($collection, ENT_QUOTES);

                                      $collectionslug = htmlspecialchars($collection, ENT_QUOTES);
                                      $collectionslug = strtolower($collectionslug);
                                      $collectionslug = create_slug($collectionslug);

                                      //does collection already exist
                                      $collectioncount=0;
                                      $mysqlquery="SELECT * FROM collections WHERE slug='$collectionslug' AND owner_id = $logged_in_id ORDER BY id ASC";
                                      $res=$db->sql( "SELECT * FROM collections WHERE slug=? AND owner_id = ? ORDER BY id ASC", 'si' , $collectionslug.$logged_in_id );
                                      while($row=$res->fetch_assoc()) {$collectioncount=1; $collection_id = $row['id'];}

                                      if($collectioncount==0){
                                            $db->sql( "INSERT INTO collections SET owner_id=?, name=?, slug=?, count='1'", 'iss' , $logged_in_id, $collectiontitle, $collectionslug );

                                            $res=$db->sql( "SELECT * FROM collections WHERE slug=? AND owner_id = ? ORDER BY id ASC", 'si' , $collectionslug, $logged_in_id );
                                            while($row=$res->fetch_assoc()) {$collection_id = $row['id'];}
                                      }

                                      $db->sql( "INSERT INTO collection_links SET collection_id=?, wallpaper_id=?", 'ii' , $collection_id, $wallpaper_id );

                                      //is wallpaper safe for work
                                      $mysqlquery="SELECT sfw FROM wallpapers WHERE id = $wallpaper_id ORDER BY id ASC";
                                      $res=$db->sql( "SELECT sfw FROM wallpapers WHERE id = ? ORDER BY id ASC", 'i' , $wallpaper_id );
                                      while($row=$res->fetch_assoc()) {$sfw = $row['sfw'];

                                        if($sfw==0) {$sfwmsql=", sfw='0'";}else{$sfwmsql="";}

                                      }

                                      $db->sql( "UPDATE collections SET count=count+1 $sfwmsql WHERE id=?", 'i' , $collection_id );

                          }

                    $location = "Location: " . $base_url . "/view-wall/" . $wallpaper_id . "/";
                    header($location);
                    exit();

                }

  }

}

?>
