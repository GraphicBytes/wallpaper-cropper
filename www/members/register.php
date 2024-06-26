<?php
if ($is_malicious == 1) {
    log_malicious();
    $location = "Location: " . $base_url;
    header($location);
    exit();
}




include($php_base_directory . 'config/smtp.php');
require $php_base_directory . 'functions/PHPMailer/src/Exception.php';
require $php_base_directory . 'functions/PHPMailer/src/PHPMailer.php';
require $php_base_directory . 'functions/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);


$display_name = $_POST['display_name'];
$email = $_POST['email'];
$passworda = $_POST['passworda'];
$passwordb = $_POST['passwordb'];
session_start();
$_SESSION['display_name'] = $display_name;
$_SESSION['email'] = $email;










if ($display_name === null || $display_name == "") {
    $_SESSION['no_display_name'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}

if ($email === null || $email == "") {
    $_SESSION['email_check'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}













//Check banned email providers
$email_host_check = 1;
$res = $db->sql("SELECT * FROM bad_mail_hosts ORDER BY id ASC");
while ($row = $res->fetch_assoc()) {

    $badhost = $row['host'];
    $badmessage = $row['message'];

    if (str_contains($email, $badhost)) {
        $email_host_check = 0;
        $email_host_message = $badmessage;
    }
 
}



//Check duplicate display name
$display_name_check = 0;
$res = $db->sql("SELECT * FROM users WHERE display_name=? ORDER BY id DESC LIMIT 1", 's', $display_name);
while ($row = $res->fetch_assoc()) {
    $display_name_check = 1;
}


//Check valid email
$email_check = 0;
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_check = 1;
}


//Check duplicate email
$duplicate_email_check = 0;
$res = $db->sql("SELECT * FROM users WHERE email=? OR new_email=? ORDER BY id DESC LIMIT 1", 'ss', $email, $email);
while ($row = $res->fetch_assoc()) {
    $duplicate_email_check = 1;
}


//Check password length
$passwordlength = strlen($passworda);


//Check passwords match
if ($passworda == $passwordb) {
    $password_match = 0;
} else {
    $password_match = 1;
}


//check user isn't useing banned host
if ($email_host_check == 0) {
    $_SESSION['banned_email_host'] = 1;
    $_SESSION['banned_email_host_msg'] = $email_host_message;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//check user has a display name set
if ($display_name == "") {
    $_SESSION['no_display_name'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//check if display name already exists
else if ($display_name_check == 1) {
    $_SESSION['displayname_taken'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//check if email is valid
else if ($email_check == 1) {
    $_SESSION['email_check'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//check if email is duplicate
else if ($duplicate_email_check == 1) {
    $_SESSION['email_duplicate'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//check if password is set
else if ($passworda == "") {
    $_SESSION['no_password'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//check if password is long enough
else if ($passwordlength < 7) {
    $_SESSION['passwordlength'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//check if passwords match
else if ($password_match == 1) {
    $_SESSION['passwordmatch'] = 1;
    $location = "Location: " . $base_url . "/signup/";
    log_malicious();
    header($location);
    exit();
}


//double check all is good
else if ($password_match == 0 && $passwordlength > 7 && $duplicate_email_check == 0 && $email_check == 0 && $display_name_check == 0) {

    $thepassword = hash('sha256', $passworda . $websitesalt);

    $email_validation_code = random_str(50);
    $cookie_id = random_str(100);
    $time = time();

    $db->sql("INSERT INTO users SET email=?, email_verfied = 0, email_validation_code=?, validation_age=?, password=?, account_type = 1, display_name=?, cookie_id=?", 'ssisss', $email, $email_validation_code, $time, $thepassword, $display_name, $cookie_id);

    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = $smtp_host;
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = $smtp_ssltype;
    $mail->Port = $smtp_port;
    // $mail->SMTPOptions = array(
    //     'ssl' => array(
    //         'verify_peer' => false,
    //         'verify_peer_name' => false,
    //         'allow_self_signed' => true
    //     )
    // );

    $mail->setFrom($smtp_from, $smtp_fromname);
    $mail->addAddress($email);

    $mail->isHTML(true);

    $themessage = '<table width="500" style="display:block; width:500px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
    $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:500px; display:block; margin:0 0 20px 0;" />';
    $themessage = $themessage . '<h1 style="color:#3a7bd5; font-weight:bold; font-size:20pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">PLEASE VALIDATE YOUR EMAIL</h1>';
    $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">You have requested sign up to Wallpaper Cropper using this Email address. Please follow the link to validate your email and finalise your sign up.</p>';
    $themessage = $themessage . '<a href="' . $base_url . '/signupvalidate/' . $email_validation_code . '/" style="color:#3a7bd5; font-weight:normal; text-decoration:none; font-size:12pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">CLICK HERE TO VERIFY EMAIL</a>';
    $themessage = $themessage . '<p style="color:#080705; font-weight:normal; font-size:10pt; display:block; width:100%; text-align:center; padding:0 0 0 0; margin:0 0 20px 0;">The verification URL will only be valid for 48 hours, after that you will need to start this process again.</p>';
    $themessage = $themessage . '</th></tr></table>';

    $mail->Subject = "Please validate your email for your Wallpaper Cropper sign up";
    $mail->Body = $themessage;
    $mail->AltBody = 'You have requested sign up to Wallpaper Cropper using this Email address. Please follow the link to validate your email and finalise your sign up. Please visit this URL to validate your new Email and finish your requested change: ' . $base_url . '/signupvalidate/' . $email_validation_code . '/';

    if (!$mail->send()) {
    }


    $location = "Location: " . $base_url . "/signedup/";
    header($location);
    exit();
}


//WTF
else {
    log_malicious();
    $location = "Location: " . $base_url . "/signup/";
    header($location);
    exit();
}

