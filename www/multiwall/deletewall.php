<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

            $id = null;
            $creation_id = null;
            $res = $db->sql( "SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $typea );
            while($row=$res->fetch_assoc()) {
              $id = $row['id'];
              $owner = $row['owner'];
            }

        if ($logged_in_id == $owner or $logged_in_id == 1) {

                              $res = $db->sql( "SELECT * FROM wallpapers WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $typea );
                              while($row=$res->fetch_assoc()) {

                                $id = $row['id'];
                                $owner = $row['owner'];

                                $creation_id = $row['creation_id'];

                                      //get rid of original file
                                      $resc = $db->sql( "SELECT * FROM wall_generation WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $creation_id );
                                      while($rowc=$resc->fetch_assoc()) {
                                        $originalimage = $rowc['imagefile'];
                                        if(file_exists($originalimage)){
                                              unlink($originalimage);
                                        }
                                      }


                                      if(file_exists($row['16by9thumb'])){unlink($row['16by9thumb']);}
                                      if(file_exists($row['16by10thumb'])){unlink($row['16by10thumb']);}
                                      if(file_exists($row['4by3thumb'])){unlink($row['4by3thumb']);}
                                      if(file_exists($row['5by4thumb'])){unlink($row['5by4thumb']);}
                                      if(file_exists($row['mobilethumb'])){unlink($row['mobilethumb']);}
                                      if(file_exists($row['3840x2160'])){unlink($row['3840x2160']);}
                                      if(file_exists($row['2560x1440'])){unlink($row['2560x1440']);}
                                      if(file_exists($row['1920x1080'])){unlink($row['1920x1080']);}
                                      if(file_exists($row['1280x720'])){unlink($row['1280x720']);}
                                      if(file_exists($row['2560x1600'])){unlink($row['2560x1600']);}
                                      if(file_exists($row['1920x1200'])){unlink($row['1920x1200']);}
                                      if(file_exists($row['1680x1050'])){unlink($row['1680x1050']);}
                                      if(file_exists($row['1280x800'])){unlink($row['1280x800']);}
                                      if(file_exists($row['2800x2100'])){unlink($row['2800x2100']);}
                                      if(file_exists($row['2048x1536'])){unlink($row['2048x1536']);}
                                      if(file_exists($row['1400x1050'])){unlink($row['1400x1050']);}
                                      if(file_exists($row['1024x768'])){unlink($row['1024x768']);}
                                      if(file_exists($row['2560x2048'])){unlink($row['2560x2048']);}
                                      if(file_exists($row['1280x1024'])){unlink($row['1280x1024']);}
                                      if(file_exists($row['mobilestandard'])){unlink($row['mobilestandard']);}
                                      if(file_exists($row['mobilelarge'])){unlink($row['mobilelarge']);}
                                      if(file_exists($row['16by9_share'])){unlink($row['16by9_share']);}
                                      if(file_exists($row['16by10_share'])){unlink($row['16by10_share']);}
                                      if(file_exists($row['4by3_share'])){unlink($row['4by3_share']);}
                                      if(file_exists($row['5by4_share'])){unlink($row['5by4_share']);}
                                      if(file_exists($row['mobile_share'])){unlink($row['mobile_share']);}





                                        //reset creation tables to save on memory
                                        $mysqlqueryb="UPDATE wall_generation SET
                                        moderated = 1,
                                        imagefile = null,
                                        thumbnail = null,
                                        3840x2160 = null,
                                        2560x1440 = null,
                                        1920x1080 = null,
                                        1280x720 = null,
                                        16by10thumb = null,
                                        2560x1600 = null,
                                        1920x1200 = null,
                                        1680x1050 = null,
                                        1280x800 = null,
                                        4by3thumb = null,
                                        2800x2100 = null,
                                        2048x1536 = null,
                                        1400x1050 = null,
                                        1024x768 = null,
                                        5by4thumb = null,
                                        2560x2048 = null,
                                        1280x1024 = null,
                                        mobilethumb = null,
                                        mobilestandard = null,
                                        mobilelarge = null
                                        WHERE id=?";
                                        $db->sql( $mysqlqueryb, 'i' , $id );

                                        }


                                        $db->sql( "DELETE FROM wallpapers WHERE id=?", 'i' , $typea );
                                        $db->sql( "DELETE FROM tag_links WHERE wallpaper_id=?", 'i' , $typea );
                                        $db->sql( "DELETE FROM category_links WHERE wallpaper_id=?", 'i' , $typea );
                                        $db->sql( "DELETE FROM bookmarked_walls WHERE wallpaper_id=?", 'i' , $typea );
                                        $db->sql( "DELETE FROM collection_links WHERE wallpaper_id=?", 'i' , $typea );

                              }

                              $location = "Location: " . $base_url . "/overview/";
                              header($location);
                              exit();



}?>
