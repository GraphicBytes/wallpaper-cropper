<?php
if ($logged_in_id == 0) {
  log_malicious();
  $location = "Location: " . $base_url;
  header($location);
  exit();
} else {

        if ($logged_in_id == 1) {

                    if ($typeb == "recat") {

                      $walltitle = $_POST['title'];
                      $credit = $_POST['credit'];

                      $mysqlqueryb="UPDATE wallpapers SET title = '$walltitle', image_credit='$credit' WHERE id='$typea'";
                      $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                      //reset categorys
                      $mysqlquery="DELETE FROM category_links WHERE wallpaper_id='$typea'";
                      $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

                      //insert categorys
                      $categories = $_POST['category'];
                      foreach ($categories as $category) {

                          $mysqlquery="INSERT INTO category_links SET category_id='$category', wallpaper_id='$typea'";
                          $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

                      }


                      //get tags
                      $mysqlquery="DELETE FROM tag_links WHERE wallpaper_id='$typea'";
                      $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

                      $tags = $_POST['tags'];
                      $tags = htmlspecialchars($tags, ENT_QUOTES);
                      $tags = explode(",", $tags);
                      foreach ($tags as $tag) {

                        if($tag==""){} else {


                                    $tag = strtolower($tag);
                                    $slug = create_slug($tag);

                                    $tagcount=0;
                                    $mysqlquery="SELECT * FROM tags WHERE tag_name='$tag' ORDER BY id ASC";
                                    $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                                    while($row=$res->fetch_assoc()) {$tagcount=1; $tag_id = $row['id'];}

                                    if($tagcount==0){
                                          $mysqlquery="INSERT INTO tags SET tag_name='$tag', slug='$slug'";
                                          $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

                                          $mysqlquery="SELECT * FROM tags WHERE tag_name='$tag' ORDER BY id ASC";
                                          $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                                          while($row=$res->fetch_assoc()) {$tagcount=1; $tag_id = $row['id'];}
                                    };

                                $mysqlquery="INSERT INTO tag_links SET tag_id='$tag_id', wallpaper_id='$typea'";
                                $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                        }
                      }




                      $location = "Location: " . $base_url . "/moderate/";
                      header($location);
                      exit();

                    } else if ($typeb == "highlight") {

                      $mysqlquery="SELECT * FROM wallpapers WHERE id='$typea' ORDER BY id DESC LIMIT 1";
                      $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                      while($row=$res->fetch_assoc()) {

                        $highlight = $row['highlight'];

                            if ($highlight==1){

                              $mysqlqueryb="UPDATE wallpapers SET highlight='0' WHERE id='$typea'";
                              $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                            }else{

                              $mysqlqueryb="UPDATE wallpapers SET highlight='1' WHERE id='$typea'";
                              $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                            }

                      }

                      $location = "Location: " . $base_url . "/moderate/";
                      header($location);
                      exit();

                    } else if ($typeb == "highlight-b") {

                      $mysqlquery="SELECT * FROM wallpapers WHERE id='$typea' ORDER BY id DESC LIMIT 1";
                      $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                      while($row=$res->fetch_assoc()) {

                        $highlight = $row['highlight'];

                            if ($highlight==1){

                              $mysqlqueryb="UPDATE wallpapers SET highlight='0' WHERE id='$typea'";
                              $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                            }else{

                              $mysqlqueryb="UPDATE wallpapers SET highlight='1' WHERE id='$typea'";
                              $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                            }

                      }

                      $location = "Location: " . $base_url . "/edit-wall/" . $typea .  "/";
                      header($location);
                      exit();

                    } else if ($typeb == "sfw") {

                      $mysqlquery="SELECT * FROM wallpapers WHERE id='$typea' ORDER BY id DESC LIMIT 1";
                      $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                      while($row=$res->fetch_assoc()) {

                        $sfw = $row['sfw'];

                            if ($sfw==1){

                              $mysqlqueryb="UPDATE wallpapers SET sfw='0' WHERE id='$typea'";
                              $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                            }else{

                              $mysqlqueryb="UPDATE wallpapers SET sfw='1' WHERE id='$typea'";
                              $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                            }

                      }

                      $location = "Location: " . $base_url . "/edit-wall/" . $typea .  "/";
                      header($location);
                      exit();

                    } else if ($typeb == "sfwhq") {


                              $mysqlquery="SELECT * FROM wallpapers WHERE id='$typea' ORDER BY id DESC LIMIT 1";
                              $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                              while($row=$res->fetch_assoc()) {
                                        $id = $row['id'];
                                        $owner = $row['owner'];

                                        $thumb16by9 = $row['16by9thumb'];
                                        $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);

                                        $creation_id = $row['creation_id'];


                                        //get rid of original file
                                        $mysqlqueryc="SELECT * FROM wall_generation WHERE id='$creation_id' ORDER BY id DESC LIMIT 1";
                                        $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
                                        while($rowc=$resc->fetch_assoc()) {
                                          $originalimage = $rowc['imagefile'];
                                          if(file_exists($originalimage)){
                                                unlink($originalimage);
                                          }
                                        }

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
                                        mobilesmall = null,
                                        mobilemedium = null,
                                        mobilestandard = null,
                                        mobilelarge = null,
                                        16by9_share = null,
                                        16by10_share = null,
                                        4by3_share = null,
                                        5by4_share = null,
                                        mobile_share = null
                                        WHERE id='$creation_id'";
                                        $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));



                                        //set moderated and safe for work
                                        $mysqlqueryb="UPDATE wallpapers SET moderated = 1, sfw=1, hq=1 WHERE id='$id'";
                                        $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));


                                        //add to category count
                                        $mysqlqueryf="SELECT * FROM category_links WHERE wallpaper_id='$id' ORDER BY id DESC";
                                        $resf=$dbconn->query($mysqlqueryf) or die(mysqli_error($dbconn));
                                        while($rowf=$resf->fetch_assoc()) {

                                          $cat_id=$rowf['category_id'];

                                          $mysqlqueryb="UPDATE category SET total=total+1 WHERE id='$cat_id'";
                                          $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                                        }



                                        //Notification for user
                                        $title = "Your wallpaper has been marked as High Quality";

                                        $themessage = '<p><img src="'. $thumb16by9  . '" /></p>';
                                        $themessage=$themessage .'<p>Your wallpaper is considered to be of high quality. This means that your wallpaper is now part the main archives for all Wallpaper Cropper visitors to find.</p>';
                                        $themessage=htmlspecialchars($themessage, ENT_QUOTES);


                                        $mysqlqueryz="INSERT INTO notifications SET user_id='$owner', title='$title', message='$themessage'";
                                        $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                                        $mysqlqueryx="UPDATE users SET notification=1 WHERE id='$owner'";
                                        $dbconn->query($mysqlqueryx) or die(mysqli_error($dbconn));



                              }

                              $location = "Location: " . $base_url . "/moderate/";
                              header($location);
                              exit();












                            } else if ($typeb == "sfwlq") {


                                        $mysqlquery="SELECT * FROM wallpapers WHERE id='$typea' ORDER BY id DESC LIMIT 1";
                                        $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                                        while($row=$res->fetch_assoc()) {
                                                  $id = $row['id'];
                                                  $owner = $row['owner'];

                                                  $thumb16by9 = $row['16by9thumb'];
                                                  $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);

                                                  $creation_id = $row['creation_id'];


                                                  //get rid of original file
                                                  $mysqlqueryc="SELECT * FROM wall_generation WHERE id='$creation_id' ORDER BY id DESC LIMIT 1";
                                                  $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
                                                  while($rowc=$resc->fetch_assoc()) {
                                                    $originalimage = $rowc['imagefile'];
                                                    if(file_exists($originalimage)){
                                                          unlink($originalimage);
                                                    }
                                                  }

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
                                                  WHERE id='$creation_id'";
                                                  $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));


                                                  //set moderated and safe for work
                                                  $mysqlqueryb="UPDATE wallpapers SET moderated = 1, sfw=1, hq=0 WHERE id='$id'";
                                                  $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));


                                                  //Notification for user
                                                  $title = "Your wallpaper has been marked as Low Quality";

                                                  $themessage = '<p><img src="'. $thumb16by9  . '" /></p>';
                                                  $themessage=$themessage .'<p>Your wallpaper is considered to be of lower quality. This means that your wallpaper will not be part of the main archives.</p>';
                                                  $themessage=$themessage .'<p>We mark wallpapers as low quality if 1) the original image is of low visual quality, 2) your wallpaper didn\'t cater for enough higher resolution screens or 3)It\'s just not that great a wallpaper (sorry).</p>';
                                                  $themessage=$themessage .'<p>Your wallpaper is still part of your public profile and you are still able to share it outside of Wallpaper Cropper.</p>';
                                                  $themessage=htmlspecialchars($themessage, ENT_QUOTES);


                                                  $mysqlqueryz="INSERT INTO notifications SET user_id='$owner', title='$title', message='$themessage'";
                                                  $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                                                  $mysqlqueryx="UPDATE users SET notification=1 WHERE id='$owner'";
                                                  $dbconn->query($mysqlqueryx) or die(mysqli_error($dbconn));



                                        }

                                        $location = "Location: " . $base_url . "/moderate/";
                                        header($location);
                                        exit();




                                        } else if ($typeb == "nsfwhq") {

                                          $mysqlquery="SELECT * FROM wallpapers WHERE id='$typea' ORDER BY id DESC LIMIT 1";
                                          $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                                          while($row=$res->fetch_assoc()) {
                                                    $id = $row['id'];
                                                    $owner = $row['owner'];

                                                    $thumb16by9 = $row['16by9thumb'];
                                                    $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);

                                                    $creation_id = $row['creation_id'];


                                                    //get rid of original file
                                                    $mysqlqueryc="SELECT * FROM wall_generation WHERE id='$creation_id' ORDER BY id DESC LIMIT 1";
                                                    $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
                                                    while($rowc=$resc->fetch_assoc()) {
                                                      $originalimage = $rowc['imagefile'];
                                                      if(file_exists($originalimage)){
                                                            unlink($originalimage);
                                                      }
                                                    }

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
                                                    WHERE id='$creation_id'";
                                                    $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));



                                                    //set moderated and safe for work
                                                    $mysqlqueryb="UPDATE wallpapers SET moderated = 1, sfw=0, hq=1 WHERE id='$id'";
                                                    $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));


                                                    //add to category count
                                                    $mysqlqueryf="SELECT * FROM category_links WHERE wallpaper_id='$id' ORDER BY id DESC";
                                                    $resf=$dbconn->query($mysqlqueryf) or die(mysqli_error($dbconn));
                                                    while($rowf=$resf->fetch_assoc()) {

                                                      $cat_id=$rowf['category_id'];

                                                      $mysqlqueryb="UPDATE category SET nsfw_total=nsfw_total+1 WHERE id='$cat_id'";
                                                      $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));

                                                    }



                                                    //Notification for user
                                                    $title = "Your wallpaper has been marked as Not Safe For Work";

                                                    $themessage = '<p><img src="'. $thumb16by9  . '" /></p>';
                                                    $themessage=$themessage .'<p>Your wallpaper is considered to be of high quality but not safe for work.</p>';
                                                    $themessage=$themessage .'<p>Your wallpaper is still part of your public profile and you are able to share it, but it will only appear in our archives (Top Walls, Categories etc) for members who are logged in and have <strong>not \‘safe for work\’</strong> content enabled.</p>';
                                                    $themessage=htmlspecialchars($themessage, ENT_QUOTES);


                                                    $mysqlqueryz="INSERT INTO notifications SET user_id='$owner', title='$title', message='$themessage'";
                                                    $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                                                    $mysqlqueryx="UPDATE users SET notification=1 WHERE id='$owner'";
                                                    $dbconn->query($mysqlqueryx) or die(mysqli_error($dbconn));



                                                    $location = "Location: " . $base_url . "/moderate/";
                                                    header($location);
                                                    exit();


                                            }




                                        } else if ($typeb == "nsfwlq") {



                                          $mysqlquery="SELECT * FROM wallpapers WHERE id='$typea' ORDER BY id DESC LIMIT 1";
                                          $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                                          while($row=$res->fetch_assoc()) {
                                                    $id = $row['id'];
                                                    $owner = $row['owner'];

                                                    $thumb16by9 = $row['16by9thumb'];
                                                    $thumb16by9 = str_replace($php_base_directory, $base_url . "/", $thumb16by9);

                                                    $creation_id = $row['creation_id'];


                                                    //get rid of original file
                                                    $mysqlqueryc="SELECT * FROM wall_generation WHERE id='$creation_id' ORDER BY id DESC LIMIT 1";
                                                    $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
                                                    while($rowc=$resc->fetch_assoc()) {
                                                      $originalimage = $rowc['imagefile'];
                                                      if(file_exists($originalimage)){
                                                            unlink($originalimage);
                                                      }
                                                    }

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
                                                    WHERE id='$creation_id'";
                                                    $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));


                                                    //set moderated and safe for work
                                                    $mysqlqueryb="UPDATE wallpapers SET moderated = 1, sfw=0, hq=0 WHERE id='$id'";
                                                    $dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));


                                                    //Notification for user
                                                    $title = "Your wallpaper has been marked as Low Quality and Not Safe For Work";

                                                    $themessage = '<p><img src="'. $thumb16by9  . '" /></p>';
                                                    $themessage=$themessage .'<p>wallpaper is considered to be of low quality and not safe for work.</p>';
                                                    $themessage=$themessage .'<p>Your wallpaper is still part of your public profile and you are able to share it, but it will only appear in our archives (Top Walls, Categories etc) for members who are logged in and have <strong>not \‘safe for work\’</strong> content enabled.</p>';
                                                    $themessage=$themessage .'<p>Your wallpaper is still part of your public profile and you are still able to share it outside of Wallpaper Cropper but it won\’t appear in our internal archives (Top Walls, Categories etc).</p>';
                                                    $themessage=$themessage .'<p>We mark wallpapers as low quality if 1) the original image is of low visual quality, 2) your wallpaper didn\'t cater for enough higher resolution screens or 3) it\'s just not that great (sorry).</p>';
                                                    $themessage=htmlspecialchars($themessage, ENT_QUOTES);

                                                    $mysqlqueryz="INSERT INTO notifications SET user_id='$owner', title='$title', message='$themessage'";
                                                    $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                                                    $mysqlqueryx="UPDATE users SET notification=1 WHERE id='$owner'";
                                                    $dbconn->query($mysqlqueryx) or die(mysqli_error($dbconn));


                                                    $location = "Location: " . $base_url . "/moderate/";
                                                    header($location);
                                                    exit();


                                        }





                    } else {
                      $location = "Location: " . $base_url;
                      header($location);
                      exit();
                    }


        }

}?>
