<?php
            $id = null;
            $creation_id = null;

            $res = $db->sql( "SELECT * FROM wall_generation WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $typea );
            while($row=$res->fetch_assoc()) {
              $id = $row['id'];
              $owner = $row['owner'];
            }

        if ($logged_in_id == $owner) {

                              $res = $db->sql( "SELECT * FROM wall_generation WHERE id=? ORDER BY id DESC LIMIT 1", 'i' , $typea );
                              while($row=$res->fetch_assoc()) {

                                $id = $row['id'];
                                $owner = $row['owner'];

                                $originalimage = $row['imagefile'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['thumbnail'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['3840x2160'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['2560x1440'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1920x1080'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1280x720'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['16by10thumb'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['2560x1600'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1920x1200'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1680x1050'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1280x800'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['4by3thumb'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['2800x2100'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['2048x1536'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1400x1050'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1024x768'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['5by4thumb'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['2560x2048'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['1280x1024'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['mobilethumb'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['mobilesmall'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['mobilemedium'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['mobilestandard'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['mobilelarge'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['16by9_share'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['16by10_share'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['4by3_share'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['5by4_share'];
                                if(file_exists($originalimage)){unlink($originalimage);}
                                $originalimage = $row['mobile_share'];
                                if(file_exists($originalimage)){unlink($originalimage);}

                                }


                                $db->sql( "DELETE FROM wall_generation WHERE id=?", 'i' , $typea );

                              }

                              $location = "Location: " . $base_url . "/createwall/";
                              header($location);
                              exit();



?>
