<?php
$pagetitle = "Wallpaper Cropper Categories";
include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-b" >
<?php include($php_base_directory . 'ads/topad.php'); ?>
  <div class="full-site-container">
    <div class="wallpaper-thumb-container-index">

      <?php
      $firstlink=1;
      $res = $db->sql( "SELECT * FROM category ORDER BY cat_name ASC");
      while($row=$res->fetch_assoc()) {
        $showcat = 0;

        if ($row['total']==0 && $row['nsfw_total']==0){$showcat = 0;}
        if ($row['nsfw_total']>0 && $nsfw == 1 ){$showcat = 1;}
        if ($row['total']>0){$showcat = 1;}

        if ($showcat == 1) {
        ?>

              <a class="cat-link" href="<?php echo $base_url; ?>/category/<?php echo $row['slug']; ?>/"><?php echo $row['cat_name']; ?><small>(<?php

              if ($nsfw == 1) {echo $row['total'] + $row['nsfw_total'];} else {echo $row['total'];}

              ?> Wallpapers)</small></a>

      <?php $firstlink=0; }} ?>

    </div>
  </div>
</section>

<?php include($php_base_directory . 'includes/footer.php');?>
