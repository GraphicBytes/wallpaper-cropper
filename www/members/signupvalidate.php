<?php

include($php_base_directory . 'config/smtp.php');
require $php_base_directory . 'functions/PHPMailer/src/Exception.php';
require $php_base_directory . 'functions/PHPMailer/src/PHPMailer.php';
require $php_base_directory . 'functions/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail2 = new PHPMailer(true);


$validation_age = time() - 172800;

$email_verified = 0;

$res = $db->sql("SELECT * FROM users WHERE email_validation_code=? AND validation_age > ? ORDER BY id DESC LIMIT 1", 'si', $typea, $validation_age);
while ($row = $res->fetch_assoc()) {

  $display_name = $row['display_name'];
  $email = $row['email'];

  $user_id = $row['id'];
  $email_verified = 1;
}



if ($email_verified == 1) {

  $db->sql("UPDATE users SET email_verfied=1 WHERE id=?", 'i', $user_id);

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
  $mail->addAddress($email);

  $mail->isHTML(true);

  $themessage = '<table width="500" style="display:block; width:500px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
  $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:500px; display:block; margin:0 0 20px 0;" />';
  $themessage = $themessage . '<h1 style="color:#3a7bd5; font-weight:bold; font-size:20pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">THANK YOU, YOUR EMAIL HAS BEEN VALIDATED </h1>';
  $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">You have successfully validated your email address. You can now use it to log into Wallpaper Cropper.</p>';
  $themessage = $themessage . '</th></tr></table>';

  $mail->Subject = "Wallpaper Cropper Email Verified";
  $mail->Body = $themessage;
  $mail->AltBody = 'You have successfully validated your email address. You can now use it to log into Wallpaper Cropper.';

  if (!$mail->send()) {
  }

  $mail2->SMTPDebug = 0;
  $mail2->isSMTP();
  $mail2->Host = $smtp_host;
  $mail2->SMTPAuth = true;
  $mail2->Username = $smtp_username;
  $mail2->Password = $smtp_password;
  $mail2->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail2->Port = 465;
  $mail2->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );

  $mail2->setFrom($smtp_from, $smtp_fromname);
  $mail2->addAddress("kookynetwork@protonmail.com");

  $mail2->isHTML(true);

  $themessage = '<table width="500" style="display:block; width:500px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
  $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:500px; display:block; margin:0 0 20px 0;" />';
  $themessage = $themessage . '<h1 style="color:#3a7bd5; font-weight:bold; font-size:20pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">NEW USER </h1>';
  $themessage = $themessage . '</th></tr></table>';

  $mail2->Subject = "New Wallpaper Cropper User";
  $mail2->Body = $themessage;
  $mail2->AltBody = 'NEW USER.';

  if (!$mail2->send()) {
  }




  $location = "Location: " . $base_url . "/join-login/nowsignedup/";
} else {

  log_malicious();
  $location = "Location: " . $base_url;
}

header($location);
exit();
