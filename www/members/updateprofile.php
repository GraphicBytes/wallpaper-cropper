<?php

include($php_base_directory . 'config/smtp.php');
require $php_base_directory . 'functions/PHPMailer/src/Exception.php';
require $php_base_directory . 'functions/PHPMailer/src/PHPMailer.php';
require $php_base_directory . 'functions/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);


if ($logged_in_id == 0) {
  $location = "Location: " . $base_url;
  log_malicious();
  header($location);
  exit();
} else {

  $res = $db->sql("SELECT * FROM users WHERE id=? ORDER BY id DESC LIMIT 1", 'i', $logged_in_id);
  while ($row = $res->fetch_assoc()) {

    if ($row['account_type'] == 1) {

      $currentemail = htmlspecialchars($row['email'], ENT_QUOTES);
      $newemail = htmlspecialchars($_POST['email'], ENT_QUOTES);
    } else {

      $newemail = $row['email'];
    }




    //Check valid email
    if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
      $newemail = "";
    }


    if ($newemail == $currentemail) {
    } else {
      //Check duplicate email
      $res = $db->sql("SELECT * FROM users WHERE email=? OR new_email=? ORDER BY id DESC LIMIT 1", 'ss', $newemail, $newemail);
      while ($row = $res->fetch_assoc()) {
        $newemail = "";
        $passworderror = 1;
        $passworderrortype = "emailinuse";

        $location = "Location: " . $base_url . "/editprofile/" . $passworderrortype . "/";
        log_malicious();
        header($location);
        exit();
      }
    }



    $password = $row['password'];

    $display_name = htmlspecialchars($_POST['display_name'], ENT_QUOTES);
    $bio = htmlspecialchars($_POST['bio'], ENT_QUOTES);
    $facebook = htmlspecialchars($_POST['facebook'], ENT_QUOTES);
    $twitter = htmlspecialchars($_POST['twitter'], ENT_QUOTES);
    $website = htmlspecialchars($_POST['website'], ENT_QUOTES);

    if (strpos($facebook, 'facebook') !== false) {
    } else {
      $facebook = null;
    }

    if (strpos($twitter, 'twitter') !== false) {
    } else {
      $twitter = null;
    }



    if ($display_name === null) {
      $display_name = "";
    }
    if ($bio === null) {
      $bio = "";
    }
    if ($facebook === null) {
      $facebook = "";
    }
    if ($twitter === null) {
      $twitter = "";
    }
    if ($website === null) {
      $website = "";
    }
    if ($logged_in_id === null) {
      $logged_in_id = "";
    }


    //update trivial stuff
    $db->sql("UPDATE users SET display_name=?, bio=?, facebook_url=?, twitter=?, website_url=? WHERE id=?", 'sssssi', $display_name, $bio, $facebook, $twitter, $website, $logged_in_id);


    if ($newemail == $currentemail) {
    } else {

      $email_validation_code = random_str(50);
      $validation_age = time();

      $db->sql("UPDATE users SET new_email=?, email_validation_code=?, validation_age=? WHERE id=?", 'ssii', $newemail, $email_validation_code, $validation_age, $logged_in_id);

      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = $smtp_host;
      $mail->SMTPAuth = true;
      $mail->Username = $smtp_username;
      $mail->Password = $smtp_password;
      $mail->SMTPSecure = $smtp_ssltype;
      $mail->Port = $smtp_port;
      // $mail->SMTPOptions = array(
      //   'ssl' => array(
      //     'verify_peer' => false,
      //     'verify_peer_name' => false,
      //     'allow_self_signed' => true
      //   )
      // );

      $mail->setFrom($smtp_from, $smtp_fromname);
      $mail->addAddress($newemail);

      $mail->isHTML(true);

      $themessage = '<table width="500" style="display:block; width:500px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
      $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:500px; display:block; margin:0 0 20px 0;" />';
      $themessage = $themessage . '<h1 style="color:#3a7bd5; font-weight:bold; font-size:20pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">PLEASE VALIDATE YOUR NEW EMAIL</h1>';
      $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">You have requested an Email address change on your Wallpaper Cropper profile. Please visit the link below to validate your new Email address and finish your requested change.</p>';
      $themessage = $themessage . '<a href="' . $base_url . '/emailvalidate/' . $logged_in_id .  '/' . $email_validation_code . '/" style="color:#3a7bd5; font-weight:normal; text-decoration:none; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">CLICK HERE TO VERIFY EMAIL</a>';
      $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:10pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">The verification URL will only be valid for 24 hours, after that you will need to start this process again.</p>';
      $themessage = $themessage . '</th></tr></table>';

      $mail->Subject = "Wallpaper Cropper Profile Email Change";
      $mail->Body = $themessage;
      $mail->AltBody = 'You have requested an Email address change on your Wallpaper Cropper profile. Please visit this URL to validate your new Email and finish your requested change: ' . $base_url . '/emailvalidate/' . $logged_in_id .  '/' . $email_validation_code . '/';

      if (!$mail->send()) {
      }
    }


    $passworda = $_POST['passworda'];
    $passwordb = $_POST['passwordb'];
    $passworderror = 0;
    if ($passworda == "") {
    } else {

      //do passwords match
      if ($passworda == $passwordb) {

        $passwordlength = strlen($passworda);
        //is it 8 characters or more
        if ($passwordlength > 7) {

          $newpassword = hash('sha256', $passworda . $websitesalt);

          $cookie_id = random_str(100);
          $time = time();

          $db->sql("UPDATE users SET password=?, cookie_id=?, cookie_age=?  WHERE id=?", 'ssii', $newpassword, $cookie_id, $time, $logged_in_id);

          unset($_COOKIE['wallpapercropper_id']);
          unset($_COOKIE['wallpapercropper_email']);
          unset($_COOKIE['wallpapercropper_session_id']);
          setcookie('wallpapercropper_id', null, -1, '/');
          setcookie('wallpapercropper_email', null, -1, '/');
          setcookie('wallpapercropper_session_id', null, -1, '/');



          $mail->SMTPDebug = 0;
          $mail->isSMTP();
          $mail->Host = $smtp_host;
          $mail->SMTPAuth = true;
          $mail->Username = $smtp_username;
          $mail->Password = $smtp_password;
          $mail->SMTPSecure = $smtp_ssltype;
          $mail->Port = $smtp_port;
          // $mail->SMTPOptions = array(
          //   'ssl' => array(
          //     'verify_peer' => false,
          //     'verify_peer_name' => false,
          //     'allow_self_signed' => true
          //   )
          // );

          $mail->setFrom($smtp_from, $smtp_fromname);
          $mail->addAddress($newemail);

          $mail->isHTML(true);

          $themessage = '<table width="500" style="display:block; width:500px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
          $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:500px; display:block; margin:0 0 20px 0;" />';
          $themessage = $themessage . '<h1 style="color:#3a7bd5; font-weight:bold; font-size:20pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">PASSWORD CHANGE</h1>';
          $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">Your Wallpaper Cropper password has been changed successfully.</p>';
          $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">You have been logged out of all sessions and will need to log back in with your new password.</p>';
          $themessage = $themessage . '</th></tr></table>';

          $mail->Subject = "Wallpaper Cropper Password Changed";
          $mail->Body = $themessage;
          $mail->AltBody = 'Your Wallpaper Cropper password has been changed successfully. You have been logged out of all sessions and will need to log back in with your new password.';

          if (!$mail->send()) {
          }
        } else {
          $passworderror = 1;
          $passworderrortype = "passlengherror";
        }
      } else {
        $passworderror = 1;
        $passworderrortype = "passwordmissmatch";
      }
    }
  }


  if ($passworderror == 1) {
    log_malicious();
    $location = "Location: " . $base_url . "/editprofile/" . $passworderrortype . "/";
  } else {
    $location = "Location: " . $base_url . "/editprofile/updated/";
  }

  header($location);
  exit();
}
