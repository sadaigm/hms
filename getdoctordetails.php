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
$where_clause="where email in ( SELECT doctor_email FROM  hosp_doctors WHERE hosp_name in (  '".$selectedhosp_name."'))";
}
if(isset($_GET['speciality']))
{
$speciality = $_GET['speciality'];
if($speciality!="ALL")
{
if($where_clause=="")
{
 $where_clause="where specialty  = '".$speciality."'"; 
}
else{
  $where_clause.=" and specialty  = '".$speciality."'"; 
}
}
}

// Select all the rows in the markers table
$query = "SELECT * from doctors where email in ( SELECT doctor_email FROM  hosp_doctors)";
if($where_clause!="")
{
 // echo "$where_clause";
$query = "SELECT * from doctors ".$where_clause;
}
//if(isset($selectedhosp_name))
//{
//$query = "SELECT * from doctors where email in ( SELECT doctor_email FROM  hosp_doctors WHERE hosp_name in (  '".$selectedhosp_name."'))";
//}
//echo $query;
$result = mysqli_query($db_handle,$query);
if (!$result) {
  die('Invalid query: ' .$query. mysqli_error($db_handle));
}



// Iterate through the rows, adding XML nodes for each
  if(mysqli_num_rows($result))
    {
     // $specialities = array();
       $doctors = array();
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    $doctor = array();
  $speciality= $row['specialty'];
  $doctor_id= $row['doctor_id'];
  
  $firstname= $row['firstname'];
  $lastname= $row['lastname'];
  $phone= $row['phone'];
  $mobile= $row['mobile'];
  $email= $row['email'];
  $qualification= $row['qualification'];
  $doctor = array('doctor_id'=>$doctor_id,'speciality' =>$speciality,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone,'mobile'=>$mobile,'email'=>$email,'qualification'=>$qualification);
  array_push($doctors ,$doctor);
  
 
}
$response = array('doctors'=>$doctors);
print (json_encode($response));
}



?>