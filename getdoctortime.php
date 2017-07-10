<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'dbconfig/dbconfig.php';
$where_clause="";
if(isset($_GET['hosp_name']))
{
$hosp_name = $_GET['hosp_name'];
$where_clause="where hosp_name  = '".$hosp_name."'"; 
}
if(isset($_GET['doc_id']))
{
$doctor_id = $_GET['doc_id'];
if($doctor_id!="ALL")
{
$sql_docEmail= "select distinct email from doctors where doctor_id = '".$doctor_id."'"; 

if($where_clause=="")
{
 $where_clause=" doctor_email  IN (".$sql_docEmail.")"; 
}
else{
  $where_clause.=" and doctor_email IN (".$sql_docEmail.")"; 
}
}
}
if(isset($_GET['doc_email']))
{
$selectdoc_email = $_GET['doc_email'];
if($where_clause=="")
{
 $where_clause=" doctor_email  = '".$selectdoc_email."'"; 
}
else{
  $where_clause.=" and doctor_email  = '%".$selectdoc_email."%'"; 
}

}
$query ="SELECT * FROM  hosp_doctors";
if($where_clause!="")
{
 // echo "$where_clause";
$query = "SELECT * FROM  hosp_doctors ".$where_clause."";
}
$result = mysqli_query($db_handle,$query);
if (!$result) {
  die('Invalid query: ' .$query. mysqli_error($db_handle));
}



//echo $query;
// Iterate through the rows, adding XML nodes for each
$dow=array(0,1,2,3,4,5,6);

  if(mysqli_num_rows($result))
    {
      $consulting_hrs = array();
      $disableTime = array();
      while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
          $hrs= $row['consulting_hrs'];
          $hrs_raw= $row['consulting_hrs_raw'];
           $myArray = explode(',', $hrs);
           $myArray_raw = explode(',', $hrs_raw);
            $arrlength_raw = count($myArray_raw);
  for($x = 0; $x < $arrlength_raw; $x++) {
      if($myArray_raw[$x]!="")
      {
          $param = explode('-', $myArray_raw[$x]);
//          if($param[1]>=12)
//          {
//              $param[1]=$param[1].":00pm";
//          }
//          else
//          {
//              $param[1]=$param[1].":00am";
//          }
//          
//          if($param[0]>=12)
//          {
//              $param[0]=$param[0].":00pm";
//          }
//          else
//          {
//              $param[0]=$param[0].":00am";
//          }
      $bhour = array('start'=>$param[0].":00",'end'=>$param[1].":00",'dow'=>$dow);
      $bhours[] =$bhour;
      }
  }
  $arrlength = count($myArray);
  for($x = 0; $x < $arrlength; $x++) {
      if($myArray[$x]!="")
      {
      array_push( $consulting_hrs,$myArray[$x]);
      }
  }
 
 //print_r($specialities);
          
}
}
$un_consulting_hrs = array_unique($consulting_hrs);
$dow=array(0,1,2,3,4,5,6);
$step =["am","pm"];
for($i=0;$i<count($step);$i++)
{
    for($j=1;$j<=12;$j++)
{
       if (in_array($j.":00".$step[$i], $un_consulting_hrs))
  {
 // echo "Match found";
  }
else
  {
   array_push($disableTime,$j.":00".$step[$i]);
  //echo $j.":00".$step[$i]."Match not found";
  }
   if (in_array($j.":30".$step[$i], $un_consulting_hrs))
  {
  //echo "Match found";
  }
else
  {
    array_push($disableTime,$j.":30".$step[$i]);
  //echo $j.":30".$step[$i]."Match not found";
  }
    }
}


if(isset($hosp_name))
{
$response = array("consulting_hrs" => $un_consulting_hrs,'hospital'=>$hosp_name,'disableTime'=>$disableTime,'bhours'=>$bhours);
}
else
{
    $response = array("consulting_hrs" => $un_consulting_hrs,'disableTime'=>$disableTime,'bhours'=>$bhours);
}



print (json_encode($response));
  
?>