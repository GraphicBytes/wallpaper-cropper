<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('config/globals.php');
include_once('config/db.php');
include_once('config/known_bots.php');
include_once('version.php');
include_once('functions/login-check.php');
include_once('functions/bgfetch.php');
include_once('functions/mobiledetect.php');
include_once('functions/track_user.php');
include_once('functions/log_malicious.php');
include_once('functions/bot_check.php');
include_once('functions/is_malicious.php');
include_once('functions/system_data.php');
include_once('functions/cache.php');

$is_user_a_bot = bot_check();
$track_this = 0;
$is_malicious = is_malicious();

$system_data = system_data();

// check if mobile
$detect = new Mobile_Detect;
if ($detect->isMobile() && !$detect->isTablet()) {
  $mobile = 1;
} else {
  $mobile = 0;
}

$bgimage = bgfetch();

$logged_in_id = login_check();


ob_start();

$requestURI = $_SERVER['REQUEST_URI'];
$path = parse_url($requestURI, PHP_URL_PATH);

if ($path == "" || $path == null || $path == "/") {
  $path = "/home/";
}

if ($logged_in_id == 0) {

  $cache = new cache();

  $cache_data = $cache->get_cache($path, $mobile);
  if ($cache_data !== false) {
    if ($env == 1) {
      echo $cache_data;
      echo "<!-- cached -->";
      exit();
      die();
    }
  }
}



$set_cache = false;


$nsfw = 0;
$resfilter = null;
$defaultratio = "16by9";
$notification = 0;

$font = "'Mukta Mahee', Arial, Helvetica, sans-serif";

$red = "#f00";

$green = "#88db1c";
$whitetransparent = "rgba(255,255,255,0)";

$black = "rgba(0,0,0,1)";
$blackfaded = "rgba(0,0,0,0.9)";

$white = "rgba(255,255,255,1)";
$whitefaded = "rgba(255,255,255,0.95)";
$whitemorefaded = "rgba(255,255,255,0.7)";

$blue = "#3a7bd5";
$bluefaded = "rgba(58, 123, 213, 0.85)";

$lightblue = "#5a92ef";
$lightbluefaded = "rgba(90, 146, 239, 0.85)";

$bgcolour = "rgba(225, 225, 225, 1)";
$bgcolourfaded = "rgba(238, 238, 238, 0.95)";

$grey = "#e2e2e2";
$darkergrey = "#d4d4d4";

$loadingcss = 0;
$jcrop = 0;
$pagenate = 0;
$selectize = 0;
$fullscreena = 0;
$fullscreenb = 0;
$fullscreencolumn = 0;
$multiheader = 0;
$mainoptions = 0;
$signup = 0;
$classic = 0;
$formfields = 0;
$codes = 0;
$viewwall = 0;
$homepromo = 0;

if ($logged_in_id > 0) {
  $mysqlquery = "SELECT * FROM users WHERE id='$logged_in_id' LIMIT 1";
  $res = $db->sql("SELECT * FROM users WHERE id=? LIMIT 1", 'i', $logged_in_id);
  while ($row = $res->fetch_assoc()) {
    $defaultratio = $row['defaultratio'];
    $resfilter = $row['resfilter'];
    $nsfw = $row['nsfw'];
    $notification = $row['notification'];
    $avatar_mini = $static_url . "/avatars/" . $row['avatar_mini'];
  }
}

$page = null;
$typea = null;
$typeb = null;
$typec = null;
$typed = null;
$loadingneeded = 0;
$cropneeded = 0;
$selectizeneeded = 0;
$filter = null;

$prefix = null;
$postfix = null;

//default title
$pagetitle = "Wallpaper Maker - Create &amp; Share Backgrounds for Iphone, Android &amp; Desktop";

//default description
$pagedescription = "Create wallpapers &amp; backgrounds for mobile, tablet &amp; desktop devices. Simply upload or fetch an image to automatically crop and create desktop wallpapers and backgrounds at multiple aspect ratios and resolutions.";

//default title
$pagekeywords = "Mobile Wallpapers, Android Wallpapers, iPhone Wallpapers, Desktop Wallpapers, Desktop Backgrounds, Photo Cropping, Image Editing, aspect ratio, 4k, full HD, 16 by 9, 16 by 10";

if (isset($_GET['page'])) {
  $page = $_GET['page'];
}
if (isset($_GET['typea'])) {
  $typea = $_GET['typea'];
}
if (isset($_GET['typeb'])) {
  $typeb = $_GET['typeb'];
}
if (isset($_GET['typec'])) {
  $typec = $_GET['typec'];
}
if (isset($_GET['typed'])) {
  $typed = $_GET['typed'];
}

// buffer to minimise
ob_start();



//HOME PAGE
if ($page == "cron-qdGtD7hPkEPzppQa") {
  include($php_base_directory . 'crons/cron_master.php');
}






//HOME PAGE
else if ($page == null or $page == "start") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'home.php');
}

//PUBLIC
else if ($page == "profile") {
  $set_cache = true;
  $track_this = 1;
  include('functions/lastactive.php');
  include($php_base_directory . 'public/profile.php');
} else if ($page == "categories") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'public/categories.php');
} else if ($page == "collections") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'public/collections.php');
} else if ($page == "collection") {
  $set_cache = true;
  $loadingneeded = 1;
  $track_this = 1;
  include('functions/lastactive.php');
  include($php_base_directory . 'public/collection.php');
} else if ($page == "new-walls") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'public/new-walls.php');
} else if ($page == "top-walls") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'public/top-walls.php');
} else if ($page == "category") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'public/category.php');
} else if ($page == "tag") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'public/tag.php');
} else if ($page == "view-wall") {
  $set_cache = true;
  $track_this = 1;
  $loadingneeded = 1;
  $selectizeneeded = 1;
  include($php_base_directory . 'public/view-wall.php');
} else if ($page == "downloadwall") {
  $set_cache = true;
  $track_this = 1;
  include($php_base_directory . 'public/download-wall.php');
}






//MULTI-WALL PROCCESS
else if ($page == "createwall") {
  $track_this = 1;
  $loadingneeded = 1;
  include($php_base_directory . 'multiwall/createwall.php');
} else if ($page == "fetch") {
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/fetch.php');
} else if ($page == "16by9select") {
  $loadingneeded = 1;
  $cropneeded = 1;
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/16by9select.php');
} else if ($page == "16by9crop") {
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/16by9crop.php');
} else if ($page == "16by10select") {
  $loadingneeded = 1;
  $cropneeded = 1;
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/16by10select.php');
} else if ($page == "16by10crop") {
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/16by10crop.php');
} else if ($page == "4by3select") {
  $loadingneeded = 1;
  $cropneeded = 1;
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/4by3select.php');
} else if ($page == "4by3crop") {
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/4by3crop.php');
} else if ($page == "5by4select") {
  $loadingneeded = 1;
  $cropneeded = 1;
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/5by4select.php');
} else if ($page == "5by4crop") {
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/5by4crop.php');
} else if ($page == "mobileselect") {
  $loadingneeded = 1;
  $cropneeded = 1;
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/mobileselect.php');
} else if ($page == "mobilecrop") {
  include('functions/random_str.php');
  include($php_base_directory . 'multiwall/mobilecrop.php');
} else if ($page == "review") {
  $loadingneeded = 1;
  $selectizeneeded = 1;
  include($php_base_directory . 'multiwall/review.php');
} else if ($page == "submitwall") {
  include('functions/random_str.php');
  include('functions/slugify.php');
  include($php_base_directory . 'multiwall/submitwall.php');
} else if ($page == "edit-wall") {
  $loadingneeded = 1;
  $selectizeneeded = 1;
  include($php_base_directory . 'multiwall/editwall.php');
} else if ($page == "delete-multiwall") {
  include($php_base_directory . 'multiwall/delete-multiwall.php');
}





//Member Tools
else if ($page == "delete-wall") {
  include($php_base_directory . 'multiwall/deletewall.php');
} else if ($page == "update-wall") {
  include('functions/slugify.php');
  include($php_base_directory . 'multiwall/updatewall.php');
} else if ($page == "your-collections") {
  $loadingneeded = 1;
  include($php_base_directory . 'members/your-collections.php');
} else if ($page == "bookmarkwall") {
  include($php_base_directory . 'members/bookmarkwall.php');
} else if ($page == "likes") {
  include($php_base_directory . 'members/bookmarks.php');
}





//LOGIN AND PROFILE MANAGEMENT
else if ($page == "join-login") {
  $track_this = 1;
  include($php_base_directory . 'members/join-login.php');
} else if ($page == "update") {
  include('functions/slugify.php');
  include($php_base_directory . 'members/update.php');
} else if ($page == "settings") {
  $track_this = 1;
  include($php_base_directory . 'members/settings.php');
} else if ($page == "signup") {
  $track_this = 1;
  include($php_base_directory . 'members/signup.php');
} else if ($page == "signedup") {
  $track_this = 1;
  include($php_base_directory . 'members/signedup.php');
} else if ($page == "register") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/register.php');
} else if ($page == "signupvalidate") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/signupvalidate.php');
} else if ($page == "login") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/login.php');
} else if ($page == "logout") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/logout.php');
} else if ($page == "overview") {
  $track_this = 1;
  $loadingneeded = 1;
  include($php_base_directory . 'members/overview.php');
} else if ($page == "editprofile") {
  $track_this = 1;
  $loadingneeded = 1;
  include($php_base_directory . 'members/editprofile.php');
} else if ($page == "updateprofile") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/updateprofile.php');
} else if ($page == "notifications") {
  $track_this = 1;
  include($php_base_directory . 'members/notifications.php');
} else if ($page == "emailvalidate") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/emailvalidate.php');
} else if ($page == "profile-fetch") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/profile-fetch.php');
} else if ($page == "crop-profile") {
  $loadingneeded = 1;
  $cropneeded = 1;
  include('functions/random_str.php');
  include($php_base_directory . 'members/crop-profile.php');
} else if ($page == "profilephotosubmit") {
  include('functions/random_str.php');
  include($php_base_directory . 'members/profilephotosubmit.php');
}







//CLASSIC
else if ($page == "imagefetch") {
  include($php_base_directory . 'classic/imagefetch.php');
} else if ($page == "stage2") {
  $loadingneeded = 1;
  include($php_base_directory . 'classic/stage2.php');
} else if ($page == "prepwall") {
  include($php_base_directory . 'classic/prepwall.php');
} else if ($page == "stage3") {
  $loadingneeded = 1;
  $cropneeded = 1;
  include($php_base_directory . 'classic/stage3.php');
} else if ($page == "crop") {
  include($php_base_directory . 'classic/crop.php');
} else if ($page == "complete") {
  include($php_base_directory . 'classic/complete.php');
} else if ($page == "delete") {
  include($php_base_directory . 'classic/delete.php');
}




//ADMIN
else if ($page == "moderate") {
  $loadingneeded = 1;
  $selectizeneeded = 1;
  include($php_base_directory . 'admin/moderate.php');
}



//ADMIN
else if ($page == "approve") {
  include('functions/slugify.php');
  include($php_base_directory . 'admin/approve.php');
} else if ($page == "noapprove") {
  include($php_base_directory . 'admin/delete.php');
} else if ($page == "hashtest") {
  include($php_base_directory . 'hashtest.php');
}



//PAGES
else if ($page == "privacy") {
  $track_this = 1;
  include($php_base_directory . 'pages/privacy.php');
} else {
  log_malicious();
  $location = "Location: " . $base_url;
  header($location);
  exit();
}


if ($track_this == 1 & $logged_in_id != 1) {
  track_user();
}


$output = ob_get_clean();
$output = preg_replace('/<!--.*?-->/', '', $output);
$output = preg_replace('/>\s+</', '><', $output);
$output = preg_replace('/\s+/', ' ', $output);
$output = preg_replace('/\s+>/', '>', $output);
$output = preg_replace('/<\s+/', '<', $output);


if ($logged_in_id == 0) {
  if ($set_cache == true) {
    $cache->set_cache($path, $mobile, $output);
  }
}

echo $output;
exit();
