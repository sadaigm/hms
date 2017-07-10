<?php

include_once 'dbconfig/dbconfig.php';

$where_clause="";
if(isset($_GET['time']))
{
$selectTime = $_GET['time'];
$where_clause="consulting_hrs like '%".$selectTime."%'";
}
if(isset($_GET['hosp_name']))
{
$selectedhosp_name = $_GET['hosp_name'];
}
if(isset($_GET['speciality']))
{
$speciality = $_GET['speciality'];
if($where_clause=="")
{
 $where_clause="doctor_email in (SELECT email from doctors WHERE specialty  like '%".$speciality."%')"; 
}
else{
  $where_clause.=" and doctor_email in (SELECT email from doctors WHERE specialty  like '%".$speciality."%')"; 
}
}

// Select all the rows in the markers table
$query = "SELECT * from doctors where email in ( SELECT doctor_email FROM  hosp_doctors)";
if($where_clause!="")
{
 // echo "$where_clause";
$query = "SELECT * FROM markers where name in ( SELECT hosp_name FROM  hosp_doctors WHERE ".$where_clause.")";
}
if(isset($selectedhosp_name))
{
$query = "SELECT * from doctors where email in ( SELECT doctor_email FROM  hosp_doctors WHERE hosp_name in (  '".$selectedhosp_name."'))";
}
//echo $query;
$result = mysqli_query($db_handle,$query);
if (!$result) {
  die('Invalid query: ' .$query. mysqli_error($db_handle));
}



// Iterate through the rows, adding XML nodes for each
  if(mysqli_num_rows($result))
    {
      $specialities = array();
       $doctors = array();
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    $doctor = array();
  $speciality= $row['specialty'];
  $firstname= $row['firstname'];
  $lastname= $row['lastname'];
  $phone= $row['phone'];
  $mobile= $row['mobile'];
  $email= $row['email'];
  $qualification= $row['qualification'];
  $doctor = array('speciality' =>$speciality,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone,'mobile'=>$mobile,'email'=>$email,'qualification'=>$qualification);
  array_push($doctors ,$doctor);
  $myArray = explode(',', $speciality);
  
  $arrlength = count($myArray);
  for($x = 0; $x < $arrlength; $x++) {
      array_push( $specialities,$myArray[$x]);
  }
 
 //print_r($specialities);
          
}
}
$un_specialities = array_unique($specialities);
$response = array("specialities" => $un_specialities,'doctors'=>$doctors);
print (json_encode($response));

?>