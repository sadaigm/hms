<?php

include_once 'dbconfig/dbconfig.php';

// Start XML file, create parent node
if(isset($_GET['time']))
{
$selectTime = $_GET['time'];
}
if(isset($_GET['useremail']))
{
$selectuserEmail = $_GET['useremail'];
}
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);



// Select all the rows in the markers table
$query = "SELECT * FROM markers WHERE 1";
if(isset($selectTime))
{
// $query = "SELECT * FROM markers WHERE consulting_hrs like '%".$selectTime."%'";
  $query = "SELECT * FROM markers where name in ( SELECT hosp_name FROM  hosp_doctors WHERE consulting_hrs like '%".$selectTime."%')";
}
if(isset($selectuserEmail))
{
$query = "SELECT * from markers where name in ( SELECT hosp_name FROM  hosp_doctors WHERE doctor_email in (  '".$selectuserEmail."'))";
}
//echo $query;
$result = mysqli_query($db_handle,$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($db_handle));
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
  if(mysqli_num_rows($result))
    {
      
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['id']);
  $newnode->setAttribute("name",$row['name']);
  $HOSP_NAME=$row['name'];  
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
  $sql_doctor_query = "SELECT * FROM HOSP_DOCTORS WHERE HOSP_NAME = '".$HOSP_NAME."'";

  //$sql_doctor_query = "SELECT * FROM DOCTORS WHERE EMAIL IN (SELECT DOCTOR_EMAIL FROM HOSP_DOCTORS WHERE HOSP_NAME =".$HOSP_NAME.")";
  $doctor_result = mysqli_query($db_handle,$sql_doctor_query);
  if (!$doctor_result) {
  die('Invalid query: ' . mysqli_error($db_handle));
}
 if(mysqli_num_rows($doctor_result))
      {
        while ($doctor_row = mysqli_fetch_array($doctor_result,MYSQLI_ASSOC)){
        $doctor = $dom->createElement("doctor");
        $doctornode = $newnode->appendChild($doctor);
        $doctornode->setAttribute("id",$doctor_row['id']);
        $doctornode->setAttribute("doctor_email",$doctor_row['doctor_email']);
        $doctor_email = $doctor_row['doctor_email'];
        $doctornode->setAttribute("consulting_hrs",$doctor_row['consulting_hrs_raw']);

        $sql_doctor_details_query = "SELECT * FROM DOCTORS WHERE EMAIL = '".$doctor_email."'";
        $doctor_details_result = mysqli_query($db_handle,$sql_doctor_details_query);
        if (!$doctor_details_result) {
        die('Invalid query: ' . mysqli_error($db_handle));
      }
       if(mysqli_num_rows($doctor_details_result))
          {
            
      while ($doctor_details_row = mysqli_fetch_array($doctor_details_result,MYSQLI_ASSOC)){
        $details = $dom->createElement("details");
        $detailsnode = $doctor->appendChild($details);
        $detailsnode->setAttribute("doctor_id",$doctor_details_row['doctor_id']);
        $detailsnode->setAttribute("doctor_name",$doctor_details_row['firstname']." ".$doctor_details_row['lastname']);
        $detailsnode->setAttribute("gender",$doctor_details_row['gender']);
        $detailsnode->setAttribute("phone",$doctor_details_row['phone']);
        $detailsnode->setAttribute("mobile",$doctor_details_row['mobile']);
        $detailsnode->setAttribute("specialty",$doctor_details_row['specialty']);
        $detailsnode->setAttribute("qualification",$doctor_details_row['qualification']);
        
      }
      }



     
  }
}
}
}
echo $dom->saveXML();

?>