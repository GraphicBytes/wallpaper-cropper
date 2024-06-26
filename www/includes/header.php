<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <?php include($php_base_directory . 'includes/style.php'); ?>
  <title><?php echo $pagetitle; ?></title>
  <meta content="<?php echo $pagedescription; ?>" name="description" />
  <meta content="<?php echo $pagekeywords; ?>" name="keywords" />
  <?php include('config/authour-and-generator-meta.php'); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--[if lt IE 9]>
  <script src="<?php echo $static_url; ?>/static/html5shiv.js"></script>
<![endif]-->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $static_url; ?>/static/images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $static_url; ?>/static/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $static_url; ?>/static/images/favicon-16x16.png">
  <link rel="manifest" href="<?php echo $static_url; ?>/static/images/manifest.json">
  <link rel="mask-icon" href="<?php echo $static_url; ?>/static/images/safari-pinned-tab.svg" color="#3a7bd5">
  <meta name="theme-color" content="#3a7bd5">
</head>

<body style="background:url('<?php echo $bgimage; ?>'); background-repeat:no-repeat; background-size:cover; background-position:50% 50%; background-attachment: fixed;" <?php if ($page == "stage2") { ?> onload=" fillForm()" <?php } ?>>

  <?php include('includes/main-menu.php'); ?>