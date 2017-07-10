<?php
session_start();//session is a way to store information (in variables) to be used across multiple pages.
if($_SESSION['loginMode']=="google")
{
//Include GP config file
include_once 'gpConfig.php';

//Unset token and user data from session
unset($_SESSION['token']);
unset($_SESSION['userData']);

//Reset OAuth access token
$gClient->revokeToken();
}

session_destroy();
header("Location: home.php");//use for the redirection to some page
?>  
