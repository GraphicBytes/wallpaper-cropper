<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('../config/db.php');
include('../config/globals.php');
include('../functions/random_str.php');


// added in v4.0.0
require_once $php_base_directory . 'functions/facebook/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '557401134623246','34386d59d7374f0663707019b85ebf0e' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper($base_url . "/members/facebook.php");
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name


	/* ---- Session Variables -----*/
	    //echo $fbid;
      //echo $fbfullname;
    /* ---- header location after session ----*/


    $social_id = $fbid;
    $display_name = $fbfullname;

    //email_placer
    $salted_id = $social_id . $websitesalt;
    $email_placer = "facebook_" . hash('sha256', $salted_id);

    $password = $social_id;
    $time = time();


          $account_exists = 0;
          $mysqlquery="SELECT * FROM users WHERE email='$email_placer' AND password=$password ORDER BY id DESC LIMIT 1";
          $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
          while($row=$res->fetch_assoc()) {

            $cookie_id = $row['cookie_id'];
            if($cookie_id == null){$cookie_id = random_str(100);}

            $user_id = $row['id'];
            $user_email = $row['email'];
            $user_password = $row['password'];
            $login_fail = $row['login_fail'];

            $account_exists = 1;

          }


         if($account_exists == 1) {

           $mysqlquery="UPDATE users SET cookie_id='$cookie_id', cookie_age='$time', last_login='$time', login_fail ='0', cookie_fail='0' WHERE id='$user_id'";
           $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

           setcookie("wallpapercropper_id", $user_id, time()+31536000, "/");
           setcookie("wallpapercropper_email", $email_placer, time()+31536000, "/");
           setcookie("wallpapercropper_session_id", $cookie_id, time()+31536000, "/");

           $location = "Location: " . $base_url . "/overview/";
           header($location);
           exit();


           } else {


           //create account
           $email_validation_code = random_str(50);
           $cookie_id = random_str(100);

           $mysqlquery="INSERT INTO users SET
           email='$email_placer',
           email_verfied = 1,
           email_validation_code='$email_validation_code',
           validation_age='$time',
           password='$password',
           account_type = 2,
           display_name='$display_name',
           cookie_id='$cookie_id',
           cookie_age='$time',
           last_login='$time'";
           $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

             $mysqlqueryz="SELECT * FROM users WHERE email='$email_placer' ORDER BY id DESC LIMIT 1";
             $resz=$dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));
             while($rowz=$resz->fetch_assoc()) {

               $idz = $rowz['id'];

               setcookie("wallpapercropper_id", $idz, time()+31536000, "/");
               setcookie("wallpapercropper_email", $email_placer, time()+31536000, "/");
               setcookie("wallpapercropper_session_id", $cookie_id, time()+31536000, "/");


               $location = "Location: " . $base_url . "/editprofile/newuser/";
               header($location);
               exit();

              }


          }




















} else {
  $loginUrl = $helper->getLoginUrl();
 header("Location: ".$loginUrl);
}









?>
