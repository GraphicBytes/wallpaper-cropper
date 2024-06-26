<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else { ?>

  <?php
  $pagetitle = "Wallpaper Cropper - Create A Public Wallpaper";
  $loadingcss = 1;
  $fullscreena = 1;
  $mainoptions = 1;
  $formfields = 1;
  include($php_base_directory . 'includes/header.php');
  ?>


  <section id="fullscreen-flex" class="droppable">
    <div class="main-options-container">



      <?php
      $res = $db->sql("SELECT * FROM users WHERE id=? ORDER BY id DESC LIMIT 1", 'i', $logged_in_id);
      while ($row = $res->fetch_assoc()) { ?>


        <div class="small-container <?php if ($row['tutorial_seen'] == 0) {
                                      echo "larger";
                                    } ?>">

          <h1 class="header-index">CREATE A WALLPAPER</h1>

          <div class="fullscreen-container">

            <?php if (isset($_GET['typea'])) {
              $typea = $_GET['typea']; ?>
              <?php if ($typea == "nothingset") { ?>
                <p class="errormessage">ERROR: NO FILE OR URL</p>
              <?php } ?>
              <?php if ($typea == "invalidfetch") { ?>
                <p class="errormessage">There was an error fetching the image from the URL you entered, please try again.</p>
              <?php } ?>
              <?php if ($typea == "filetoobig") { ?>
                <p class="errormessage">The file you tried to upload/fetch was too large. The max file size accepted is 5MB</p>
              <?php } ?>
              <?php if ($typea == "deleted") { ?>
                <p class="errormessage">Your image has been deleted from our server</p>
              <?php } ?>
              <?php if ($typea == "invalidimagetype") { ?>
                <p class="errormessage">Invalid file type!!!</p>
              <?php } ?>
              <?php if ($typea == "noaccount") { ?>
                <p class="errormessage">That Email address is invalid or unverified. The account may also be locked, who knows?</p>
              <?php } ?>
              <?php if ($typea == "passwordfail") { ?>
                <p class="errormessage">Incorrect password used</p>
              <?php } ?>
              <?php if ($typea == "nowsignedup") { ?>
                <p class="errormessage">You are signed up, you can now log in with your Email and Password</p>
              <?php } ?>
            <?php } ?>
















            <?php if ($row['tutorial_seen'] == 0) { ?>

              <div class="tutorial">
                <h1 style="border-bottom:none;">Hi, this looks like your first time!</h1>

                <p style="border-bottom:none; text-align:left;">You’re about to create a wallpaper to post onto the Wallpaper Cropper website. Here is a rundown of what you’ll be asked to do:</p>

                <p style="border-bottom:none; text-align:left;">1) First you need to upload or provide an image URL to fetch.</p>
                <p style="border-bottom:none; text-align:left;">2) You will then be asked to make crops of your image at 5 different aspect ratios.</p>
                <p style="border-bottom:none; text-align:left;">3) Using your image crops our system will generate as many wallpapers as we can at various sizes.</p>

                <p style="border-bottom:none; text-align:left;">Once completed your wallpaper will be available for other visitors of Wallpaper Cropper to download.</p>

                <p style="border-bottom:none; text-align:left;">Forum and HTML codes will also be provided to post your wallpaper wherever you want.</p>

                <p>Please bear in mind that we do moderate each wallpaper for quality. If we feel like there wasn’t a genuine effort to create a high-quality wallpaper or any of the crops look out of place, we may redo the crops, exclude it from our public archive or remove it.</p>

                <p><strong>We do accept wallpapers that include nudity</strong>. You will still be able to share such wallpapers via HTML and BBCodes but they will be excluded from our wallpaper index unless the user is logged in they have turned on <strong>Not Safe For Work content</strong>.</p>

              </div>

            <?php  } else { ?>



            <?php  } ?>



            <div class="main-options">
              <form method="post" action="<?php echo $base_url; ?>/fetch/" enctype="multipart/form-data" name="imagechoice" id="imagechoice">

                <label for="file_url">Option 1: Input image URL</label>
                <input class="form-field" placeholder="http://" type="text" name="file_url" id="file_url">

                <label for="file">Option 2: Upload An Image</label>
                <div class="form-field" id="uploadfile" onclick="getFile()">click to upload a file</div>
                <div style='height: 0px; width: 0px;overflow:hidden;'>
                  <input id="files" type="file" name="files" onchange="sub(this)" accept='image/*' data-max-size="5120" />
                  <input id="draggedfiles" type="file" name="draggedfiles" accept='image/*' data-max-size="5120" />
                </div>

                <h5>.JPG .PNG and .GIF - 10MB max</h5>

                <p id="output_message" class="errormessage"></p>

                <div class="output"></div>

                <input class="submit" id="submit" type="submit" value="Submit &amp; Continue To The First Crop" onclick="loading();" />
              </form>


              <?php
              $titleneeded = 1;
              $resz = $db->sql("SELECT * FROM wall_generation WHERE owner=? AND complete='0' ORDER BY id ASC", 'i', $logged_in_id);
              while ($rowz = $resz->fetch_assoc()) {
                $id = $rowz['id'];
                $createtime = $rowz['create_time'];
                $epoch = $createtime;

                $cropa = $rowz['16by9_recrop'];
                $cropb = $rowz['16by10_recrop'];
                $cropc = $rowz['4by3_recrop'];
                $cropd = $rowz['5by4_recrop'];
                $crope = $rowz['mobile_recrop'];
                $reviewed = $rowz['reviewed'];

                $todo = "review";
                if ($cropa == 0) {
                  $todo = "16by9select";
                } else if ($cropb == 0) {
                  $todo = "16by10select";
                } else if ($cropc == 0) {
                  $todo = "4by3select";
                } else if ($cropd == 0) {
                  $todo = "5by4select";
                } else if ($crope == 0) {
                  $todo = "mobileselect";
                } else if ($reviewed == 0) {
                  $todo = "review";
                }


                date_default_timezone_set('GMT');
              ?>

                <?php if ($titleneeded == 1) { ?><h4>You have incomplete wallpapers</h4><?php } ?>

                <a class="incompletewall" href="<?php echo $base_url; ?>/<?php echo $todo; ?>/<?php echo $id; ?>/">Complete wallpaper started on <?php echo date('d-m-Y', $epoch); ?> at <?php echo date('H:i:s', $epoch); ?></a>


              <?php $titleneeded = $titleneeded + 1;
              } ?>
            </div>
          </div>
        </div>


      <?php } ?>

















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

        <h5 class="fetching">Fetching your image!</h5>
        <h5 class="loggingin">Logging In!</h5>
        <h6>This may take a while depending on connection speeds, please do not refresh the page.</h6>

      </div>
    </div>
  </div>



  <script>
    function loading_logingin() {
      $("#submit").hide();
      $(".fetching").hide();
      $("#loading").fadeIn("fast", function() {
        // Animation complete
      });
    }

    function loading() {
      $("#submit").hide();
      $(".loggingin").hide();
      $("#loading").fadeIn("fast", function() {
        // Animation complete
      });
    }
  </script>


  <script>
    $('#file_url').bind('input', function() {

      var img = new Image();
      img.onload = function() {

        var imgwidth = this.width;
        var imgheight = this.height;

        if (imgwidth < 2000) {
          document.getElementById('output_message').innerHTML = "THE IMAGE IS LOW RESOLUTION AND RESULTS WILL BE POOR";
          $(".preview").addClass("warning");
        } else if (imgheight < 1500) {
          document.getElementById('output_message').innerHTML = "THE IMAGE IS LOW RESOLUTION AND RESULTS WILL BE POOR";
          $(".preview").addClass("warning");
        }


      }
      img.src = $(this).val();

    });


    function getFile() {
      document.getElementById("files").click();
    }

    function sub(obj) {
      var file = obj.value;
      var fileName = file.split("\\");
      event.preventDefault();
    }

    function handleFileSelect(evt) {
      var files = evt.target.files; // FileList object
      // files is a FileList of File objects. List some properties.
      var output = [];
      for (var i = 0, f; f = files[i]; i++) {
        if (f.size > 10000000) {
          document.getElementById('output_message').innerHTML = "WARNING: FILE SELECTED IS OVER 10MB";
          output.push('WARNING: FILE SELECTED IS OVER 10MB');
        } else {
          output.push(escape(f.name), ' - ', Math.round((f.size / 10000000) * 100) / 100, 'MB\'s');
        }
      }
      document.getElementById("uploadfile").innerHTML = output.join('');

      var output = document.querySelector('.output');
      output.innerHTML = '';
      for (var i = 0; i < files.length; i++) {
        if (files[i].type.indexOf('image/') === 0) {
          output.innerHTML += '<img class="preview" src="' + URL.createObjectURL(files[i]) + '" />';

          document.getElementById('output_message').innerHTML = "";
          $(".preview").removeClass("warning");


          if (files[i].size > 10000000) {
            document.getElementById('output_message').innerHTML = "WARNING: FILE SELECTED IS OVER 10MB";
            $(".preview").addClass("warning");
          }


          var _URL = window.URL || window.webkitURL;
          var file, img;
          if ((file = this.files[0])) {
            img = new Image();
            img.onload = function() {
              var imgwidth = this.width;
              var imgheight = this.height;

              if (imgwidth < 2000) {
                document.getElementById('output_message').innerHTML = "THE IMAGE IS LOW RESOLUTION AND RESULTS WILL BE POOR";
                $(".preview").addClass("warning");
              } else if (imgheight < 1500) {
                document.getElementById('output_message').innerHTML = "THE IMAGE IS LOW RESOLUTION AND RESULTS WILL BE POOR";
                $(".preview").addClass("warning");
              }

            };
            img.onerror = function() {
              alert("not a valid file: " + file.type);
            };
            img.src = _URL.createObjectURL(file);
          }


        }
      }

    }
    document.getElementById('files').addEventListener('change', handleFileSelect, false);
  </script>

  <script>
    (function(window) {
      function triggerCallback(e, callback) {
        if (!callback || typeof callback !== 'function') {
          return;
        }
        var files;
        if (e.dataTransfer) {
          files = e.dataTransfer.files;
        } else if (e.target) {
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
        for (var i = 0; i < files.length; i++) {
          if (files[i].type.indexOf('image/') === 0) {

            document.getElementById('output_message').innerHTML = "";
            $(".preview").removeClass("warning");


            output.innerHTML += '<img class="preview" src="' + URL.createObjectURL(files[i]) + '" />';
            var fileInput = document.getElementById("draggedfiles");
            fileInput.files = files;

            if (files[i].size > 10000000) {
              document.getElementById('output_message').innerHTML = "WARNING: FILE SELECTED IS OVER 10MB";
              $(".preview").addClass("warning");
            } else {
              document.getElementById('output_message').innerHTML = "";
            }


            var _URL = window.URL || window.webkitURL;
            var file, img;
            if ((file = document.getElementById('draggedfiles').files[0])) {
              img = new Image();
              img.onload = function() {
                var imgwidth = this.width;
                var imgheight = this.height;

                if (imgwidth < 2000) {
                  document.getElementById('output_message').innerHTML = "THE IMAGE IS LOW RESOLUTION AND RESULTS WILL BE POOR";
                  $(".preview").addClass("warning");
                } else if (imgheight < 1500) {
                  document.getElementById('output_message').innerHTML = "THE IMAGE IS LOW RESOLUTION AND RESULTS WILL BE POOR";
                  $(".preview").addClass("warning");
                }

              };
              img.onerror = function() {
                alert("not a valid file: " + file.type);
              };
              img.src = _URL.createObjectURL(file);
            }


          }
          document.getElementById("uploadfile").innerHTML = files[i].name;


        }
      });
    })(this);
  </script>

  <?php include($php_base_directory . 'includes/footer.php'); ?>
<?php } ?>