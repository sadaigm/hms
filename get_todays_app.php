<?php

include_once ('./dbconfig/dbconfig.php');
include_once ('./gethumantime.php');
$limit = 5;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};



$doc_id="";
if(isset($_GET['doc_email']))
{
    $email=$_GET['doc_email'];
    $email_sql = "SELECT * FROM doctors where email = '".$email."'";
$email_result = mysqli_query($db_handle,$email_sql);
//echo $email_sql;
if (mysqli_num_rows($email_result)) {

while($emailrow = mysqli_fetch_array($email_result, MYSQLI_ASSOC)) {
  $doc_id=  $emailrow['doctor_id'];
  break;
}
}
}

$start_from = ($page - 1) * $limit;
if($doc_id!="")
{
$sql = "SELECT * FROM appbooking where status !='verified' and  doc_id ='".$doc_id."' and DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT(CURDATE(), '%Y-%m-%d') order by sno DESC LIMIT $start_from, $limit";
$count_sql = "SELECT count(*) FROM appbooking where status !='verified' and  doc_id ='".$doc_id."' and DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT(CURDATE(), '%Y-%m-%d')";
}
else
{
$sql = "SELECT * FROM appbooking where status !='verified' and  DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT(CURDATE(), '%Y-%m-%d') order by sno DESC LIMIT $start_from, $limit";
$count_sql = "SELECT count(*) FROM appbooking where status !='verified' and  DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT(CURDATE(), '%Y-%m-%d')";
}



//SELECT * FROM appbooking where DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT('2017-03-28 00:35:34', '%Y-%m-%d')
//SELECT * FROM appbooking where DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT(CURDATE(), '%Y-%m-%d')
//latest SQL
//$sql = "SELECT * FROM appbooking where DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT(CURDATE(), '%Y-%m-%d') order by sno DESC LIMIT $start_from, $limit";
$rs_result = mysqli_query($db_handle, $sql);
$next_page = $page + 1;
?>
<?php
//latest count SQL
//$sql = "SELECT count(*) FROM appbooking where DATE_FORMAT(last_updated_date,'%Y-%m-%d') = DATE_FORMAT(CURDATE(), '%Y-%m-%d') ";
$count_result = mysqli_query($db_handle, $count_sql);
$count_row = mysqli_fetch_row($count_result);
$total_records = $count_row[0];
if($total_records<$limit)
{
    $total_pages=1;
    $last_page=0;
}
else
{
$total_pages = ceil($total_records / $limit);
$last_page = ceil($total_records % $limit);
}
if ($last_page > 0) {
    $total_pages = $total_pages + $last_page;
}
?>
<?php
$count =0;
while ($cdrow = mysqli_fetch_array($rs_result, MYSQLI_ASSOC)) {
    $count++;
    $booking_id = $cdrow["booking_id"];
    $c_hos_name = $cdrow["c_hos_name"];
    $c_patient_name = $cdrow["c_patient_name"];
    $c_patient_phone = $cdrow["c_patient_phone"];
    $last_updated_date = $cdrow["last_updated_date"];
    $since = time_elapsed_string($last_updated_date);
    
    $c_date = $cdrow["c_date"];
    $c_time = $cdrow["c_time"];
    $c_hos_address = $cdrow["c_hos_address"];
    $intial_char = ucwords(mb_substr($c_patient_name, 0, 1));

     $f_book_key = $cdrow["f_book_key"];
     $keys = explode(",", $f_book_key);
      $book_key = array();

                for ($x = 0; $x < count($keys); $x++) {
                    array_push($book_key, "'" . $keys[$x] . "'");
                }
                
                 if (count($book_key) > 0) {
//print (json_encode($keys));
//print (json_encode($book_key));
            $where_clause = " and book_key in (" . implode(',', $book_key) . ")";

            if ($where_clause != "") {
                $eventsql = "select * from calendarevents where status = 'new' " . $where_clause . "";
            }


// echo $sql;
            $result = mysqli_query($db_handle, $eventsql);
            if (!$result) {
                die('Invalid query: ' . mysqli_error($db_handle));
            }

// Iterate through the rows, adding XML nodes for each
            if (mysqli_num_rows($result)) {

                while ($event = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $eId = $event['id'];
                    $eTitle = mysqli_real_escape_string($db_handle,$event['title']);
                    $color = $event['color'];
                    $description = mysqli_real_escape_string($db_handle,$event['description']);
                    $patient_email= mysqli_real_escape_string($db_handle,$event['email']);
                    $book_key = $event['book_key'];
                    $status = $event['status'];
                    $start = explode(" ", $event['start']);
                    $end = explode(" ", $event['end']);
                    $c_date=$start[0];
                    $c_time=$start[1]." To ".$end[1];
                    if ($start[1] == '00:00:00') {
                        $start = $start[0];
                    } else {
                        $start = $event['start'];
                    }
                    if ($end[1] == '00:00:00') {
                        $end = $end[0];
                    } else {
                        $end = $event['end'];
                    }
                    
                    //$event_ar = array('id' => $eId, 'title' => $eTitle, 'start' => $start, 'end' => $end, 'color' => $color, 'description' => $description, 'book_key' => $book_key);
                   
                       $row_array = array("sno"=>$count,"booking_id" => $booking_id, "c_hos_name" => $c_hos_name, "last_updated_date" => $last_updated_date, "c_patient_name" => $c_patient_name,'c_hos_address'=>$c_hos_address,
                        "intial_char" => $intial_char, "c_date" => $c_date, "c_time" => $c_time,'since'=>$since,'patient_email'=>$patient_email,'status'=>$status,
                        'f_book_key'=>$f_book_key,'event_id' => $eId, 'title' => $eTitle, 'start' => $start, 'end' => $end, 'color' => $color, 'description' => $description, 'event_key' => $book_key,'c_patient_phone'=>$c_patient_phone);
                     
                     $places['appointments'][] = $row_array;
//                    $events[] = $event_ar;
                }
            }
                 }
                
                
                
    
    
    //$row_array = array("sno"=>$count,"booking_id" => $booking_id, "c_hos_name" => $c_hos_name, "last_updated_date" => $last_updated_date, "c_patient_name" => $c_patient_name, "intial_char" => $intial_char, "c_date" => $c_date, "c_time" => $c_time);
    //$places['appointments'][] = $row_array;
    
}
if (!isset($places)) {
    $places_json = array('currentpage' => $page, 'nextpage' => $next_page, "places" => null, "total_pages" => $total_pages,"total_records"=>$total_records);
} else {
    $places_json = array('currentpage' => $page, 'nextpage' => $next_page, "places" => $places, "total_pages" => $total_pages,"total_records"=>$total_records);
}

print (json_encode($places_json));
?>  

 