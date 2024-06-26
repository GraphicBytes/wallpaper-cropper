<?php

include($php_base_directory . 'config/smtp.php');
require $php_base_directory . 'functions/PHPMailer/src/Exception.php';
require $php_base_directory . 'functions/PHPMailer/src/PHPMailer.php';
require $php_base_directory . 'functions/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);


$res = $db->sql("SELECT * FROM users WHERE id=? ORDER BY id DESC LIMIT 1", 'i', $typea);
while ($row = $res->fetch_assoc()) {

  $email_validation_code = $row['email_validation_code'];
  $new_email = $row['new_email'];
  $validation_age = $row['validation_age'];
  $null_email = null;

  $display_name = $row['display_name'];
}

$new_string = random_str(10);
$validation_age = time() - $validation_age;

if ($email_validation_code == $typeb && $validation_age < 86400) {

  $db->sql("UPDATE users SET
        email=?, new_email=?, email_validation_code='$new_string', validation_age='0' WHERE id=?", 'ssi', $new_email, $null_email, $typea);

  setcookie("wallpapercropper_email", $new_email, time() + 31536000, "/");



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
  $mail->addAddress($new_email);


  $mail->isHTML(true);

  $themessage = '<table width="500" style="display:block; width:500px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
  $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:500px; display:block; margin:0 0 20px 0;" />';
  $themessage = $themessage . '<h1 style="color:#3a7bd5; font-weight:bold; font-size:20pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">THANK YOU, YOUR NEW EMAIL HAS BEEN VALIDATED </h1>';
  $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">You have successfully validated your new email address. You can now use it to log into Wallpaper Cropper.</p>';
  $themessage = $themessage . '</th></tr></table>';

  $mail->Subject = "Wallpaper Cropper New Email Verified";
  $mail->Body = $themessage;
  $mail->AltBody = 'You have successfully validated your new email address. You can now use it to log into Wallpaper Cropper.';

  if (!$mail->send()) {
  }




  $location = "Location: " . $base_url . "/editprofile/emailupdated/";
} else {

  $location = "Location: " . $base_url;
}

header($location);
exit();
