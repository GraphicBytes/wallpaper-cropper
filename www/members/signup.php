<?php
session_start();
$pagetitle = "Wallpaper Cropper - Sign Up";
$loadingcss = 1;
$fullscreena = 1;
$mainoptions = 1;
$formfields = 1;
include($php_base_directory . 'includes/header.php');

$display_name = "";
$email = "";

$no_display_name = 0;
$displayname_taken = 0;
$email_check = 0;
$email_duplicate = 0;
$no_password = 0;
$passwordlength = 0;
$passwordmatch = 0;
$bannedhost = 0;

if (isset($_SESSION['display_name'])) {
  $display_name = $_SESSION['display_name'];
}
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
}

if (isset($_SESSION['no_display_name'])) {
  $no_display_name = $_SESSION['no_display_name'];
  $_SESSION['no_display_name'] = 0;
}
if (isset($_SESSION['displayname_taken'])) {
  $displayname_taken = $_SESSION['displayname_taken'];
  $_SESSION['displayname_taken'] = 0;
}
if (isset($_SESSION['email_check'])) {
  $email_check = $_SESSION['email_check'];
  $_SESSION['email_check'] = 0;
}
if (isset($_SESSION['email_duplicate'])) {
  $email_duplicate = $_SESSION['email_duplicate'];
  $_SESSION['email_duplicate'] = 0;
}
if (isset($_SESSION['no_password'])) {
  $no_password = $_SESSION['no_password'];
  $_SESSION['no_password'] = 0;
}
if (isset($_SESSION['passwordlength'])) {
  $passwordlength = $_SESSION['passwordlength'];
  $_SESSION['passwordlength'] = 0;
}
if (isset($_SESSION['passwordmatch'])) {
  $passwordmatch = $_SESSION['passwordmatch'];
  $_SESSION['passwordmatch'] = 0;
}
if (isset($_SESSION['banned_email_host'])) {
  $bannedhost = $_SESSION['banned_email_host'];
  $_SESSION['banned_email_host'] = 0;
}
?>
?>

<section id="fullscreen-flex" >
  <div class="main-options-container">
    <div class="small-container">

      <h1 class="header-index">SIGN UP AND START BUILDING YOUR OWN WALLPAPER COLLECTION ddd</h1>

      <div class="fullscreen-container">

        <?php if ($no_display_name == 1) { ?><p class="errormessage">You need to set a Display Name</p><?php } ?>
        <?php if ($displayname_taken == 1) { ?><p class="errormessage">That Display Name is taken, select another!</p><?php } ?>
        <?php if ($email_check == 1) { ?><p class="errormessage">Please enter a valid Email Address!</p><?php } ?>
        <?php if ($email_duplicate == 1) { ?><p class="errormessage">That email address is in use, please select another</p><?php } ?>
        <?php if ($no_password == 1) { ?><p class="errormessage">Please enter a password</p><?php } ?>
        <?php if ($passwordlength == 1) { ?><p class="errormessage">Password must be 8 characters or more</p><?php } ?>
        <?php if ($passwordmatch == 1) { ?><p class="errormessage">Your passwords didn't match, please try again</p><?php } ?>
        <?php if ($bannedhost == 1) { ?><p class="errormessage"><?php echo $_SESSION['banned_email_host_msg'] ?></p><?php } ?>

        <form method="post" action="<?php echo $base_url; ?>/register/" enctype="multipart/form-data">

          <label for="display_name">Display Name</label>
          <input class="form-field" value="<?php echo $display_name; ?>" type="text" name="display_name">

          <label for="email">Email</label>
          <input class="form-field" value="<?php echo $email; ?>" type="text" name="email">

          <label for="website">Password (Minimum 8 characters)</label>
          <input class="form-field" value="" type="password" name="passworda">

          <label for="website">Repeat Password</label>
          <input class="form-field" value="" type="password" name="passwordb">


          <input class="submit" id="submit" type="submit" value="Sign Up" onclick="loading();" />
        </form>

      </div>
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

      <h5>Registering your details!</h5>
      <h6>This may take a while depending on connection speeds, please do not refresh the page.</h6>

    </div>
  </div>
</div>


<script>
  function loading() {
    $("#submit").hide();
    $("#loading").fadeIn("fast", function() {
      // Animation complete
    });
  }
</script>

<?php include($php_base_directory . 'includes/footer.php'); ?>