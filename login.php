<!DOCTYPE html>
<?php
include 'check_doctor.php';
if (isset($_SESSION)) {
    
} else {
    session_start(); //session starts here
    if (isset($_GET['role'])) {
        $_SESSION['role']=$_GET['role'];
    
}
else
{
 
include("dbconfig/dbconfig.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $user_pass = $_POST['pass'];
    $user_role = $_SESSION['role'];

    $check_user = "select * from users WHERE user_name='$username'AND user_pass='$user_pass' AND role='$user_role'";
    //printf($check_user);
    $run = mysqli_query($db_handle, $check_user);


    if (mysqli_num_rows($run)>0) {
        if ($cdrow = mysqli_fetch_array($run, MYSQLI_ASSOC)) {
            $_SESSION['user_name'] = $cdrow['user_name'];
            $_SESSION['profile_pic_path'] = $cdrow['profile_pic_path'];
            $user_email = $cdrow['user_email'];
            $_SESSION['role'] = $user_role ;
            if(isset($user_email))
            {
            $_SESSION['email'] = $user_email; //here session is used and value of $user_email store in $_SESSION.
            $strtemp = generateRandomString() . "," . $user_email . "," . generateRandomString();
            $_SESSION['email_key'] = base64_encode($strtemp);
            }
            else{
                 $_SESSION['email'] = "GUEST";
                 $strtemp = generateRandomString() . "," . $user_email . "," . generateRandomString();
            $_SESSION['email_key'] = base64_encode($strtemp);
            }
            $_SESSION['loginMode'] = "hms";
        }
        echo "<script>alert('login Successed')</script>";

if($user_role=="CUSTOMER")
{
    //Customer login
        echo "<script>window.open('index.php','_self')</script>";

}
else{
    //Customer login
    $isExist = checkDoctorExist($_SESSION['email_key']);
    if($isExist=="Y")
    {
      //  echo 'isExist : '.$isExist;
      echo "<script>window.open('my_account.php','_self')</script>";
    }
    else
    {
       //echo 'isExist : '.$isExist;
     echo "<script>window.open('welcome.php','_self')</script>";
    }
    
        
}
        
    } else {
        echo "<script>alert('Credentials or role is incorrect!')</script>";
         echo "<script>window.open('login.php?role=$user_role','_self')</script>";
    }
}
else if (isset($_POST['signup'])) {
    header("Location: signup.php");
}
else{

    
     header("Location: index.php");//redirect to login page to secure the welcome page without login access.
}
}
}
?>

<?php
//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'gpUser.php';

if (isset($_GET['code'])) {
    
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    //Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();

    //Initialize User class
    $user = new User();

    //Insert or update user data to the database
    $gpUserData = array(
        'oauth_provider' => 'google',
        'oauth_uid' => $gpUserProfile['id'],
        'first_name' => $gpUserProfile['given_name'],
        'last_name' => $gpUserProfile['family_name'],
        'email' => $gpUserProfile['email'],
        //'gender'        => $gpUserProfile['gender'],
        'locale' => $gpUserProfile['locale'],
        'picture' => $gpUserProfile['picture'],
            //'link'          => $gpUserProfile['link']
    );
    $userData = $user->checkUser($gpUserData);

    //Storing user data into session

    $_SESSION['loginMode'] = "google";
    //echo $_SESSION['userData'] ;
    echo $_SESSION['loginMode'];
    //Render facebook profile data
    if (!empty($userData)) {
        $output = '<h1>Google+ Profile Details </h1>';
        $output .= '<img src="' . $userData['picture'] . '" width="300" height="220">';
        $output .= '<br/>Google ID : ' . $userData['oauth_uid'];
        $output .= '<br/>Name : ' . $userData['first_name'] . ' ' . $userData['last_name'];
        $output .= '<br/>Email : ' . $userData['email'];
        $output .= '<br/>Gender : ' . $userData['gender'];
        $output .= '<br/>Locale : ' . $userData['locale'];
        $output .= '<br/>Logged in with : Google';
        $_SESSION['email'] = $userData['email'];
        $user_email = $userData['email'];
        $strtemp = generateRandomString() . "," . $user_email . "," . generateRandomString();
        $_SESSION['email_key'] = base64_encode($strtemp);
        // $output .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Google+ Page</a>';
        $output .= '<br/>Logout from <a href="logout.php">Google</a>';
        echo "<script>alert('login Successed')</script>";
if($user_role=="CUSTOMER")
{
    //Customer login
        echo "<script>window.open('index.php','_self')</script>";
}
else{
    //Customer login
        echo "<script>window.open('welcome.php','_self')</script>";
}
    } else {
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
         echo "<script>alert('Some problem occurred, please try again.')</script>";
         echo "<script>window.open('index.php','_self')</script>";
    }
} else {
    $authUrl = $gClient->createAuthUrl();
    $output = '<a href="' . filter_var($authUrl, FILTER_SANITIZE_URL) . '"><img height="80px;" src="assets/img/glogin.png" alt=""/></a>';
}
?>


<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="assets/css/lo_user.css">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    </head>

    <body>

        <div class="middlePage">
            <div class="page-header col-lg-10">
                <h2 class="logo">Centres of Excellence <small>Welcome to our place! <br>Combining the best specialists and equipment to provide you nothing short of the best in healthcare.</small></h2>
            </div>

            <div class="panel panel-info col-sm-5 col-sm-offset-4">
                <div class="panel-heading col-lg-12">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body col-lg-12">

                    <div class="row">

                        <div class="col-md-5" >
                            <?php echo $output; ?>

                        </div>

                        <div class="col-md-7 login_formpanel" style="">
                            <form class="form-horizontal" method="post" action="login.php">
                                <fieldset>

                                    <input id="textinput" name="username" id="username" type="text" placeholder="Enter User Name" class="form-control input-md">
                                    <div class="spacing"><input type="checkbox" name="checkboxes" id="checkboxes-0" value="1"><small> Remember me</small></div>
                                    <input id="textinput" name="pass" id="pass" type="password" placeholder="Enter Password" class="form-control input-md">
                                    <div class="spacing"><a href="#"><small> Forgot Password?</small></a><br/></div>
                                    <button name="login" id="login" class="btn btn-info btn-sm pull-right">Sign In</button>


                                </fieldset>
                            </form>
                        </div>
                        <p><a href="https://github.com/sadaigm">About</a> · Sadaigm</p>
                    </div>

                </div>
            </div>



        </div>
        <div>
            <?php include "pagelayout/navbar.php" ?>
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    </body>

</html>

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
