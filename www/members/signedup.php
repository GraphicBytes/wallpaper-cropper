<?php
$pagetitle = "Wallpaper Cropper - Signed Up, please check your email";
$mainoptions=1;
include($php_base_directory . 'includes/header.php');


?>

<section id="fullscreen-flex" class="droppable" style="background:url('<?php echo bgfetch($static_url, $mobile,$dbhost,$dbuser,$dbpw,$dbname); ?>'); background-repeat:no-repeat; background-size:cover; background-position:50% 50%; background-attachment: fixed;">
  <div class="main-options-container">
    <div class="fullscreen-container-b">

          <h1 style="border-bottom:none; margin:15px 0 0 0;">Please check your email to complete your sign-up</h1>

          </div>
        </div>
</section>


      <?php include($php_base_directory . 'includes/footer.php');?>
