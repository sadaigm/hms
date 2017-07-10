<?php
if(isset($_SESSION))
{

}
else
{
session_start();//session starts here
}


//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
//$client_id = '424322470593-qv8gppmav911rng8a81ej7132g7degcd.apps.googleusercontent.com'; 
//$client_secret = 'RJa33puM3R6Epb3lfQ-AUa5-';
//$redirect_uri = 'http://localhost/glogin/';
$clientId = '424322470593-qv8gppmav911rng8a81ej7132g7degcd.apps.googleusercontent.com';  //Google client ID
$clientSecret = 'RJa33puM3R6Epb3lfQ-AUa5-'; //Google client secret
$redirectURL = 'http://localhost/hms/login.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>