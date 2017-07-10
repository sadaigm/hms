<?php
include_once 'dbconfig/dbconfig.php';
include_once 'gettime.php';
?>
<?php
// Gets data from URL parameters.
$add_doc_email = $_GET['add_doc_email'];
$name = $_GET['name'];
$address = $_GET['address'];
$address_details = explode(',', $address);
$address_len = count($address_details);
$ad_Country=$address_details[$address_len-1];
$ad_State_pin=$address_details[$address_len-2];
$ad_City=$address_details[$address_len-3];
$ad_area=$address_details[$address_len-4];
$st_pin_ar=explode(' ', $ad_State_pin);
$state_len = count($st_pin_ar);
$ad_pin=$st_pin_ar[$state_len-1];
$in=0;
$State ="";
foreach($st_pin_ar as $st)
{
    if($in==($state_len-1))
    {
        break;
    }
    if($in==($state_len-2))
    {
        $State.=$st;
    }
    else
    {
        $State.=$st." ";
    }
    $in++;
    
}
//echo "pin :".$ad_pin;
//echo "\r\nCity :".$ad_City;
//echo "\r\nState :".$State;
//echo "\r\nArea :".$ad_area;
//echo $address.'length'.count($address_details).$address_details[5];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$type = $_GET['type'];
$hrs = $_GET['consulting_hrs'];
$consulting_hrs = getConsulting_Hrs($hrs);
//echo "$consulting_hrs";
//echo "$add_doc_email";
//echo "$consulting_hrs";
//print_r("$consulting_hrs");
$phone = $_GET['phone'];
// Inserts new row with place data.
$check_maker = mysqli_query($db_handle,"SELECT * FROM markers WHERE name = '$name'");
if(mysqli_num_rows($check_maker) == 0) {
$query = sprintf("INSERT INTO markers " .
         " (id, name, address, lat, lng, type,  phone,area_code,city,state,geo_code,country) " .
         " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
         mysqli_real_escape_string($db_handle,$name),
         mysqli_real_escape_string($db_handle,$address),
         mysqli_real_escape_string($db_handle,$lat),
         mysqli_real_escape_string($db_handle,$lng),
         mysqli_real_escape_string($db_handle,$type),
        mysqli_real_escape_string($db_handle,$consulting_hrs),
        mysqli_real_escape_string($db_handle,$phone),
        mysqli_real_escape_string($db_handle,$ad_area),
        mysqli_real_escape_string($db_handle,$ad_City),
        mysqli_real_escape_string($db_handle,$State),
        mysqli_real_escape_string($db_handle,$ad_pin),
        mysqli_real_escape_string($db_handle,$ad_Country)
        );

$result = mysqli_query($db_handle,$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($db_handle));
}
}
$check = mysqli_query($db_handle,"SELECT * FROM doctors WHERE email = '$add_doc_email'");
if(mysqli_num_rows($check) == 0) {
    $add_doctor_id = 0;
 $sql_query = "INSERT INTO doctors (doctor_id,email) VALUES ('$add_doctor_id','$add_doc_email')";
  $value = mysqli_query($db_handle,$sql_query);// or die("A mysqli error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysqli_errno() . ") " . mysqli_error());
   
if (!$value) {
  die('Invalid query: ' . mysqli_error($db_handle));
   $response =array("status" => "failed","reason" => "Error Message: n".mysqli_real_escape_string($db_handle,mysqli_error($db_handle)) );
}
else{
    $check_new = mysqli_query($db_handle,"SELECT * FROM doctors WHERE email = '$add_doc_email'");
     if($aResult = mysqli_fetch_array($check_new))
    {
        $doctor_new = array(
            "add_doc_title" => $aResult['title'],
            "add_doc_dob" => $aResult['dob'],
            "add_doc_firstname" => $aResult['firstname'],
            "add_doc_lastname" => $aResult['lastname'],
            "add_doc_middlename" => $aResult['middlename'],
            "add_doc_gender" => $aResult['gender'],
            "add_doc_phone" => $aResult['phone'],
            "add_doc_mobile" => $aResult['mobile'],
            "add_doc_altmobile" => $aResult['altmobile'],
            "add_doc_specialty" => $aResult['specialty'],
            "add_doc_addresslineone" => $aResult['addresslineone'],
            "add_doc_addresslinetwo" => $aResult['addresslinetwo'],
            "add_doc_city" => $aResult['city'],
            "add_doc_state" => $aResult['state'],
            "add_doc_country" => $aResult['country'],
            "add_doc_zip" => $aResult['zip'],
            "add_doc_voter_id" => $aResult['voter_id'],
            "add_doc_aadhar_no" => $aResult['aadhar_no'],
            "add_doc_email" => $aResult['email'],
            "add_doc_qualification" => $aResult['qualification']
            
        );
     $response =array("operation" => "insert","status" => "passed","doctor" => $doctor_new );
}
} 
}
else {
    while($aResult = mysqli_fetch_array($check))
    {
       // echo $aResult;
        $doctor = array(
           "add_doc_title" => $aResult['title'],
            "add_doc_dob" => $aResult['dob'],
            "add_doc_firstname" => $aResult['firstname'],
            "add_doc_lastname" => $aResult['lastname'],
            "add_doc_middlename" => $aResult['middlename'],
            "add_doc_gender" => $aResult['gender'],
            "add_doc_phone" => $aResult['phone'],
            "add_doc_mobile" => $aResult['mobile'],
            "add_doc_altmobile" => $aResult['altmobile'],
            "add_doc_specialty" => $aResult['specialty'],
            "add_doc_addresslineone" => $aResult['addresslineone'],
            "add_doc_addresslinetwo" => $aResult['addresslinetwo'],
            "add_doc_city" => $aResult['city'],
            "add_doc_state" => $aResult['state'],
            "add_doc_country" => $aResult['country'],
            "add_doc_zip" => $aResult['zip'],
            "add_doc_voter_id" => $aResult['voter_id'],
            "add_doc_aadhar_no" => $aResult['aadhar_no'],
            "add_doc_email" => $aResult['email'],
            "add_doc_qualification" => $aResult['qualification']
            
        );
        
         $response =array("operation" => "update","status" => "passed","doctor" => $doctor );
         break;
    }
}

  $hosp_doc_id = 0;
  $hosp_doc_id_sql_query = "INSERT INTO hosp_doctors (id,hosp_name,doctor_email,hosp_zip) VALUES ('$hosp_doc_id','$name','$add_doc_email','$ad_pin')";
   $hosp_value = mysqli_query($db_handle,$hosp_doc_id_sql_query);// or die("A mysqli error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysqli_errno() . ") " . mysqli_error());
  if (!$hosp_value) {
  die('Invalid query: ' . mysqli_error($db_handle));
}


       echo json_encode( $response );



?>