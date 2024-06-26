<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('../config/db.php');
include('../config/globals.php');
include('../functions/random_str.php');


 // Include config file and twitter PHP Library
 define('CONSUMER_KEY', 'VGK2BhfiPe8pOn6zfgXb9lIJe');
 define('CONSUMER_SECRET', 'i52gVPoKjrCs2XUVYMGbOu39weHwEp3INmdRmQUBVF2B1IaI4F');
 define('OAUTH_CALLBACK', 'https://wallpapercropper.com/members/twitter.php');

include_once($php_base_directory . 'functions/twitter/twitteroauth.php');



 	if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']){

 			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
 			$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
 			if($connection->http_code == '200')
 			{

 				$user_data = $connection->get('account/verify_credentials');
 				// $result = '<h1>Twiiter Profile Details </h1>';
 				// $result .= '<img src="'.$user_data['profile_image_url'].'">';
 				// $result .= '<br/>Twiiter ID : ' . $user_data['id'];
 				// $result .= '<br/>Name : ' . $user_data['name'];
 				// $result .= '<br/>Twiiter Handle : ' . $user_data['screen_name'];
 				// $result .= '<br/>Follower : ' . $user_data['followers_count'];
 				// $result .= '<br/>Follows : ' . $user_data['friends_count'];
 				// $result .= '<br/>Logout from <a href="logout.php?logout">Twiiter</a>';
        //          echo '<div>'.$result.'</div>';

                        $social_id = $user_data['id'];
                        $display_name = $user_data['screen_name'];

                        //email_placer
                        $salted_id = $social_id . $websitesalt;
                        $email_placer = "twitter_" . hash('sha256', $salted_id);

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
                                   // echo $idz;
                                   // echo "<br />";
                                   // echo $email_placer;
                                   // echo "<br />";
                                   // echo $cookie_id;
                                   header($location);
                                   exit();

                                  }


                              }



 			}else{
 			       die("error, try again later!");
 			}

 	}else{
    $location = "Location: " . $base_url;
    header($location);
    exit();
 	}
 ?>
