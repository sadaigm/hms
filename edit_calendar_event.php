<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once 'dbconfig/dbconfig.php';
$operation = "view";
$Error = "";
$status = "new";
$book_key ="";
$app_status ="";
$app_key ="";
$customer_email ="";
if(isset($_POST['book_key']))
{
     $book_key = $_POST['book_key'];
    $select_sql = "select * from calendarevents where book_key= '$book_key'";
    $val = mysqli_query($db_handle, $select_sql);
      while ($cdrow = mysqli_fetch_array($val, MYSQLI_ASSOC)) {
           $customer_email = $cdrow["email"];
           $status = $cdrow["status"];
           break;
      }
    


if (isset($_POST['del_event']) && isset($_POST['book_key'])) {
    $book_key = $_POST['book_key'];

    $sql = "DELETE FROM calendarevents WHERE book_key = '$book_key'";
    $value = mysqli_query($db_handle, $sql);

    if (!$value) {
        die('Error Occured: ' . mysqli_error($db_handle));
    }
    $operation = "delete";
} elseif (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['book_key'])) {

    $book_key = $_POST['book_key'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "UPDATE calendarevents SET  title = '$title', description = '$description' WHERE book_key = '$book_key'";


    $value = mysqli_query($db_handle, $sql);

    if (!$value) {
        die('Error Occured: ' . mysqli_error($db_handle));
    }
    $operation = "update";
} elseif (isset($_POST['status']) && isset($_POST['color']) && isset($_POST['book_key'])) {

    $book_key = $_POST['book_key'];
    $estatus = $_POST['status'];
    $color = $_POST['color'];

    $sql = "UPDATE calendarevents SET  status = '$estatus', color = '$color' WHERE book_key = '$book_key'";


    $value = mysqli_query($db_handle, $sql);

    if (!$value) {
        die('Error Occured: ' . mysqli_error($db_handle));
        $Error = "Error Occured : " + $sql;
    }

    $select_sql = "select * from appbooking where status !='verified' and  f_book_key like '%" . $book_key . "%'";
    $rs_result = mysqli_query($db_handle, $select_sql);
    while ($cdrow = mysqli_fetch_array($rs_result, MYSQLI_ASSOC)) {
        $f_book_key = $cdrow["f_book_key"];
        $booking_id = $cdrow["booking_id"];
        $app_key=$booking_id ;
        $keys = explode(",", $f_book_key);
        $book_keys = array();

        for ($x = 0; $x < count($keys); $x++) {
            array_push($book_keys, "'" . $keys[$x] . "'");
        }

        if (count($book_keys) > 0) {
//print (json_encode($keys));
//print (json_encode($book_key));
            $where_clause = " and book_key in (" . implode(',', $book_keys) . ")";

            if ($where_clause != "") {
                $count_sql = "select count(*) from calendarevents where status = 'new' " . $where_clause . "";
            }

            $count_result = mysqli_query($db_handle, $count_sql);
            $count_row = mysqli_fetch_row($count_result);
            $total_records = $count_row[0];

            if ($total_records == 0) {
                $upsql = "UPDATE appbooking SET  status = 'verified' WHERE booking_id = '$booking_id'";
                $app_status="verified";
            } else {
                $upsql = "UPDATE appbooking SET  status = 'under-review' WHERE booking_id = '$booking_id'";
                $app_status="under-review";
            }
            $value = mysqli_query($db_handle, $upsql);

            if (!$value) {
                die('Error Occured: ' . mysqli_error($db_handle));
                $Error = "Error Occured : " + $upsql;
            }
        }
    }

    $operation = "verified";
    $status = $estatus;
}
}

$json_events = array('operation' => $operation, 'key' => $book_key, 'Error' => $Error, 'status' => $status,'app_key'=>$app_key,'app_status'=>$app_status,'customer_email'=>$customer_email);

print (json_encode($json_events));
?>
