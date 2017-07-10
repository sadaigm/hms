<?php
include_once 'dbconfig/dbconfig.php';
include_once 'gettime.php';
?>
<?php

 $add_doctor_id = 0;
  $add_doc_title = mysqli_real_escape_string($db_handle , $_POST['add_doc_title']);
  $add_doc_dob = mysqli_real_escape_string($db_handle , $_POST['add_doc_dob']);
  $add_doc_firstname = mysqli_real_escape_string($db_handle , $_POST['add_doc_firstname']);
  $add_doc_lastname = mysqli_real_escape_string($db_handle , $_POST['add_doc_lastname']);
  $add_doc_middlename = mysqli_real_escape_string($db_handle , $_POST['add_doc_middlename']);
  $add_doc_gender = mysqli_real_escape_string($db_handle , $_POST['add_doc_gender']);
  $add_doc_phone = mysqli_real_escape_string($db_handle , $_POST['add_doc_phone']);
  $add_doc_mobile = mysqli_real_escape_string($db_handle , $_POST['add_doc_mobile']);
  $add_doc_altmobile = mysqli_real_escape_string($db_handle , $_POST['add_doc_altmobile']);
  $add_doc_email = mysqli_real_escape_string($db_handle , $_POST['add_doc_email']);
  $add_doc_specialty = mysqli_real_escape_string($db_handle , $_POST['add_doc_specialty']);
  $hrs = mysqli_real_escape_string($db_handle , $_POST['consulting_hrs']);
   //echo "$hrs";
   //echo "$add_doc_specialty";
    $consulting_hrs = getConsulting_Hrs($hrs);
   // echo "$consulting_hrs";
  $add_doc_addresslineone = mysqli_real_escape_string($db_handle , $_POST['add_doc_addresslineone']);
  $add_doc_addresslinetwo = mysqli_real_escape_string($db_handle , $_POST['add_doc_addresslinetwo']);
  $add_doc_city = mysqli_real_escape_string($db_handle , $_POST['add_doc_city']);
  $add_doc_state = mysqli_real_escape_string($db_handle , $_POST['add_doc_state']);
  $add_doc_country = mysqli_real_escape_string($db_handle , $_POST['add_doc_country']);
  $add_doc_zip = mysqli_real_escape_string($db_handle , $_POST['add_doc_zip']);
  $add_doc_aadhar_no = mysqli_real_escape_string($db_handle , $_POST['add_doc_aadhar_no']);
  $add_doc_voter_id = mysqli_real_escape_string($db_handle , $_POST['add_doc_voter_id']);
  $add_doc_hosp_name = mysqli_real_escape_string($db_handle , $_POST['add_doc_hosp_name']);
  $add_doc_qualification = mysqli_real_escape_string($db_handle , $_POST['add_doc_qualification']);
  
  
  /*$add_doc_profilepic = mysqli_real_escape_string($db_handle , $_POST['add_doc_profilepic']);*/

  //$sql_query = "UPDATE doctors (title,dob,firstname,lastname,middlename,gender,phone,mobile,altmobile,specialty,addresslineone,addresslinetwo,city,state,country,zip,consulting_hrs,aadhar_no) VALUES ('$add_doc_title','$add_doc_dob','$add_doc_firstname','$add_doc_lastname','$add_doc_middlename','$add_doc_gender','$add_doc_phone','$add_doc_mobile','$add_doc_altmobile','$add_doc_specialty','$add_doc_addresslineone','$add_doc_addresslinetwo','$add_doc_city','$add_doc_state','$add_doc_country','$add_doc_zip','$consulting_hrs','$add_doc_aadhar_no')";
  $update_sql = "UPDATE doctors set title = '$add_doc_title',    dob = '$add_doc_dob',   firstname = '$add_doc_firstname',   lastname = '$add_doc_lastname',   middlename = '$add_doc_middlename',   gender =  '$add_doc_gender',   phone =  '$add_doc_phone',   mobile =  '$add_doc_mobile',   altmobile = '$add_doc_altmobile',   specialty =  '$add_doc_specialty',   addresslineone = '$add_doc_addresslineone',   addresslinetwo = '$add_doc_addresslinetwo',   city =  '$add_doc_city',   state =  '$add_doc_state',   country =  '$add_doc_country',   zip = '$add_doc_zip',   voter_id =  '$add_doc_voter_id',   aadhar_no = '$add_doc_aadhar_no' , qualification ='$add_doc_qualification' where email = '$add_doc_email'";
  $value = mysqli_query($db_handle,$update_sql);// or die("A mysqli error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysqli_errno() . ") " . mysqli_error());
 
   $hosp_doc_id_sql_query = "UPDATE hosp_doctors set consulting_hrs =  '$consulting_hrs',consulting_hrs_raw = '$hrs' where doctor_email ='$add_doc_email'  and hosp_name ='$add_doc_hosp_name' ";
   $hosp_value = mysqli_query($db_handle,$hosp_doc_id_sql_query);// or die("A mysqli error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysqli_errno() . ") " . mysqli_error());
  if (!$hosp_value) {
  die('Invalid query: ' . mysqli_error($db_handle));
}

  
  if($value)
  {
      $response =array("status" => "passed" );
       echo json_encode( $response );
   
  }
  else
  {
$status =  array();
      $status[] ="passed" ;
      $response =array("status" => "failed","reason" => "Error Message: n".mysqli_real_escape_string($db_handle,mysqli_error($db_handle)) );
      
      
      echo json_encode( $response );
//    echo '<script type="text/javascript">alert("A mysqli error has occurred while inserting your data \n \n Your Query: \n'. $sql_query .' \n\n Error Message: \n'.mysqli_real_escape_string($db_handle,mysqli_error($db_handle)).'");</script>';

  }
?>