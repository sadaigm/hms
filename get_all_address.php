<?php

include_once 'dbconfig/dbconfig.php';

$where_clause="";
if(isset($_GET['time']))
{
$selectTime = $_GET['time'];
$where_clause="consulting_hrs like '%".$selectTime."%'";
}
if(isset($_GET['useremail']))
{
$selectuserEmail = $_GET['useremail'];
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
if(isset($_GET['hosp_name']))
{
$selecthosp_name = $_GET['hosp_name'];
}

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


// Select all the rows in the markers table
$query = "SELECT * FROM markers WHERE 1";
if($where_clause!="")
{
 // echo "$where_clause";
$query = "SELECT * FROM markers where name in ( SELECT hosp_name FROM  hosp_doctors WHERE ".$where_clause.")";
}
if(isset($selectuserEmail))
{
$query = "SELECT * from markers where name in ( SELECT hosp_name FROM  hosp_doctors WHERE doctor_email in (  '".$selectuserEmail."'))";
}
if(isset($selecthosp_name))
{
$query = "SELECT * from markers where name = '".$selecthosp_name."'";
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
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}
}

echo $dom->saveXML();

?>