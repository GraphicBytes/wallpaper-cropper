<div id="mobile-menu">
  <div id="inner-mobile-menu">
    <div class="mobile-link">
      <h2>MAIN MENU</h2>
      <a href="<?php echo $base_url; ?>">HOME</a>
      <?php if ($logged_in_id == 0) { ?>
        <a href="<?php echo $base_url; ?>">CREATE WALLPAPER</a>
      <?php } else { ?>
        <a href="<?php echo $base_url; ?>/createwall/">CREATE WALLPAPER</a>
      <?php } ?>
      <a href="<?php echo $base_url; ?>/categories/">CATEGORIES</a>
      <!-- <a href="<?php echo $base_url; ?>/collections/">COLLECTIONS</a> -->
      <a href="<?php echo $base_url; ?>/new-walls/">NEW WALLPAPERS</a>
      <a href="<?php echo $base_url; ?>/top-walls/">TOP WALLPAPERS</a>

      <h2>SITE</h2>

      <?php if ($logged_in_id == 0) { ?>
        <a href="<?php echo $base_url; ?>/join-login/">SIGN IN</a>
      <?php } else { ?>
        <?php if ($logged_in_id == 1) { ?><a href="<?php echo $base_url; ?>/moderate/">MODERATE WALLS</a><?php } ?>
        <a href="<?php echo $base_url; ?>/overview/">PROFILE</a>
        <a href="<?php echo $base_url; ?>/your-collections/">YOUR COLLECTIONS</a>
        <a href="<?php echo $base_url; ?>/likes/">YOUR LIKES</a>
        <a <?php if ($notification == 1) {
              echo 'class="checknotification"';
            } ?> href="<?php echo $base_url; ?>/notifications/">NOTIFICATIONS</a>
        <a href="<?php echo $base_url; ?>/settings/">SETTINGS</a>
        <a href="<?php echo $base_url; ?>/logout/">LOGOUT</a>
      <?php } ?>



      <!-- <h2>INFO</h2>

      <a href="<?php echo $base_url; ?>/">ABOUT US</a>
      <a href="<?php echo $base_url; ?>/">GENERAL TIPS</a>
      <a href="<?php echo $base_url; ?>/">CONTACT US</a>
      <a href="<?php echo $base_url; ?>/privacy/">PRIVACY</a>
      <a href="<?php echo $base_url; ?>/">DMCA</a> -->

    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo $base_url ?>/static/js/jquery.js?v=<?php echo $generator_v_num; ?>" defer=""></script>
<script type="text/javascript" src="<?php echo $base_url ?>/static/js/mobilemenu.js?v=<?php echo $generator_v_num; ?>" defer=""></script>
<?php if ($cropneeded == 1) { ?>
  <script type="text/javascript" src="<?php echo $base_url ?>/static/js/crop.js?v=<?php echo $generator_v_num; ?>" defer=""></script>
<?php } ?>
<?php if ($loadingneeded == 1) { ?>
  <script type="text/javascript" src="<?php echo $base_url ?>/static/js/loading.js?v=<?php echo $generator_v_num; ?>" defer=""></script>
<?php } ?> 
<?php if ($selectizeneeded == 1) { ?>
  <script type="text/javascript" src="<?php echo $base_url ?>/static/js/selectize.js?v=<?php echo $generator_v_num; ?>" defer=""></script>
<?php } ?>  

</body>

</html>