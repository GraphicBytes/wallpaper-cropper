<?php
if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $mysqlqueryx="UPDATE users SET notification=0 WHERE id='$logged_in_id'";
  $dbconn->query($mysqlqueryx) or die(mysqli_error($dbconn));

  $notification = 0;

  ?>

      <?php
      $pagetitle = "Your Notifications";
      $pagenate = 1;
      $mainoptions=1;
      $fullscreenb=1;
      include($php_base_directory . 'includes/header.php');
      ?>

      <section id="fullscreen-flex">
        <div class="main-options-container-b">

          <h1 class="header-index-b"><?php echo $pagetitle; ?></h1>

          <div class="fullscreen-container-b">

              <?php
              $mysqlquery="SELECT * FROM notifications WHERE user_id='$logged_in_id' ORDER BY id DESC";
              $total = $dbconn->query($mysqlquery);
              $total = $total->num_rows;
              $limit = 25;
              $pages = ceil($total / $limit);

              $page = $typea;
              if ($page == null) {$page = 1;}
              $offset = ($page - 1)  * $limit;



              $notificationcount = 0;
              $mysqlquery="SELECT * FROM notifications WHERE user_id='$logged_in_id' ORDER BY id DESC LIMIT 25 OFFSET $offset";
              $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
              while($row=$res->fetch_assoc()) {
                $message_id=$row['id'];
                $header=$row['title'];
                $message=$row['message'];
                $viewed=$row['viewed'];
                $thedate=$row['thedate'];
                $thedate=date("F j, Y g:i a", strtotime($thedate));
              ?>
              <div class="notification-block notification-block-<?php echo $notificationcount; ?> <?php if($viewed==0){echo "unread";} ?>" onclick="openmessage(<?php echo $notificationcount; ?>, <?php echo $message_id; ?>)">
                <div class="notification-bar">
                  <h1 class="notification-header"><?php echo $header; ?></h1>
                  <h2 class="notification-date"><?php echo $thedate; ?></h2>
                </div>
                <div class="notification-message message-<?php echo $notificationcount; ?>" style="display:none;">
                  <?php echo htmlspecialchars_decode($message); ?>
                </div>
              </div>

              <?php $notificationcount = $notificationcount+1; } ?>

              <?php if($notificationcount==0){?><p style="display:block; text-align:center; width:100%;">You have no notifications</p><?php } ?>

              <div class="notificationspacer"></div>

              <div class="pagenavi1">
                <?php $prefix="notifications"; include('includes/pagenate.php'); ?>
              </div>

              <div id="feedback"></div>

            </div>
        </div>
      </section>

      <script>
      function openmessage(e, message_id){
        var notificationblock = ".notification-block-" + e;
        var toopen = ".message-" + e;

        $(notificationblock).removeClass("unread");

        $(".currentnotification").slideToggle( "fast", function() {});
        $(".currentnotification").removeClass("currentnotification");
        $(toopen).slideToggle( "fast", function() {});
        $(toopen).addClass("currentnotification");

        var url = "<?php echo $base_url ?>/update/notificationread/" + message_id +"/"
        $("#feedback").load(url);

      }
      </script>

      <?php include($php_base_directory . 'includes/footer.php');?>
<?php }?>
