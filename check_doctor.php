<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function checkDoctorExist($doc_email) {
    
include("dbconfig/dbconfig.php");
echo "<script>
console.log('$doc_email');
</script>";

    $myArray = explode(',', base64_decode($doc_email));
  //print_r($myArray);
$check_doctor="select * from doctors where email ='".$myArray[1]."'";
echo "<script>
console.log('$myArray[1]');
</script>";
if($run = mysqli_query($db_handle, $check_doctor))
{
    if ((mysqli_num_rows($run))>0) {
        return "Y";
    }
    else{
        return "N";
    }
}
else
{
        return "N";
}
}
?>
