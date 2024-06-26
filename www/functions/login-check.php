<?php
function login_check(){

  global $dbconn;

  $loginphase = 0;

  $id = null;
  $cookie_id = null;
  $cookie_fail = null;
  $login_fail = null;

  //are cookies set
  if (isset($_COOKIE["wallpapercropper"])){
    $wallpapercropper_session_id = $dbconn->real_escape_string($_COOKIE['wallpapercropper']);
    $loginphase = $loginphase + 1;

    $mysqlquery="SELECT * FROM users WHERE cookie_id='$wallpapercropper_session_id' ORDER BY id DESC LIMIT 1";
    $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    while($row=$res->fetch_assoc()) {

      $id = $row['id'];
      $cookie_fail = $row['cookie_fail'];
      $login_fail = $row['login_fail'];
      $cookie_id = $row['cookie_id'];

      }
              if ($cookie_fail < 10 && $login_fail < 10){
                $time=time();
                if ($cookie_fail > 0) {
                  $mysqlquery="UPDATE users SET cookie_fail = 0, last_login='$time' WHERE id ='$id'";
                  $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                } else {
                  $mysqlquery="UPDATE users SET last_login='$time' WHERE id ='$id'";
                  $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
                }

                //looks good, carry on
                return $id;

              }else if($cookie_fail > 10 or $login_fail > 10){

                //Cookie missmatch or brute force attack, unset to spare DB load
                unset($_COOKIE['wallpapercropper']);
                setcookie('wallpapercropper', null, -1, '/');
                return 0;

              }else{
                //Missmatch, log to prevent brute force attack
                $mysqlquery="UPDATE users SET cookie_fail = cookie_fail + 1 WHERE id ='$id'";
                $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

                return 0;
              }

  } else {

//cookie error, move on
return 0;

  }

}
?>
