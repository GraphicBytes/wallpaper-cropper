<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {


      $pagetitle = "Wallpaper Cropper - Your Overview";
      $loadingcss = 1;
      $pagenate = 1;
      $formfields=1;
      $fullscreena=1;
      $fullscreencolumn=1;
      include($php_base_directory . 'includes/header.php');
      ?>

<section id="fullscreen-b">
  <div class="responsive-container"></div>

    <div class="full-site-container">

        <div class="right-column">

          <h1 class="header-index"><?php echo $pagetitle; ?></h1>

          <div class="content">

              <div class="wallpaper-thumb-container">

                <div class="wallpaper-thumb-container-profile">

                      <?php
                      if ($typeb == "category") {

                        $rescat=$db->sql( "SELECT * FROM category WHERE slug=? ORDER BY id DESC LIMIT 1", 's' , $typec );
                        while($rowcat=$rescat->fetch_assoc()) {
                          $cat_id = $rowcat['id'];
                        }
                        $mysqlquery="SELECT * FROM category_links INNER JOIN wallpapers ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id=? AND wallpapers.owner=? ORDER BY wallpaper_id DESC";
                        $total = $db->sql( $mysqlquery, 'ii' , $cat_id, $logged_in_id );
                      } else if ($typeb == "tag") {

                        $restag=$db->sql( "SELECT * FROM tags WHERE slug=? ORDER BY id DESC LIMIT 1", 's' , $typec );
                        while($rowtag=$restag->fetch_assoc()) {
                          $tag_id = $rowtag['id'];
                      }
                        $mysqlquery="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id=? AND wallpapers.owner=? ORDER BY wallpaper_id DESC";
                        $total = $db->sql( $mysqlquery, 'ii' , $tag_id, $logged_in_id );
                      } else {
                        $mysqlquery="SELECT id FROM wallpapers WHERE owner=?";
                        $total = $db->sql( $mysqlquery, 'i' , $logged_in_id );
                      }



                      $total = $total->num_rows;
                      $limit = 18;
                      $pages = ceil($total / $limit);

                      $page = $typea;
                      if ($page == null) {$page = 1;}
                      $offset = ($page - 1)  * $limit;

                      ?>

                      <div class="pagenavi1">
                        <?php
                        if ($typeb == "category" or $typeb == "tag") {
                          $prefix="overview"; $postfix=$typeb . "/" . $typec .  "/" ; include('includes/pagenate.php');
                        } else {
                          $prefix="overview"; include('includes/pagenate.php');
                        }?>
                      </div>

                        <?php
                        if ($typeb == "category") {
                          $mysqlquery="SELECT * FROM category_links INNER JOIN wallpapers ON category_links.wallpaper_id = wallpapers.id WHERE category_links.category_id='$cat_id' AND wallpapers.owner='$logged_in_id' ORDER BY wallpaper_id DESC LIMIT $limit OFFSET $offset";
                        } else if ($typeb == "tag") {
                          $mysqlquery="SELECT * FROM tag_links INNER JOIN wallpapers ON tag_links.wallpaper_id = wallpapers.id WHERE tag_links.tag_id='$tag_id' AND wallpapers.owner='$logged_in_id' ORDER BY wallpaper_id DESC LIMIT $limit OFFSET $offset";
                        } else {
                          $mysqlquery="SELECT * FROM wallpapers WHERE owner='$logged_in_id' ORDER BY id DESC LIMIT $limit OFFSET $offset";
                        }

                        $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                        while($row=$res->fetch_assoc()) {

                                 if ($defaultratio == "16by9"){$thumb = $row['16by9thumb'];}
                            else if ($defaultratio == "16by10"){$thumb = $row['16by10thumb'];}
                            else if ($defaultratio == "4by3"){$thumb = $row['4by3thumb'];}
                            else if ($defaultratio == "5by4"){$thumb = $row['5by4thumb'];}
                            else if ($defaultratio == "mobile"){$thumb = $row['mobilethumb'];}
                            else {$thumb = $row['16by9thumb'];}

                            $thumb = str_replace($php_base_directory,$static_url."/",$thumb);

                          ?>

                          <div class="wall-box-profile">
                            <div class="wall-box-inner-profile">
                              <a class="walllink" href="<?php echo $base_url ?>/view-wall/<?php echo $row['id'];?>/"><img class="wall-box-image-profile" src="<?php echo $thumb; ?>" />
                              <?php if ($row['title'] == "" or $row['title'] == null ) {} else {?>
                                <span class="walltitle"><?php echo $row['title']; ?></span>
                              <?php } ?></a>
                            </div>
                          </div>

                        <?php $firstlink=0; } ?>

                        <div class="pagenavi2">
                          <?php $prefix="overview"; include('includes/pagenate.php'); ?>
                        </div>


                  </div>

              </div>

          </div>
        </div>


        <div class="left-column">
            <?php
            $mysqlquery="SELECT * FROM users WHERE id='$logged_in_id' ORDER BY id DESC LIMIT 1";
            $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
            while($row=$res->fetch_assoc()) {?>

              <div class="avatar">
                <img class="avatar-img" src="<?php echo $static_url; ?>/avatars/<?php echo $row['avatar']; ?>" alt="<?php echo $row['display_name']; ?>" />
                <a class="edit-profile" onclick="openprofileupdater()" >EDIT PROFILE PHOTO</a>

                <script>
                function openprofileupdater() {
                  $(".newphotoform").slideToggle('fast', function(){});
                }
                </script>

                <div class="newphotoform droppable" style="display:none;">
                  <form  method="post" action="<?php echo $base_url; ?>/profile-fetch/" enctype="multipart/form-data" name="imagechoice" id="imagechoice">

                    <label for="file">Select Image</label>
                    <div class="form-field" id="uploadfile" onclick="getFile()">click to upload a file</div>
                    <div style='height: 0px; width: 0px;overflow:hidden;'>
                      <input id="files" type="file" name="files" onchange="sub(this)" accept='image/*' data-max-size="5120" />
                      <input id="draggedfiles" type="file" name="draggedfiles" accept='image/*' data-max-size="5120" />
                    </div>

                    <input class="submit" id="submit" type="submit" value="Upload Photo" onclick="loading();" />

                    <h5>.JPG .PNG and .GIF - 10MB max</h5>

                    <div class="output"></div>

                  </form>
                </div>

                <a class="edit-profile" href="<?php echo $base_url; ?>/editprofile/">EDIT PROFILE</a>
              </div>

              <div class="profile">
                <h1><?php echo $row['display_name']; ?></h1>
                <p><?php echo $row['bio']; ?></p>

                <div class="profile-social">
                  <?php if ($row['facebook_url'] == ""){} else {?>
                  <a class="social-link" rel="nofollow" target="blank" href="<?php echo $row['facebook_url']; ?>" rel="nofollow"><img class="social-icon" src="<?php echo $static_url; ?>/static/images/facebook-icon.png" /></a>
                  <?php }; ?>

                  <?php if ($row['twitter'] == ""){} else {?>
                  <a class="social-link" rel="nofollow" target="blank" href="<?php echo $row['twitter']; ?>" rel="nofollow"><img class="social-icon" src="<?php echo $static_url; ?>/static/images/twitter-icon.png" /></a>
                  <?php }; ?>

                  <?php if ($row['website_url'] == ""){} else {?>
                  <a class="social-link" rel="nofollow" target="blank" href="<?php echo $row['website_url']; ?>" rel="nofollow"><img class="social-icon" src="<?php echo $static_url; ?>/static/images/web-icon.png" /></a>
                  <?php }; ?>

                </div>

              </div>


            <?php } ?>


            <div class="catsandtags">
                <h4>Filter by Category</h4>
                <select class="styled-select blue semi-square" id="catfilter">
                <option value="<?php echo $base_url; ?>/overview/">VIEW ALL</option>
                <?php
                $mysqlquery="SELECT * FROM category ORDER BY cat_name ASC";
                $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                while($row=$res->fetch_assoc()) {

                  $cat_id=$row['id'];
                  $showcat = 0;

                      $mysqlqueryb="SELECT * FROM category_links WHERE category_id='$cat_id' ORDER BY id ASC";
                      $resb=$dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
                      while($rowb=$resb->fetch_assoc()) {
                        $wallpaperid=$rowb['wallpaper_id'];

                            $mysqlqueryc="SELECT owner FROM wallpapers WHERE id='$wallpaperid' ORDER BY id ASC LIMIT 1";
                            $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
                            while($rowc=$resc->fetch_assoc()) {
                              if ($rowc['owner'] == $logged_in_id){$showcat = 1;}
                            }
                      }

                if($showcat == 1){ ?>
                <option value="<?php echo $base_url; ?>/overview/1/category/<?php echo $row['slug']; ?>/" <?php if($typec==$row['slug']){echo "selected";} ?>><?php echo $row['cat_name']; ?></option>
                <?php } } ?>
                </select>

            </div>


            <div class="catsandtags">
                <h4>Filter by Tag</h4>
                <select class="styled-select blue semi-square" id="tagfilter">
                <option value="<?php echo $base_url; ?>/overview/">VIEW ALL</option>
                <?php
                $mysqlquery="SELECT * FROM tags ORDER BY tag_name ASC";
                $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                while($row=$res->fetch_assoc()) {

                  $tag_id=$row['id'];
                  $showtag = 0;

                      $mysqlqueryb="SELECT * FROM tag_links WHERE tag_id='$tag_id' ORDER BY id ASC";
                      $resb=$dbconn->query($mysqlqueryb) or die(mysqli_error($dbconn));
                      while($rowb=$resb->fetch_assoc()) {
                        $wallpaperid=$rowb['wallpaper_id'];

                            $mysqlqueryc="SELECT owner FROM wallpapers WHERE id='$wallpaperid' ORDER BY id ASC LIMIT 1";
                            $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
                            while($rowc=$resc->fetch_assoc()) {
                              if ($rowc['owner'] == $logged_in_id){$showtag = 1;}
                            }
                      }

                if($showtag == 1){ ?>
                <option value="<?php echo $base_url; ?>/overview/1/tag/<?php echo $row['slug']; ?>/" <?php if($typec==$row['slug']){echo "selected";} ?>><?php echo ucwords($row['tag_name']); ?></option>
                <?php } } ?>
                </select>

            </div>



            <script>
            $(document).ready(function() {
                $('#catfilter').change(function() {
                    var url = this.value;
                    window.location.href = url;
                });
            });
            $(document).ready(function() {
                $('#tagfilter').change(function() {
                    var url = this.value;
                    window.location.href = url;
                });
            });
            </script>

        </div>

    </div>

</section>


<div id="loading" style="background:url('<?php echo $bgimage; ?>'); background-repeat:no-repeat; background-size:cover; background-position:50% 50%; background-attachment: fixed;">
  <div id="innerloading">
    <div class="loading-frame">
          <div class="sk-cube-grid">
            <div class="sk-cube sk-cube1"></div>
            <div class="sk-cube sk-cube2"></div>
            <div class="sk-cube sk-cube3"></div>
            <div class="sk-cube sk-cube4"></div>
            <div class="sk-cube sk-cube5"></div>
            <div class="sk-cube sk-cube6"></div>
            <div class="sk-cube sk-cube7"></div>
            <div class="sk-cube sk-cube8"></div>
            <div class="sk-cube sk-cube9"></div>
          </div>

          <h5>Uploading Photo Please Wait!</h5>
          <h6>This may take a while depending on connection speeds, please do not refresh the page.</h6>

    </div>
  </div>
</div>

<script>
function loading_logingin(){
  $( ".submit" ).hide();
  $( ".fetching" ).hide();
  $( "#loading" ).fadeIn( "fast", function() {
    // Animation complete
  });
}
function loading(){
  $( ".submit" ).hide();
  $( ".loggingin" ).hide();
  $( "#loading" ).fadeIn( "fast", function() {
    // Animation complete
  });
}

</script>


<script>
    function getFile(){
      document.getElementById("files").click();
    }

    function sub(obj){
       var file = obj.value;
       var fileName = file.split("\\");
          event.preventDefault();
    }

    function handleFileSelect(evt) {
      var files = evt.target.files; // FileList object
      // files is a FileList of File objects. List some properties.
      var output = [];
      for (var i = 0, f; f = files[i]; i++) {
      if(f.size > 10120000){
      output.push( 'WARNING: FILE SELECTED IS OVER 10MB');
      }else{
          output.push(escape(f.name), ' - ', Math.round((f.size / 1024000)*100)/100, 'MB\'s');
      }
      }
     document.getElementById("uploadfile").innerHTML = output.join('');

     var output = document.querySelector('.output');
     output.innerHTML = '';
     for(var i=0; i<files.length; i++) {
       if(files[i].type.indexOf('image/') === 0) {
         output.innerHTML += '<img class="preview2" src="' + URL.createObjectURL(files[i]) + '" />';
       }
       }

    }
    document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>

<script>
  (function(window) {
    function triggerCallback(e, callback) {
      if(!callback || typeof callback !== 'function') {
        return;
      }
      var files;
      if(e.dataTransfer) {
        files = e.dataTransfer.files;
      } else if(e.target) {
        files = e.target.files;
      }
      callback.call(null, files);
    }

    function makeDroppable(ele, callback) {
      var input = document.getElementById("draggedfiles");
      input.addEventListener('change', function(e) {
        triggerCallback(e, callback);
      });

      ele.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.add('dragover');
      });

      ele.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.remove('dragover');
      });

      ele.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.remove('dragover');

        triggerCallback(e, callback);

      });

    }
    window.makeDroppable = makeDroppable;
  })(this);
  (function(window) {
    makeDroppable(window.document.querySelector('.droppable'), function(files) {
      console.log(files);
      var output = document.querySelector('.output');
      output.innerHTML = '';
      for(var i=0; i<files.length; i++) {
        if(files[i].type.indexOf('image/') === 0) {
          output.innerHTML += '<img class="preview2" src="' + URL.createObjectURL(files[i]) + '" />';
          var fileInput = document.getElementById("draggedfiles");
          fileInput.files = files;
        }
        document.getElementById("uploadfile").innerHTML = files[i].name;
        }
    });
  })(this);
</script>

      <?php include($php_base_directory . 'includes/footer.php');?>
<?php }?>
