<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'dbconfig/dbconfig.php';

// Start XML file, create parent node
if(isset($_GET['default_location']))
{
$selectLocation = $_GET['default_location'];
}
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
// Select all the rows in the markers table
$query = "SELECT * FROM default_location WHERE name ='chennai'";
if(isset($selectLocation))
{
$query = "SELECT * FROM default_location WHERE name ='".$selectLocation."'";
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
  $newnode->setAttribute("id",$row['sno']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("lat", $row['latitude']);
  $newnode->setAttribute("lng", $row['longitude']);
}
}

echo $dom->saveXML();

?>
