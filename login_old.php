<!DOCTYPE html>
<?php
if(isset($_SESSION))
{

}
else
{
session_start();//session starts here
}


?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/lo_user_old.css">
</head>

<body>
    <?php include "pagelayout/navbar.php" ?>
    <div id="div_jum">
        <div class="login-card"><img src="assets/img/avatar_2x.png" class="profile-img-card">
            <p class="profile-name-card">Sign In to Book Appointment</p>
            <form class="form-signin" method="post" action="login.php"><span class="reauth-email"> </span>
                <!-- <input class="form-control" type="text" required="" placeholder="Email address" autofocus="" id="inputEmail"> -->
                <input class="form-control" type="text" required="" placeholder="Email address" autofocus="" name="username" id="username">
                <input class="form-control" type="password" required="" placeholder="Password" name="pass" id="pass">
                <div class="checkbox">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">Remember me</label>
                    </div>
                </div>
                <button name="login" id="login" class="btn btn-primary btn-block btn-lg btn-signin" type="submit">Sign in</button>
            </form><a href="#" class="forgot-password">Forgot your password?</a></div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
<?php

include("dbconfig/dbconfig.php");

if(isset($_POST['login']))
{
    $username=$_POST['username'];
    $user_pass=$_POST['pass'];

    $check_user="select * from users WHERE user_name='$username'AND user_pass='$user_pass'";
	//printf($check_user);
    $run=mysqli_query($db_handle,$check_user);


    if(mysqli_num_rows($run))
    {
      if($cdrow=mysqli_fetch_array($run,MYSQLI_ASSOC))
      {
        $_SESSION['user_name'] =$cdrow['user_name'];
        $_SESSION['profile_pic_path'] =$cdrow['profile_pic_path'];
        $user_email =$cdrow['user_email'];
        $_SESSION['email']=$user_email;//here session is used and value of $user_email store in $_SESSION.
        $strtemp = generateRandomString().",".$user_email.",".generateRandomString();
        $_SESSION['email_key']=base64_encode($strtemp);
      }
        echo "<script>alert('login Successed')</script>";
      
		
		//session_start();//session starts here
		 echo "<script>window.open('index.php','_self')</script>";



    }
    else
    {
      echo "<script>alert('Email or password is incorrect!')</script>";
    }
}

if(isset($_POST['signup']))
{
  header("Location: signup.php");
}
?>
<?php
function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
?>
