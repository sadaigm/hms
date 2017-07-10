<?php
$host = "localhost";
$user = "sadai";
$password = "sadai";
$datbase = "hms";
$db_handle=mysqli_connect($host,$user,$password);
mysqli_select_db($db_handle,$datbase);
?>
