<?php
include_once 'dbconfig/dbconfig.php';
if (isset($_GET['hosp']))
{
    $hosp=$_GET['hosp'];
}

 $cd_count ="SELECT * FROM markers";
 if(isset($hosp))
 {
     $cd_count ="SELECT * FROM markers where name like '%".$hosp."%'";
 }
   $cdresult=mysqli_query($db_handle,$cd_count) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
 while ($cdrow=mysqli_fetch_array($cdresult,MYSQLI_ASSOC)) {
     $hos_name=$cdrow["name"];
     $data[] = $hos_name;
 }
 echo json_encode($data);

?>