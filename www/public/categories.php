<?php
$pagetitle = "Wallpaper Cropper Categories";
$pagedescription = "Browse our wide range of wallpaper categories";
$fullscreena=1;
$fullscreenb=1;
$mainoptions=1;
include($php_base_directory . 'includes/header.php');
?>

<section id="fullscreen-b">
<?php include($php_base_directory . 'ads/topad.php'); ?>
  <div class="full-site-container">
    <h1 class="header-index"><?php echo $pagetitle; ?></h1>
    <div class="wallpaper-thumb-container-index">
      <?php
      $res = $db->sql( "SELECT * FROM category ORDER BY cat_name ASC" );
      while($row=$res->fetch_assoc()) {

        $showcat = 0;
        $cat_id = $row['id'];

        if ($row['total']==0 && $row['nsfw_total']==0){$showcat = 0;}
        if ($row['nsfw_total']>0 && $nsfw == 1 ){$showcat = 1;}
        if ($row['total']>0){$showcat = 1;}

        if ($showcat == 1) {

          $array16by9thumb = array();
          $array16by10thumb = array();
          $array4by3thumb = array();
          $array5by4thumb = array();
          $arraymobilethumb = array();

          $resx = $db->sql( "SELECT * FROM category_links WHERE category_id = ? ORDER BY id DESC LIMIT 100", 'i' , $cat_id );
          while($rowx=$resx->fetch_assoc()) {

                  $wall_id=$rowx['wallpaper_id'];
                  $total = $row['total'];

                  $resz = $db->sql( "SELECT * FROM wallpapers WHERE id = ? AND sfw='1' ORDER BY id DESC LIMIT 1", 'i' , $wall_id );
                  while($rowz=$resz->fetch_assoc()) {

                    $array16by9thumb[] = $rowz['16by9thumb'];
                    $array16by10thumb[] = $rowz['16by10thumb'];
                    $array4by3thumb[] = $rowz['4by3thumb'];
                    $array5by4thumb[] = $rowz['5by4thumb'];
                    $arraymobilethumb[] = $rowz['mobilethumb'];

                    if($total<2){
                      $array16by9thumb[] = $rowz['16by9thumb'];
                      $array16by10thumb[] = $rowz['16by10thumb'];
                      $array4by3thumb[] = $rowz['4by3thumb'];
                      $array5by4thumb[] = $rowz['5by4thumb'];
                      $arraymobilethumb[] = $rowz['mobilethumb'];
                    }

                  }
            }

                  if ($defaultratio == "16by9"){
                    $rand_keys = array_rand($array16by9thumb, 2);
                    $thumb = $array16by9thumb[$rand_keys[0]];
                  }
             else if ($defaultratio == "16by10"){
               $rand_keys = array_rand($array16by10thumb, 2);
               $thumb = $array16by10thumb[$rand_keys[0]];
             }
             else if ($defaultratio == "4by3"){
               $rand_keys = array_rand($array4by3thumb, 2);
               $thumb = $array4by3thumb[$rand_keys[0]];
             }
             else if ($defaultratio == "5by4"){
               $rand_keys = array_rand($array5by4thumb, 2);
               $thumb = $array5by4thumb[$rand_keys[0]];
             }
             else if ($defaultratio == "mobile"){
               $rand_keys = array_rand($arraymobilethumb, 2);
               $thumb = $arraymobilethumb[$rand_keys[0]];
             }
             else {
               if ($mobile==1){
                 $rand_keys = array_rand($arraymobilethumb, 2);
                 $thumb = $arraymobilethumb[$rand_keys[0]];
               }
                       else {
                         $rand_keys = array_rand($array16by9thumb, 2);
                         $thumb = $array16by9thumb[$rand_keys[0]];
                       }
             }

             $thumb = str_replace($php_base_directory,$static_url."/",$thumb);


        ?>

        <div class="wall-box-index">
          <div class="wall-box-inner-index">
            <a class="walllink" href="<?php echo $base_url; ?>/category/<?php echo $row['slug']; ?>/"><img class="wall-box-image-index" src="<?php echo $thumb; ?>" />
              <span class="walltitle"><?php echo $row['cat_name']; ?><br /><small>(<?php
              if ($nsfw == 1) {echo $row['total'] + $row['nsfw_total'];} else {echo $row['total'];}
              ?> Wallpapers)</small></span>
            </a>
          </div>
        </div>

      <?php $firstlink=0; }} ?>



    </div>
  </div>
</section>

<?php include($php_base_directory . 'includes/footer.php');?>
