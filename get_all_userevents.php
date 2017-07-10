<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'dbconfig/dbconfig.php';

if (isset($_GET['book_keys'])) {
    $f_book_key = $_GET['book_keys'];
    $b_key = array();
    $keys = explode(",", $f_book_key);
    //print (json_encode($keys));
    for ($x = 0; $x < count($keys); $x++) {
        array_push($b_key, "'" . $keys[$x] . "'");
    }
    // print (json_encode($b_key));
    $sql = "select * from calendarevents where status = 'new'  and book_key in (" . implode(',', $b_key) . ")";
    $eve_result = mysqli_query($db_handle, $sql);
    if (!$eve_result) {
        die('Invalid query: ' . mysqli_error($db_handle));
    }
    if (mysqli_num_rows($eve_result)) {
        $book_key = array();

        while ($event = mysqli_fetch_array($eve_result, MYSQLI_ASSOC)) {
            $eId = $event['id'];
            $eTitle = $event['title'];
            $color = $event['color'];
            $description = $event['description'];
            $book_key = $event['book_key'];
            $start = explode(" ", $event['start']);
            $end = explode(" ", $event['end']);
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
            $event_ar = array('id' => $eId, 'title' => $eTitle, 'start' => $start, 'end' => $end, 'color' => $color, 'description' => $description, 'book_key' => $book_key);
            $events[] = $event_ar;
        }
        $json_events = array('events' => $events, 'f_book_key' => $f_book_key);
        print (json_encode($json_events));
    }
} else {



    $where_clause = "";
    $sql = "select * from calendarevents where status = 'new' order by last_updated_date DESC LIMIT 5";

    if (isset($_GET['hosp_name']) && isset($_GET['email'])) {
        $hosp_name = $_GET['hosp_name'];
        $cust_email = $_GET['email'];
        $app_query = "select * from appbooking where c_hos_name = '" . $hosp_name . "' order by last_updated_date DESC LIMIT 5";

        if (isset($_GET['doc_id'])) {
             $doc_id = $_GET['doc_id'];
            if ($doc_id != "ALL") {
               
                $app_query = "select * from appbooking where c_hos_name = '" . $hosp_name . "' and doc_id = '" . $doc_id . "' order by last_updated_date DESC LIMIT 5";
            }
        }

        //print (json_encode($app_query));
        $app_result = mysqli_query($db_handle, $app_query);
        $where_clause = "";
        if (!$app_result) {
            die('Invalid query: ' . mysqli_error($db_handle));
        }
        $events = array();
        $book_key = array();
// Iterate through the rows, adding XML nodes for each
        if (mysqli_num_rows($app_result)) {


            while ($bookings = mysqli_fetch_array($app_result, MYSQLI_ASSOC)) {
                $f_book_key = $bookings['f_book_key'];
                $keys = explode(",", $f_book_key);

                for ($x = 0; $x < count($keys); $x++) {
                    array_push($book_key, "'" . $keys[$x] . "'");
                }
            }
        }
        if (isset($_GET['temp_b_keys'])) {
            $temp_b_keys = $_GET['temp_b_keys'];
            $keys = explode(",", $temp_b_keys);

            for ($x = 0; $x < count($keys); $x++) {
                array_push($book_key, "'" . $keys[$x] . "'");
            }
        }
        if (count($book_key) > 0) {
//print (json_encode($keys));
//print (json_encode($book_key));
            $where_clause = " and book_key in (" . implode(',', $book_key) . ") and email = '" . $cust_email . "'";

            if ($where_clause != "") {
                $sql = "select * from calendarevents where status = 'new' " . $where_clause . "";
            }


// echo $sql;
            $result = mysqli_query($db_handle, $sql);
            if (!$result) {
                die('Invalid query: ' . mysqli_error($db_handle));
            }

// Iterate through the rows, adding XML nodes for each
            if (mysqli_num_rows($result)) {

                while ($event = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $eId = $event['id'];
                    $eTitle = $event['title'];
                    $color = $event['color'];
                    $description = $event['description'];
                    $book_key = $event['book_key'];
                    $start = explode(" ", $event['start']);
                    $end = explode(" ", $event['end']);
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
                    $event_ar = array('id' => $eId, 'title' => $eTitle, 'start' => $start, 'end' => $end, 'color' => $color, 'description' => $description, 'book_key' => $book_key);
                    $events[] = $event_ar;
                }
                $json_events = array('events' => $events, 'sql' => $sql, 'where_clause' => $where_clause, 'hos' => $_GET['hosp_name']);

                print (json_encode($json_events));
            } else {
                $json_events = array('events' => $events, 'sql' => $sql, 'where_clause' => $where_clause, 'hos' => $_GET['hosp_name']);

                print (json_encode($json_events));
            }
        } else {
            $json_events = array('events' => $events, 'sql' => $sql, 'where_clause' => $where_clause, 'hos' => $_GET['hosp_name']);

            print (json_encode($json_events));
        }
    } else {
        $result = mysqli_query($db_handle, $sql);
        if (!$result) {
            die('Invalid query: ' . mysqli_error($db_handle));
        }
        $events = array();
// Iterate through the rows, adding XML nodes for each
        if (mysqli_num_rows($result)) {

            while ($event = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $eId = $event['id'];
                $eTitle = $event['title'];
                $color = $event['color'];
                $description = $event['description'];
                $book_key = $event['book_key'];
                $start = explode(" ", $event['start']);
                $end = explode(" ", $event['end']);
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
                $event_ar = array('id' => $eId, 'title' => $eTitle, 'start' => $start, 'end' => $end, 'color' => $color, 'description' => $description, 'book_key' => $book_key);
                $events[] = $event_ar;
            }
            $json_events = array('events' => $events, 'sql' => $sql, 'where_clause' => $where_clause, 'hos' => $_GET['hosp_name']);

            print (json_encode($json_events));
        } else {
            $json_events = array('events' => $events, 'sql' => $sql, 'where_clause' => $where_clause, 'hos' => $_GET['hosp_name']);

            print (json_encode($json_events));
        }
    }
}