<?php

// Connexion à la base de données
include_once 'dbconfig/dbconfig.php';
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])&& isset($_POST['description']) && isset($_POST['email']) && isset($_POST['patient'])) {

    $title = mysqli_real_escape_string($db_handle,$_POST['title']);
    $start = $_POST['start'];
    $end = $_POST['end'];
    $color = $_POST['color'];
    $description = mysqli_real_escape_string($db_handle,$_POST['description']);
    $email = $_POST['email'];
    $patient = $_POST['patient'];
$milliseconds = round(microtime(true) * 1000);
$key = "EK".generateRandomString().$milliseconds;
    $sql = "INSERT INTO calendarevents(book_key,title, start, end, color,patient,email,description,status) values ('$key','$title', '$start', '$end', '$color','$patient','$email','$description','new')";
    //$req = $bdd->prepare($sql);
    //$req->execute();

   // echo $sql;
    $value = mysqli_query($db_handle, $sql);
  
    if (!$value) {
        die('Error Occured: ' . mysqli_error($db_handle));
    }
}
 $places_json = array('key' => $key);

print (json_encode($places_json));
//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

<?php
function generateRandomString($length = 5) {
 // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $numbers = '0123456789';
  $charactersLength = strlen($characters);
  $numbersLength = strlen($numbers);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
?>