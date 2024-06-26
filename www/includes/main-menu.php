  <nav id="mainmenu">
    <div id="innernav">
      <div class="logo"></div>
      <div class="desktop">
        <a class="home-icon" href="<?php echo $base_url; ?>"></a>
        <?php if ($logged_in_id == 0) { ?>
          <a href="<?php echo $base_url; ?>">CREATE WALLPAPER</a>
        <?php } else { ?>
          <a href="<?php echo $base_url; ?>/createwall/">CREATE WALLPAPER</a>
        <?php } ?>
        <a href="<?php echo $base_url; ?>/categories/">CATEGORIES</a>
        <!-- <a href="<?php echo $base_url; ?>/collections/">COLLECTIONS</a> -->
        <a href="<?php echo $base_url; ?>/new-walls/">NEW WALLPAPERS</a>
        <a href="<?php echo $base_url; ?>/top-walls/">TOP WALLPAPERS</a>
        <!-- <ul class="infomenu">
        <li><div class="infoicon"></div>
          <ul>
            <li><a href="<?php echo $base_url; ?>/">ABOUT US</a></li>
            <li><a href="<?php echo $base_url; ?>/">GENERAL TIPS</a></li>
            <li><a href="<?php echo $base_url; ?>/">CONTACT US</a></li>
            <li><a href="<?php echo $base_url; ?>/privacy/">PRIVACY</a></li>
            <li><a href="<?php echo $base_url; ?>/">DMCA</a></li>
          </ul>
        </li>
      </ul> -->

        <?php if ($logged_in_id == 0) { ?>
          <?php if ($is_malicious == 0) { ?>
            <a href="<?php echo $base_url; ?>/join-login/">SIGN IN</a>
          <?php } ?>
        <?php } else { ?>
          <ul class="infomenu">
            <li>
              <div class="profile-icon" style="background:url('<?php echo $avatar_mini; ?>'); background-size:cover;"><?php if ($notification == 1) { ?><div class="notification-dot"></div><?php } ?></div>
              <ul>
                <li><?php if ($logged_in_id == 1) { ?><a href="<?php echo $base_url; ?>/moderate/">MODERATE WALLS</a><?php } ?></li>
                <li><a <?php if ($notification == 1) {
                          echo 'class="checknotification"';
                        } ?> href="<?php echo $base_url; ?>/notifications/">NOTIFICATIONS</a></li>
                <li><a href="<?php echo $base_url; ?>/overview/">PROFILE</a></li>
                <li><a href="<?php echo $base_url; ?>/your-collections/">YOUR COLLECTIONS</a></li>
                <li><a href="<?php echo $base_url; ?>/likes/">YOUR LIKES</a></li>
                <li><a href="<?php echo $base_url; ?>/settings/">SETTINGS</a></li>
                <li><a href="<?php echo $base_url; ?>/logout/">LOGOUT</a></li>
              </ul>

            </li>
          </ul>
        <?php } ?>

      </div>

      <div id="burger2">
        <button onclick="mobilemenu()" class="hamburger hamburger--spin" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </div>

    </div>
  </nav>