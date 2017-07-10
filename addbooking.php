<?php
include_once 'dbconfig/dbconfig.php';
?>
<?php
// Gets data from URL parameters.
// var url = 'addbooking.php?c_patient_name=' +
//  pname + '&c_patient_phone=' + cno + '&c_date=' + 
//  cdate + '&c_time=' + ctime + '&c_hos_name=' + chosname + '&c_hos_address=' + chosaddress

$c_patient_name = $_GET['c_patient_name'];
$c_patient_phone = $_GET['c_patient_phone'];
$c_date = $_GET['c_date'];
$c_time = $_GET['c_time'];
$c_hos_name = $_GET['c_hos_name'];
$c_hos_address= $_GET['c_hos_address'];
$c_doctor_id= $_GET['c_doctor_id'];
$c_event_keys= $_GET['event_keys'];
$c_speciality= $_GET['c_speciality'];
$milliseconds = round(microtime(true) * 1000);
$key = "BK".generateRandomString().$milliseconds;
// Inserts new row with place data.
$query = sprintf("INSERT INTO appbooking " .
         " (sno,booking_id , c_patient_name, c_patient_phone, c_date, c_time, c_hos_name, c_hos_address,f_book_key,specialty,doc_id) " .
         " VALUES (NULL,'%s', '%s', '%s', '%s', '%s', '%s', '%s','%s','%s','%s');",
         mysqli_real_escape_string($db_handle,$key),
         mysqli_real_escape_string($db_handle,$c_patient_name),
         mysqli_real_escape_string($db_handle,$c_patient_phone),
         mysqli_real_escape_string($db_handle,$c_date),
         mysqli_real_escape_string($db_handle,$c_time),
         mysqli_real_escape_string($db_handle,$c_hos_name),
        mysqli_real_escape_string($db_handle,$c_hos_address),
        mysqli_real_escape_string($db_handle,$c_event_keys),
        mysqli_real_escape_string($db_handle,$c_speciality),
        mysqli_real_escape_string($db_handle,$c_doctor_id));
// echo $query;
$result = mysqli_query($db_handle,$query);

if (!$result) {
  die('Invalid query: ' . mysqli_error($db_handle));
}
 else {
  $arrReturn = array('booking_id'=>$key,'b_patient_name' => $c_patient_name,'b_patient_phone' => $c_patient_phone, 'b_date' => $c_date,'b_time' => $c_time ,'b_hos_name' => $c_hos_name,'b_hos_address' => $c_hos_address,'event_keys'=>$c_event_keys,'doc_id'=>$c_doctor_id);
     print (json_encode($arrReturn));
 }

?>

<?php
function generateRandomString($length = 5) {
  //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $numbers = '0123456789';
  $charactersLength = strlen($characters);
  $numbersLength = strlen($numbers);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
//  $randomString .= '_';
//  for ($i = 0; $i < $length; $i++) {
//      $randomString .= $numbers[rand(0, $numbersLength - 1)];
//  }
  return $randomString;
}
?>