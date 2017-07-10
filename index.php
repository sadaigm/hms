<!DOCTYPE html >
<?php
if (!isset($_SESSION)) {
    session_start();
    if (!($_SESSION['email'] && $_SESSION['email_key'] && $_SESSION['loginMode'])) {
        session_destroy();

        header("Location: home.php"); //redirect to login page to secure the welcome page without login access.
    } else {
        if(isset($_SESSION['role']) && $_SESSION['role']=="DOCTOR")
      {
            header("Location: my_account.php");//redirect to login page to secure the welcome page without login access.
    
      }
      else
      {
        if (isset($_GET['default_location'])) {
            $selectLocation = $_GET['default_location'];
        } else {
            $selectLocation = "chennai";
        }
      }
       
    }
}
?>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Search Hospital & Clinic</title>

    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */

        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }
        /*
      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
       *max-width: 400px;
      }*/
        /*
      #pac-input:focus {
        border-color: #4d90fe;
      }*/

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        #target {
            width: 345px;
        }

        .hideform {
            display: none;
        }

        .showform {
            display: block;
        }

        #map-outer {
            height: 740px;
            padding: 30px;
            border: 2px solid #CCC;
            margin-bottom: 20px;
            background-color: #FFF
        }

        #map-container {
            height: 500px
        }
        #map {
            max-width: 100%;max-height: 700px;
        }
        .clear_btn{
            float: right;
            margin-right: 10px;
        }


        @media all and (max-height: 570px) and (max-width: 450px) and (min-width: 320px){
            #map-outer {
                padding: 10px;
                height: 430px
            }
            #map {
                height: 400px !important;
            }
            #pac-input{
                width: 220px
            }
        }
        @media all and (max-width: 500px) and (min-height: 571px)  and (max-height: 840px){
            #map-outer {
                padding: 15px;
                height: 530px
            }
            #map {
                height: 510px !important;
            }
            #pac-input{
                width: 250px
            }

        }
        @media all and (min-width: 1344px) and (max-height: 800px) {
            #map-outer {
                padding: 15px;
                height: 550px
            }
            #map {
                height: 520px !important;
            }
            /*            #pac-input{
                            width: 250px
                        }*/
        }
        @media all and (max-width: 991px) and (min-height: 800px) {
            #map-outer {
                padding: 15px;
                height: 650px
            }
            #map {
                height: 650px !important;
            }
            #pac-input{
                width: 250px
            }
        }


        .row {
            padding: 10px;
        }

        .search-box,
        .close-icon,
        .search-wrapper {
            position: relative;
            padding: 10px;
        }

        .search-box {
            width: 400px;
            /* width: 80%;*/
            border: 1px solid #ccc;
            outline: 0;
            border-radius: 15px;
        }

        .search-box:focus {
            box-shadow: 0 0 15px 5px #b0e0ee;
            border: 2px solid #bebede;
        }

        .close-icon {
            border: 1px solid transparent;
            background-color: transparent;
            display: inline-block;
            vertical-align: middle;
            outline: 0;
            cursor: pointer;
        }

        .close-icon:after {
            content: "X";
            display: block;
            width: 20px;
            height: 20px;
            position: absolute;
            background-color: #dd4814;
            z-index: 1;
            right: 35px;
            top: 0;
            bottom: 0;
            margin: auto;
            padding: 2px;
            border-radius: 50%;
            text-align: center;
            color: white;
            font-weight: normal;
            font-size: 12px;
            box-shadow: 0 0 2px #E50F0F;
            cursor: pointer;
        }

        .search-box:not(:valid) ~ .close-icon {
            display: none;
        }
        #search_bar{
            padding: 5px;      
        }
        .marker_header{
            background-color: #dd4814;
            padding: 5px;
            color: #ffffff;

        }
        .address_content{
            word-wrap: break-word;
            display: block;
            width: 150px;  
        }
        .address_body td{

            padding: 2px;
        }
        .book_form{
            font-weight: 600;
            background-color: #f9c25d;
        }
        .book_form td{
            padding: 5px;

        }
        .book_form caption {
            background-color: #967b5d;
            color: #191817;
            font-weight: 600;
            text-align: center;
        }
        .modal_fields{
            padding: 5px; 
        }
        .modal_calender{
            padding: 2px; 
            /*            height: 400px;*/
        }
        .modal_calender h2{
            font-size: medium;
        }
        .modal-body{
            padding: 10px!important;
        }
.fc-event {
   background-color:#FF9800!important;
   border-color:#FF9800!important;
/*   background-color:#008000;border-color:#008000*/
}

    </style>
<style type='text/css'>
  .my-legend .legend-title {
    text-align: left;
    margin-bottom: 8px;
    font-weight: bold;
    font-size: 90%;
    }
  .my-legend .legend-scale ul {
    margin: 0;
    padding: 0;
    float: left;
    list-style: none;
    }
  .my-legend .legend-scale ul li {
    display: block;
    float: left;
    width: 80px;
    margin-bottom: 6px;
    text-align: center;
    font-size: 80%;
    list-style: none;
    }
  .my-legend ul.legend-labels li span {
    display: block;
    float: left;
    height: 15px;
    width: 75px;
    }
  .my-legend .legend-source {
    font-size: 70%;
    color: #999;
    clear: both;
    }
  .my-legend a {
    color: #777;
    }
</style>

</head>
<script>
    var events_val;
    var bHours;
</script>

<?php include "pagelayout/navbar.php" ?>

<?php include_once 'dbconfig/dbconfig.php'; ?>
<script src="assets/js/jquery.validate.min.js"></script>
<!--calender view -->
<link href='assets/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='assets/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='assets/fullcalendar/lib/moment.min.js'></script>
<!--<script src='../lib/jquery.min.js'></script>-->
<script src='assets/fullcalendar/fullcalendar.min.js'></script>
<body>

    <div class="container">
        <!--  <div class="row">

             <div id="search-wrapper" class="col-sm-6 col-sm-offset-3">
                 <div class="controls" id="search_bar">
                     <input type="text" id="pac-input" name="focus" required class="search-box" placeholder="Enter search term" />
                     <button class="close-icon" type="reset" onclick="clearautomcomplete()"></button>
                 </div>

             </div>
         </div> -->

        <!--   -->

        <div class="row">
            <div id="map-outer" class="col-md-12">

                <!--  <div id="address" class="col-md-4">
    <h2>Our Location</h2>
    <address>
    <strong>Peggy Guggenheim Collection</strong><br>
        Dorsoduro, 701-704<br>
        30123<br>
        Venezia<br>
        Italia<br>
        <abbr>P:</abbr> +39 041 240 5411
   </address>
  </div>
                -->
                <div id="search-wrapper" >
                    <div class="controls" id="search_bar">
                        <input type="text" id="pac-input" name="focus" required class="search-box" placeholder="Enter search term" />
                        <button class="close-icon" type="reset" onclick="clearautomcomplete()"></button>
                    </div>

                </div>
                <div class="map-responsive " style="" id="map"></div>

            </div>
        </div>
    </div>
    <div id="book_form" class="col-sm-3" style="display: none">
        <form class="col-sm-6" id="book_app"  name="book_app">
            <table class="book_form" >
                <caption>Book Appointment :    

                </caption>

<!--                <tr>
                    <td>Name:</td>
                    <td>
                        <input type='text' id='patient_name' required/> </td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>
                        <input type='text' id='patient_phone' required /> </td>
                </tr>-->


                <tr><td>Date:</td>
                    <td>

                        <input type="text" id="datepicker" name="datepicker" style="width: 100px;" />
                    </td>
                </tr>
                <tr><td>Time:</td>
                    <td>  <p>  <input id="selectTime"  name="selectTime" type="text" class="time" />
                            <span id="selectTimeTarget" style="margin-left: 30px;"></span></p></td></tr>
                <tr>
                    <td><label for="select_doc_specialty">Speciality Name :</label></td>
                    <td style="width: 100px;" >
                        <select id="select_doc_specialty"  class="selectpicker" name="select_doc_specialty" data-width="50%" style="width: 100px;" >
                            <?php
                            $speciality_cdquery = "SELECT DISTINCT speciality_name FROM specialities";
                            $speciality_cdresult = mysqli_query($db_handle, $speciality_cdquery) or die("Query to get data from firsttable failed: " . mysqli_error($db_handle));
                            echo '<option value="">SPECIALITY</option>';
                            while ($speciality_cdrow = mysqli_fetch_array($speciality_cdresult, MYSQLI_ASSOC)) {
                                $speciality_name = $speciality_cdrow["speciality_name"];
                                echo "<option>$speciality_name</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>    

                <tr>
                    <td>Location:</td>
                    <td>
                        <select id="place"  class="selectpicker" name="place" data-width="50%" >
                            <?php
                            $default_location_cdquery = "SELECT DISTINCT name FROM default_location";
                            $default_location_cdresult = mysqli_query($db_handle, $default_location_cdquery) or die("Query to get data from firsttable failed: " . mysqli_error($db_handle));
                            echo '<option value="">SELECT</option>';
                            while ($default_location_cdrow = mysqli_fetch_array($default_location_cdresult, MYSQLI_ASSOC)) {
                                $name = $default_location_cdrow["name"];
                                echo "<option>$name</option>";
                            }
                            ?>
                        </select>
                </tr>    
                <tfoot>
                    <tr>
                      <!--   <input id="place"  name="place" type="text" value="madurai"/></td> -->
                        <td colspan="2" align="left">
                            <input type='button' class="btn-primary" value='Search' id="Search_app" />

                            <input type='reset' class="btn-primary" value='Clear' id="clear_btn" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>

    </div>
    <div id="message" style="display: none">Location saved</div>
    <div id="book-bar" class="book-bar" style="display: block"><button type="button" id="book_btn" class="btn btn-info">
            <span class="glyphicon glyphicon-new-window"></span> Book
        </button></div>

    <script>
        $(function () {
            /*$('#disableTimeRangesExample').timepicker({ 'disableTimeRanges': [['2pm', '3pm'], ['5pm', '6pm']],'minTime': '2:00pm',
             'maxTime': '8:30pm', });*/
            $('#selectTime').timepicker(
//                    {'disableTimeRanges': [['2pm', '3pm'], ['5pm', '6pm']], 'minTime': '2:00pm',
//                'maxTime': '8:30pm', }
                    );
            $('#selectTime').on('changeTime', function () {
                $('#selectTimeTarget').text($(this).val());
            });
            $('#c_time').timepicker(
//                    {'disableTimeRanges': [['2pm', '3pm'], ['5pm', '6pm']], 'minTime': '2:00pm',
//                'maxTime': '8:30pm', }
                    );
            $('#c_time').on('changeTime', function () {
                $('#c_time_label').text($(this).val());
            });
            $('#c_select_doc_specialty').on('change', function () {
                $('#c_select_doc_specialty_label').text($(this).val());
                var hosp_name = $('#c_hos_name').text();
                var spec = $('#c_select_doc_specialty_label').text();
                if(spec!="")
                {
                $('#c_select_doctor_label').text( '');
                getHospitalDoctors(hosp_name, spec);
                updateCalendar(hosp_name,"ALL");
            }
            else
            {
                 $('#c_select_doctor_label').text( '');
                getHospitalDoctors(hosp_name, "ALL");
                updateCalendar(hosp_name,"ALL");
            }
                
                
            });
            $('#c_select_doctor').on('change', function () {
               // $('#c_select_doctor_label').text($(this).val());
                var hosp_name = $('#c_hos_name').text();
                var doc_id = $(this).val();
                $('#c_select_doctor_label').text( $("#c_select_doctor option:selected").text());
                
                $.getJSON('get_all_userevents.php', {email: "<?php echo $_SESSION['email']; ?>",hosp_name:hosp_name,doc_id:doc_id}, function (obj) {
                    //var parsed_data = JSON.parse(obj);
                    //var events_obj = obj.events;
                    events_val = obj.events;
                    // console.log(events_obj);
                    console.log(events_val);
                    $.getJSON('getdoctortime.php', {email: "<?php echo $_SESSION['email']; ?>",hosp_name:hosp_name,doc_id:doc_id}, function (obj) {
                        //var parsed_data = JSON.parse(obj);
                        bHours = obj.bhours;
                        $('#calendar').fullCalendar('render');
                        console.log(bHours);
                        calenderView();
                        $('#calendar').fullCalendar('removeEvents');
                           $('#calendar').fullCalendar('addEventSource', events_val);
                            $('#calendar').fullCalendar('rerenderEvents');
                             $('#c_select_doctor_label').val("");
                        $('#confirm_booking_modal').modal('show');
                    });
                });
                
               
                //    var hosp_name = $('#c_hos_name').text();
//                var spec = $('#c_select_doc_specialty_label').text();
//                getHospitalDoctors(hosp_name, spec);
            });


        });
        /*function reinittimer(options)
         {
         $.get("gettime.php", function (data, status) {
         //alert("Data: " + data + "\nStatus: " + status);
         $('#selecttestcasedp').html(status);
         $('#selecttestcasedp').selectpicker('refresh');
         console.log(data);
         console.log(status);
         });
         }*/

function updateCalendar(hosp_name,doc_id)
{
    if(doc_id=="")
    {
        doc_id=0;
    }
    $.getJSON('get_all_userevents.php', {email: "<?php echo $_SESSION['email']; ?>",hosp_name:hosp_name,doc_id:doc_id}, function (obj) {
                    //var parsed_data = JSON.parse(obj);
                    //var events_obj = obj.events;
                    events_val = obj.events;
                    // console.log(events_obj);
                    console.log(events_val);
                    $.getJSON('getdoctortime.php', {email: "<?php echo $_SESSION['email']; ?>",hosp_name:hosp_name,doc_id:doc_id}, function (obj) {
                        //var parsed_data = JSON.parse(obj);
                        bHours = obj.bhours;
                        $('#calendar').fullCalendar('render');
                        console.log(bHours);
                        calenderView();
                        $('#calendar').fullCalendar('removeEvents');
                           $('#calendar').fullCalendar('addEventSource', events_val);
                            $('#calendar').fullCalendar('rerenderEvents');
                             $('#c_select_doctor_label').val("");
                        $('#confirm_booking_modal').modal('show');
                    });
                });
    }

    </script>


    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirm_booking_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Confirm Booking</h4>
                </div>
                <div class="modal-body">
                    <form  id="confirm_booking_form" role="form">
                        <input type="hidden" name="event_keys" id="event_keys"/>

                        <div class="modal_fields control-group">
                            <label for="c_patient_name">Patient Name</label>
                            <input type="text" class="form-control sm-input" name="c_patient_name" id="c_patient_name" placeholder="Patient Name" required>
                        </div>
                        <div class="modal_fields control-group">
                            <label  for="c_patient_phone">Phone No</label>
                            <input type="text" class="form-control sm-input" name="c_patient_phone" id="c_patient_phone" placeholder="Phone No" required>
                        </div>
                        <div class="col-md-12" >
                            <div class="modal_fields control-group col-md-6" >
                                <label  id="c_select_doc_specialty_Text" >Speciality : </label>
                                <select id="c_select_doc_specialty"  class="selectpicker" name="c_select_doc_specialty" data-width="50%" >
                                    <?php
                                    $speciality_cdquery = "SELECT DISTINCT speciality_name FROM specialities";
                                    $speciality_cdresult = mysqli_query($db_handle, $speciality_cdquery) or die("Query to get data from firsttable failed: " . mysqli_error($db_handle));
                                    echo '<option value="">SPECIALITY</option>';
                                    while ($speciality_cdrow = mysqli_fetch_array($speciality_cdresult, MYSQLI_ASSOC)) {
                                        $speciality_name = $speciality_cdrow["speciality_name"];
                                        echo "<option>$speciality_name</option>";
                                    }
                                    ?>
                                </select> 
                                <span  id="c_select_doc_specialty_label" ></span> 
                            </div>

                            <div class="modal_fields control-group col-md-6">
                                <label  id="c_select_doctor_Text" >Doctors : </label>
                                <select id="c_select_doctor"  class="selectpicker" name="c_select_doctor" data-width="50%" >
                                    <option value="">Doctors</option>

                                </select> 
                                <span  id="c_select_doctor_label" ></span> 
                            </div>
                        </div>
                        <div class="modal_fields control-group" style="display: none">
                            <label  id="c_date_Text" >Date : </label>
                            <input type="text" id="c_datepicker" name="c_datepicker" required/>
                        </div>
                        <div class="modal_fields control-group" style="display: none">
                            <label  id="c_time_Text" >Time : </label>
                            <input id="c_time"  name="c_time" type="text" class="time" required/>
                            <span  id="c_time_label" ></span> 
                        </div>
                        <div class="modal_calender control-group">
                            <div id='calendar'></div>
                                </div>
                         <div class="modal_fields control-group">
                            <div class='my-legend'>
<div class='legend-title'>Booking Status</div>
<div class='legend-scale'>
  <ul class='legend-labels'>
    <li><span style='background:#FF9800;'></span>New</li>
    <li><span style='background:#008000;'></span>Confirmed</li>
    <li><span style='background:#0071c5;'></span>Completed</li>
    <li><span style='background:#FF0000;'></span>Rejected</li>
    <li><span style='background:#d7d7d7;'></span>Non Business Hours</li>
    <li><span style='background:#c09853;'></span>Expired</li>
  </ul>
</div>
<div class='legend-source'></div>
</div>
                        </div>
                    
                        

                        <div class="modal_fields control-group">
                            <label for="c_hos_name" >Hospital Name : </label>
                            <span id="c_hos_name" >NA</span>
                        </div>
                        <div class="modal_fields control-group">
                            <label for="c_hos_address" >Hospital Address : </label>
                            <div ><span id="c_hos_address"></span></div> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" name="btn-confirmbooking" id="btn-confirmbooking"  class="btn btn-success">Submit</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="booking_results" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Booking Confirmed @  <span id="b_hos_name"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal_fields control-group">
                        <label for="book_id" >ID : </label>
                        <span id="book_id" >NA</span>
                    </div>
                  
                    <div class="modal_fields control-group">
                        <label>Booking Details : </label>
                        <div >
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>   <label for="b_name" >Name</label></td>
                                    <td> <label for="b_phone" >Phone</label></td>
                                    <td>  <label for="doc_name" >Doctor_name</label></td>
                                </tr>
                                <tr>
                                    <td><span id="b_name"></span></td>
                                    <td><span id="b_phone"></span></td>
                                    <td> <span id="b_doc_name"></span></td>
                                </tr>
                            </table>
                            <table  id="booking_list" class="table table-striped table-bordered">
                                 <tr>
                                    <td>   <label for="Id" >book_key</label></td>
                                    <td>  <label for="s_time" >Start Time</label></td>
                                    <td>  <label for="e_time" >End Time</label></td>
                                </tr>
                            </table>

                        </div> 
                        <div >
                            <label for="book_id" >Hospital Address : </label>
                            <span id="b_hos_address"></span>
                        </div> 
                    </div>

                    <div class="modal_fields control-group">
                        <a href="index.php" class="btn btn-info" >Okay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="result_count" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Search Result</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <label id="result_no">no records found</label>
                    </div>


                </div>

            </div>
        </div>
    </div>


    <script type="text/javascript">
        function showbooking() {

            var datepicker = document.getElementById("datepicker");
            var c_datepicker = document.getElementById("c_datepicker");
            var selectTime = document.getElementById("selectTime");
            var map_loc_name = document.getElementById("map_loc_name");
            var map_loc_address = document.getElementById("map_loc_address");
            var c_hos_name = document.getElementById("c_hos_name");
            var c_hos_address = document.getElementById("c_hos_address");
            var c_time = document.getElementById('c_time');
            var c_time_label = document.getElementById('c_time_label');
            var select_doc_specialty = document.getElementById('select_doc_specialty');
            /* var c_select_doc_specialty = document.getElementById('c_select_doc_specialty');*/
            var c_select_doc_specialty_label = document.getElementById('c_select_doc_specialty_label');

            /* c_select_doc_specialty.value = select_doc_specialty.value;*/
            c_select_doc_specialty_label.innerHTML = select_doc_specialty.value;
             var c_select_doctor_label = document.getElementById('c_select_doctor_label');

            /* c_select_doc_specialty.value = select_doc_specialty.value;*/
            c_select_doctor_label.innerHTML = '';
            console.log(map_loc_name.textContent);
            c_datepicker.value = datepicker.value;
            c_time.value = selectTime.value;
            c_time_label.innerHTML = selectTime.value;
            c_hos_name.innerHTML = map_loc_name.textContent;
            c_hos_address.innerHTML = map_loc_address.textContent;
            var specialty_label = "ALL";
            if (select_doc_specialty.value != "")
            {
                specialty_label = select_doc_specialty.value;
            }
            console.log(specialty_label);

            getHospitalDoctorsSpecialities(map_loc_name.textContent);
            getHospitalDoctors(map_loc_name.textContent, specialty_label);
            $(document).ready(function () {
                $.getJSON('get_all_userevents.php', {email: "<?php echo $_SESSION['email']; ?>",hosp_name:map_loc_name.textContent}, function (obj) {
                    //var parsed_data = JSON.parse(obj);
                    //var events_obj = obj.events;
                    events_val = obj.events;
                    // console.log(events_obj);
                    console.log(events_val);
                    $.getJSON('getdoctortime.php', {email: "<?php echo $_SESSION['email']; ?>",hosp_name:map_loc_name.textContent}, function (obj) {
                        //var parsed_data = JSON.parse(obj);
                        bHours = obj.bhours;
                        $('#calendar').fullCalendar('render');
                        console.log(bHours);
                        calenderView();
                        $('#calendar').fullCalendar('removeEvents');
                           $('#calendar').fullCalendar('addEventSource', events_val);
                            $('#calendar').fullCalendar('rerenderEvents');
                             $('#c_select_doctor_label').val("");
                        $('#confirm_booking_modal').modal('show');
                    });
                });
            });

            // console.log(x);
        }
        function getHospitalDoctorsSpecialities(hospname) {
            var url = "getdoctorspecialities.php?hosp_name=" + hospname;
            $.getJSON(url, function (obj) {
                //var c_select_doc_specialty = document.getElementById('c_select_doc_specialty');
                var splist = obj.specialities;
                $('#c_select_doc_specialty').empty();
                var newOption = $('<option>');
                newOption.attr('value', 'ALL').text("ALL");
                $('#c_select_doc_specialty').append(newOption);
                $.each(splist, function (index, value) {
                    var newOption = $('<option>');
                    newOption.attr('value', value).text(value);
                    newOption.attr('value', value).text(value);
                    $('#c_select_doc_specialty').append(newOption);

                });
            }).fail(function () {
                alert('Unable to fetch data, please try again later.')
            });
        }
        function getDoctorTime(hospname, doctor_email) {

        }
        function getHospitalDoctors(hospname, speciality) {
            var url = "getdoctordetails.php?hosp_name=" + hospname + "&speciality=" + speciality;
            $.getJSON(url, function (obj) {

                var splist = obj.doctors;
                $('#c_select_doctor').empty();
                if(speciality=="ALL")
                {
                var newOption = $('<option>');
                newOption.attr('value', 'ALL').text("ALL");
                $('#c_select_doctor').append(newOption);
            }
                $.each(splist, function (index, doctor) {
                    console.log(doctor);
                    var newOption = $('<option>');
                    newOption.attr('value', doctor.doctor_id).text(doctor.firstname);
                    $('#c_select_doctor').append(newOption);

                });
            }).fail(function () {
                alert('Unable to fetch data, please try again later.')
            });
        }
        function clearautomcomplete() {
            $("#pac-input").blur();
            setTimeout(function () {
                $("#pac-input").val('');
                $("#pac-input").focus();
            }, 10);
            placeMarker(null);
            infowindow.close();
            map.fitBounds(bounds);
        }
    </script>
    <script>
        var map;
        var marker;
        var infowindow;
        var messagewindow;
        var geocoder;
        var bounds;
        //var 

        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    draggable: true,
                    map: map
                });

            }
            placeMarkerDetails(marker);
        }

        function placeMarkerDetails(marker) {
            geocoder.geocode({
                'latLng': marker.getPosition()
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var address = results[0].formatted_address;
                        var latitude = marker.getPosition().lat();
                        var longitude = marker.getPosition().lng();

                        var infowincontent = document.createElement('div');
                        infowincontent.style.cssText = 'width: 180px;'
                        var strong = document.createElement('strong');
                        strong.textContent = name
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));

                        var text = document.createElement('text');

                        text.textContent = results[0].formatted_address
                        infowincontent.appendChild(text);
                        infowincontent.appendChild(document.createElement('br'));
                        var lat = document.createElement('text');
                        lat.textContent = "lat : " + latitude;
                        infowincontent.appendChild(lat);
                        infowincontent.appendChild(document.createElement('br'));
                        var lng = document.createElement('text');
                        lng.textContent = "lng : " + longitude;
                        infowincontent.appendChild(lng);

                        infowindow.setContent(infowincontent);
                        infowindow.open(map, marker);
                    }
                }
            });
        }
        var customLabel = {
            Clinic: {
                label: 'img/doctor.png'
            },
            Hospital: {
                label: 'img/hospital-red.png'
            },
            Default: {
                label: 'img/hospital.png'
            }
        };
//         var loc = {
//    default_loc: []
//};
        var default_loc;
        function getDefaultLocation(url)
        {
            downloadUrl(url, function (data) {

                var xml = data.responseXML;
                console.log(xml);
                markersdata = xml.documentElement.getElementsByTagName('marker');

                Array.prototype.forEach.call(markersdata, function (markerElem) {
                    var doc_id = markerElem.getAttribute('id');
                    var name = markerElem.getAttribute('name');
                    var latitude = markerElem.getAttribute('lat');
                    var longitude = markerElem.getAttribute('lng');

                    default_loc = new google.maps.LatLng(
                            parseFloat(latitude),
                            parseFloat(longitude));
                    map.panTo(default_loc);
                    //default_loc.lat = parseFloat(latitude);
                    // default_loc.lng = parseFloat(longitude);
//                            loc.default_loc.push({
//                                lat : parseFloat(latitude),
//                                lng : parseFloat(longitude)
//                            });
                    console.log(default_loc.lat);
                    //console.log(chennai.valueOf());



                });
            });
        }
        var infoWind, city;
        function getcurretLoc()
        {
            infoWind = new google.maps.InfoWindow;
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    console.log(position);
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    codeLatLng(pos.lat, pos.lng);

                    infoWind.setPosition(pos);

                    infoWind.open(map);
                    map.setCenter(pos);
                }, function () {
                    handleLocationError(true, infoWind, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWind, map.getCenter());
            }

        }


        var chennai = {
            lat: 13.0826802,
            lng: 80.2707184
        };
        function initMap() {
            // start of search
            geocoder = new google.maps.Geocoder();


            map = new google.maps.Map(document.getElementById('map'), {
                center: chennai,
                zoom: 13,
                draggable: true,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    mapTypeIds: ['roadmap', 'terrain', 'satellite'],
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
                fullscreenControl: true,
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT
                }

            });
            getcurretLoc();
            getDefaultLocation("getdefaultlocation.php?default_location=" +<?php echo $selectLocation ?>);

            // start autom complete
            // Create the search box and link it to the UI element.
            var book_form = document.getElementById('book_form');
            var input = document.getElementById('pac-input');
            var search_bar = document.getElementById('search-wrapper');
            var book_bar = document.getElementById('book-bar');

            var searchBox = new google.maps.places.SearchBox(input);
            /*map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);*/
            //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(search_bar);
            map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(book_bar);
            map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(book_form);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function (marker) {
                    // marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    /* // Create a marker for each place.
                     markers.push(new google.maps.Marker({
                     map: map,
                     icon: icon,
                     title: place.name,
                     position: place.geometry.location
                     }));*/
                    // Create a marker for each place.
                    markers.push(
                            placeMarker(place.geometry.location)

                            );

                    google.maps.event.addListener(marker, 'click', function () {
                        /* infowindow.content.style.cssText="display:block";
                         infowindow.open(map, marker);*/

                        placeMarkerDetails(marker);
                        console.log(event.latLng);
                    });
                    google.maps.event.addListener(marker, 'dragend', function () {
                        placeMarkerDetails(marker);
                    });

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });

            // end of autom complete

            infowindow = new google.maps.InfoWindow({
                content: document.getElementById('form')
            });

            messagewindow = new google.maps.InfoWindow({
                content: document.getElementById('message')
            });

            google.maps.event.addListener(map, 'click', function (event) {
                /*marker = new google.maps.Marker({
                 position: event.latLng,
                 map: map
                 });*/
                placeMarker(event.latLng);
                placeMarkerDetails(marker);
                console.log(event.latLng);
                google.maps.event.addListener(marker, 'click', function () {
                    /* infowindow.content.style.cssText="display:block";
                     infowindow.open(map, marker);*/

                    placeMarkerDetails(marker);
                    console.log(event.latLng);
                });

                google.maps.event.addListener(marker, 'dragend', function () {
                    console.log(marker);
                    /*geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                     if (results[0]) {
                     $('#address').val(results[0].formatted_address);
                     $('#latitude').val(marker.getPosition().lat());
                     $('#longitude').val(marker.getPosition().lng());
                     infowindow.content.style.cssText="display:block";
                     infowindow.open(map, marker);
                     }
                     }
                     });*/

                    placeMarkerDetails(marker);
                });
            });

            // end of search

            //view data in map



            // Change this depending on the name of your PHP or XML file
            getMapContent('get_all_address.php');
        }

        var markersArray = [];
        var markersdata = [];

        function DeleteMarkers() {
            //Loop through all the markersArray and remove markers
            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
            markersArray = [];
            markersdata.length = 0;
        }

        function getMapContent(url)
        {
            var infoWindow = new google.maps.InfoWindow;
            //get_all_address.php
            downloadUrl(url, function (data) {

                var xml = data.responseXML;
                console.log(xml);
                markersdata = xml.documentElement.getElementsByTagName('marker');
                console.log(markersdata.length);
                if (markersdata.length > 0)
                {
                    Array.prototype.forEach.call(markersdata, function (markerElem) {
                        var doc_id = markerElem.getAttribute('id');
                        var name = markerElem.getAttribute('name');
                        var address = markerElem.getAttribute('address');
                        var type = markerElem.getAttribute('type');
                        var latitude = markerElem.getAttribute('lat');
                        var longitude = markerElem.getAttribute('lng');

                        var point = new google.maps.LatLng(
                                parseFloat(markerElem.getAttribute('lat')),
                                parseFloat(markerElem.getAttribute('lng')));







                        var infowincontent = document.createElement('div');
                        var idform = document.createAttribute("id");
                        idform.value = "form";
                        var classform = document.createAttribute("class");
                        classform.value = "col-sm-12";
                        var classform = document.createAttribute("style");
                        classform.value = "display: block; width: 500px;";





                        infowincontent.style.cssText = 'max-width: 250px;'
                        var strong = document.createElement('strong');
                        strong.textContent = name
                        var idstrong = document.createAttribute("id");
                        idstrong.value = "map_loc_name";
                        strong.setAttributeNode(idstrong);
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));

                        var text = document.createElement('text');

                        text.textContent = address
                        var idaddress = document.createAttribute("id");
                        idaddress.value = "map_loc_address";
                        text.setAttributeNode(idaddress);
                        infowincontent.appendChild(text);
                        infowincontent.appendChild(document.createElement('br'));
                        var lat = document.createElement('text');
                        lat.textContent = "lat : " + latitude;
                        infowincontent.appendChild(lat);
                        infowincontent.appendChild(document.createElement('br'));
                        var lng = document.createElement('text');
                        lng.textContent = "lng : " + longitude;
                        infowincontent.appendChild(lng);
                        infowincontent.appendChild(document.createElement('br'));
                        var addform = document.createElement('input');
                        var typeform = document.createAttribute("type");
                        typeform.value = "button";
                        var idform = document.createAttribute("id");
                        idform.value = doc_id;
                        var btnonclick = document.createAttribute("onclick");
                        btnonclick.value = "showbooking()";
                        var btnval = document.createAttribute("value");
                        btnval.value = "showbooking";
                        addform.setAttributeNode(typeform);
                        addform.setAttributeNode(idform);
                        addform.setAttributeNode(btnonclick);
                        addform.setAttributeNode(btnval);
                        infowincontent.appendChild(addform);
                        var bookform = document.createElement('div');
                        var idform = document.createAttribute("id");
                        idform.value = "bookform";
                        var att = document.createAttribute("class");
                        att.value = "hideform";

                        bookform.setAttributeNode(idform);
                        bookform.setAttributeNode(att);
                        infowincontent.appendChild(bookform);

                        /* var infowincontent = document.createElement('div');
                         var idform = document.createAttribute("id");
                         idform.value = "form";
                         var classform = document.createAttribute("class");
                         classform.value = "col-sm-12";
                         var styleform = document.createAttribute("style");
                         styleform.value = "display: block; width: 500px;";
                         infowincontent.setAttributeNode(idform);
                         infowincontent.setAttributeNode(classform);
                         infowincontent.setAttributeNode(styleform);
                         
                         var h4Text = document.createElement('h4');
                         var classh4 = document.createAttribute("class");
                         classh4.value = "marker_header";
                         h4Text.setAttributeNode(classh4);
                         h4Text.textContent = name;
                         infowincontent.appendChild(h4Text);
                         
                         var addbody = document.createElement('div');
                         var idaddbody = document.createAttribute("id");
                         idaddbody.value = "address_body";
                         var classaddbody = document.createAttribute("class");
                         classaddbody.value = "address_body col-sm-6";
                         addbody.setAttributeNode(idaddbody);
                         addbody.setAttributeNode(classaddbody);
                         
                         var table = document.createElement('table');
                         var tr1 = document.createElement('tr');
                         var td11 = document.createElement('td');
                         td11.textContent="Name"
                         
                         
                         var td12 = document.createElement('td');
                         
                         var inputname = document.createElement('input');
                         var textid = document.createAttribute("id");
                         textid.value = "patient_name";
                         var textname = document.createAttribute("type");
                         textname.value = "text";
                         inputname.setAttributeNode(textname);
                         inputname.setAttributeNode(textid);
                         //inputname.value = name;
                         td12.appendChild(inputname);
                         tr1.appendChild(td11);
                         tr1.appendChild(td12);
                         
                         var tr2 = document.createElement('tr');
                         var td21 = document.createElement('td');
                         td21.textContent="Phone"
                         
                         
                         var td22 = document.createElement('td');
                         
                         var inputname2 = document.createElement('input');
                         var textid2 = document.createAttribute("id");
                         textid2.value = "patient_name";
                         var textname2 = document.createAttribute("type");
                         textname2.value = "text";
                         inputname2.setAttributeNode(textname2);
                         inputname2.setAttributeNode(textid2);
                         //inputname.value = name;
                         td22.appendChild(inputname2);
                         tr2.appendChild(td21);
                         tr2.appendChild(td22);
                         
                         
                         var tr3 = document.createElement('tr');
                         var td31 = document.createElement('td');
                         td31.textContent="Time : "
                         
                         
                         var td32 = document.createElement('td');
                         var p32 = document.createElement('p');
                         var inputname3 = document.createElement('input');
                         var textid3 = document.createAttribute("id");
                         textid3.value = "disableTimeRangesExample";
                         
                         var textname3 = document.createAttribute("type");
                         textname3.value = "text";
                         var classname3 = document.createAttribute("class");
                         classname3.value = "time";
                         inputname3.setAttributeNode(textname3);
                         inputname3.setAttributeNode(textid3);
                         inputname3.setAttributeNode(classname3);
                         
                         var spanname3 = document.createElement('span');
                         var spanid3 = document.createAttribute("id");
                         spanid3.value = "disableTimeRangesExampleTarget";
                         
                         var spanstyle3 = document.createAttribute("type");
                         spanstyle3.value = "margin-left: 30px;";
                         var spanfocus3 = document.createAttribute("onfocus");
                         spanfocus3.value = "calltimer()";
                         spanname3.setAttributeNode(spanid3);
                         spanname3.setAttributeNode(spanstyle3);
                         spanname3.setAttributeNode(spanfocus3);
                         p32.appendChild(inputname3);
                         p32.appendChild(spanname3);
                         td32.appendChild(p32);
                         tr3.appendChild(td31);
                         tr3.appendChild(td32);
                         
                         
                         
                         table.appendChild(tr1);
                         table.appendChild(tr2);
                         table.appendChild(tr3);
                         addbody.appendChild(table);
                         
                         infowincontent.appendChild(addbody);
                         
                         
                         var addcont = document.createElement('div');
                         var idaddcont = document.createAttribute("id");
                         idaddcont.value = "address_content";
                         var classaddcont = document.createAttribute("class");
                         classaddcont.value = "address_content col-sm-6";
                         addcont.setAttributeNode(idaddcont);
                         addcont.setAttributeNode(classaddcont);
                         var addstrong = document.createElement('strong');
                         addstrong.textContent ="Location Details : "
                         var addspanbr = document.createElement('br');
                         var addspanadd = document.createElement('span');
                         var idaddspanadd = document.createAttribute("id");
                         idaddspanadd.value = "address";
                         addspanadd.textContent = address;
                         addspanadd.setAttributeNode(idaddspanadd);
                         var addspanbr1 = document.createElement('br');
                         var addspanadd2 = document.createElement('span');
                         var idaddspanadd2 = document.createAttribute("id");
                         idaddspanadd2.value = "latitude";
                         addspanadd2.setAttributeNode(idaddspanadd2);
                         addspanadd2.textContent = "lat:"+latitude
                         var addspanbr2 = document.createElement('br');
                         var addspanadd3 = document.createElement('span');
                         var idaddspanadd3 = document.createAttribute("id");
                         idaddspanadd3.value = "longitude";
                         addspanadd3.setAttributeNode(idaddspanadd3);
                         addspanadd3.textContent = "lng:"+longitude;
                         var addspanbr3 = document.createElement('br');
                         
                         addcont.appendChild(addstrong);
                         addcont.appendChild(addspanbr);
                         addcont.appendChild(addspanadd);
                         addcont.appendChild(addspanbr1);
                         addcont.appendChild(addspanadd2);
                         addcont.appendChild(addspanbr2);
                         addcont.appendChild(addspanadd3);
                         addcont.appendChild(addspanbr3);
                         
                         infowincontent.appendChild(addcont);*/



                        var date_filter = "{ 'disableTimeRanges': [['2pm', '3pm'], ['5pm', '6pm']],'minTime': '2:00pm','maxTime': '8:30pm', }";

                        var image = customLabel[type] || {};
                        // var image = 'img/hospital.png';
                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            icon: image.label,
                            customInfoName: name
                                    /*customdate_filter: date_filter*/

                        });
                        markersArray.push(marker);
                        marker.addListener('click', function () {
                            /* var formcontent = document.getElementById("form");
                             infowincontent.appendChild(formcontent);*/
                            console.log(marker.position);
                            $('#name').val(marker.customInfoName);
                            /* reinittimer(marker.customdate_filter);*/

                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                        });
                    });
                } else
                {
                    console.log(markersdata.length);
                    showresults();
                }
            });
        }

        function constructMarkerDetails()
        {
            var span = document.getElementById('address');
            if (span != null)
            {
                while (span.firstChild) {
                    span.removeChild(span.firstChild);
                }
                span.appendChild(document.createTextNode(address));
            }

            var latitude = document.getElementById('latitude');
            if (latitude != null)
            {
                while (latitude.firstChild) {
                    latitude.removeChild(latitude.firstChild);
                }
                latitude.appendChild(document.createTextNode("lat : " + latitude));
            }
            var longitude = document.getElementById('longitude');
            if (longitude != null)
            {
                while (longitude.firstChild) {
                    longitude.removeChild(longitude.firstChild);
                }
                longitude.appendChild(document.createTextNode("lng : " + longitude));
            }
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                    new ActiveXObject('Microsoft.XMLHTTP') :
                    new XMLHttpRequest;

            request.onreadystatechange = function () {
                if (request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }

        function doNothing() {}
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCphOSKQQie7vS98SET868Ljvx-lAJ-gTY&libraries=places&callback=initMap">
    </script>
</body>
<script type="text/javascript" src="assets/css/datepicker/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker/jquery.timepicker.css" />

<script type="text/javascript" src="assets/css/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker/bootstrap-datepicker.css" />

<script type="text/javascript" src="assets/css/datepicker/site.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker/site.css" />
<link rel='stylesheet' type='text/css' href='assets/jquery-ui-1.12.1/jquery-ui.css'/>

<script src="assets/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script>
        var events_obj;
//fix for multiple modal with scroll
        $(document).ready(function () {
            //refreshCal();
            $('.modal').on('hidden.bs.modal', function (e) {
                if ($('.modal').hasClass('in')) {
                    $('body').addClass('modal-open');
                }
            });

//            $.getJSON('get_all_userevents.php', {email: "<?php echo $_SESSION['email']; ?>"}, function (obj) {
//                //var parsed_data = JSON.parse(obj);
//                //var events_obj = obj.events;
//                events_val = obj.events;
//                // console.log(events_obj);
//                console.log(events_val);
//                $.getJSON('getdoctortime.php', {email: "<?php echo $_SESSION['email']; ?>"}, function (obj) {
//                    //var parsed_data = JSON.parse(obj);
//                    bHours = obj.bhours;
//                    $('#calendar').fullCalendar('render');
//                    console.log(bHours);
//                });
//            });
            $('#AddCalendarApp').on('hide.bs.modal', function () {
                //$("#calendar").empty();
                // remove the bs.modal data attribute from it
                clearModalForm('AddCalendarApp');
                calenderView();
                $("#calendar").fullCalendar('render');

            });
            //calenderView();
            $('#confirm_booking_modal').on('shown.bs.modal', function () {
                $("#calendar").fullCalendar('render');
            });
            $("#book_app").validate({
                rules: {
                    datepicker: {
                        required: true,
                    },
                    selectTime: {
                        required: true,
                    }
                },
                focusInvalid: false,
                messages: {
                    datepicker: "Please specify appointment date",
                    selectTime: "Please specify the appointment time"

                }

            });
            $("#confirm_booking_form").validate({
                rules: {
                    c_datepicker: {
                        required: true,
                    },
                    c_time: {
                        required: true,
                    },
                    c_patient_name: {
                        required: true,
                    },
                    c_patient_phone: {
                        required: true,
                    }
                },
                focusInvalid: false,
                messages: {
                    c_datepicker: "Please specify appointment date",
                    c_time: "Please specify the appointment time",
                    c_patient_name: "Please specify the Patient name",
                    c_patient_phone: "Please specify the contact phone no",

                }

            });
            $('#add_calendar_eventbtn').click(function () {
                var c_patient_na = document.getElementById("c_patient_name");
                var cal_event_description = document.getElementById("cal_event_description");
                var cal_event_title = document.getElementById("cal_event_title");
                var cal_event_start = document.getElementById("cal_event_start");
                var cal_event_end = document.getElementById("cal_event_end");
                var c_hos_name = document.getElementById("c_hos_name");
                $.ajax({
                    type: "POST",
                    url: "add_calendar_event.php",
                    data: {
                        title: cal_event_title.value,
                        start: cal_event_start.value,
                        end: cal_event_end.value,
                        color: '#FFEB3B',
                       // color: '#0071c5',
                        description: cal_event_description.value,
                        email: "<?php echo $_SESSION['email']; ?>",
                        patient: c_patient_na.value,
                    },
                    success: function (obj) {
                        var parsed_data = JSON.parse(obj);
                        var from_id = parsed_data.key;
                        var event_key = $('#event_keys').val();
                        console.log(event_key);
                        if (event_key == "")
                        {
                            event_key = from_id;
                        } else {
                            event_key += "," + from_id;
                        }
                        $('#event_keys').val(event_key);
                        console.log(from_id);
                        var event_k = $('#event_keys').val();
                        console.log(event_k);
                        $('#AddCalendarApp').modal('hide');
                        $.getJSON('get_all_userevents.php', {email: "<?php echo $_SESSION['email']; ?>",hosp_name:c_hos_name.textContent,temp_b_keys:event_k}, function (obj1) {
                            //var parsed_data = JSON.parse(obj);
                            var events_obj = obj1.events;
                            $('#calendar').fullCalendar('removeEvents');
                            $('#calendar').fullCalendar('addEventSource', events_obj);
                            $('#calendar').fullCalendar('rerenderEvents');
                            events_val = obj1.events;
                            console.log(events_val);

                        });

                        // calenderView();

                    }
                });

            });
            $('#edit_calendar_eventbtn').click(function () {
                var edit_cal_event_description = document.getElementById("edit_cal_event_description");
                var edit_cal_event_title = document.getElementById("edit_cal_event_title");
                var delete_event;
                if ($('#delete_event').is(':checked')) {
                    delete_event = "Y";
                }
                console.log(delete_event);
                var edit_cal_event_key = document.getElementById("edit_cal_event_key");
                $.ajax({
                    type: "POST",
                    url: "edit_calendar_event.php",
                    data: {
                        title: edit_cal_event_title.value,
                        book_key: edit_cal_event_key.value,
                        del_event: delete_event,
                        description: edit_cal_event_description.value
                    },
                    success: function (obj) {
                        var event_key = $('#event_keys').val();
                        if (event_key.indexOf(",") != -1) {
                            var array = event_key.split(",");
                            array.splice($.inArray(edit_cal_event_id.value, array), 1);
                            var event_key_n;
                            for (i = 0; i < array.length; i++)
                            {
                                if (i = 0)
                                {
                                    event_key_n = array[i];
                                } else
                                {
                                    event_key_n += "," + array[i];
                                }
                            }

                        } else {
                            if (event_key == edit_cal_event_id.value)
                            {
                                event_key = edit_cal_event_id.value;
                            } else {
                            }

                        }

                        $('#EditCalendarApp').modal('hide');
                        $.getJSON('get_all_userevents.php', {email: "<?php echo $_SESSION['email']; ?>"}, function (obj1) {
                            //var parsed_data = JSON.parse(obj);
                            var events_obj = obj1.events;
                            $('#calendar').fullCalendar('removeEvents');
                            $('#calendar').fullCalendar('addEventSource', events_obj);
                            $('#calendar').fullCalendar('rerenderEvents');
                            events_val = obj1.events;
                            console.log(events_val);

                        });
                    }
                });
            });
            $('#btn-confirmbooking').click(function () {

                if ($("#confirm_booking_form").valid()) {
                  
                    console.log("valid");
                    var c_patient_name = document.getElementById("c_patient_name");
                    var c_patient_phone = document.getElementById("c_patient_phone");
                    var c_date = document.getElementById("c_datepicker");
                    var c_hos_name = document.getElementById("c_hos_name");
                    var c_hos_address = document.getElementById("c_hos_address");
                    var c_time = document.getElementById('c_time');
                    var c_time_label = document.getElementById('c_time_label');
                    var c_event_keys = $('#event_keys').val();
                    var c_doctor_name = $('#c_select_doctor_label').text();
                    var c_doctor_id = $('#c_select_doctor').val();
                    var c_select_doc_specialty_label = $('#c_select_doc_specialty_label').val();
                    if(c_doctor_id!="" && c_doctor_id!="ALL" && c_event_keys!="")
                    {
                    //values
                    var pname = c_patient_name.value;
                    var cno = c_patient_phone.value;
                    var cdate = c_date.value;
                    var ctime = c_time_label.textContent;
                    var chosname = c_hos_name.textContent;
                    var chosaddress = c_hos_address.textContent;
                    if(c_select_doc_specialty_label=="")
                    {
                        c_select_doc_specialty_label="ALL";
                    }
                  
                    var url = 'addbooking.php?c_patient_name=' + pname + '&c_patient_phone=' + cno + '&c_date=' + cdate + '&c_time=' + ctime + '&c_hos_name=' + chosname + '&c_hos_address=' + chosaddress + '&event_keys=' + c_event_keys+'&c_doctor_id='+c_doctor_id+'&c_speciality='+c_select_doc_specialty_label;
                    $.getJSON(url, function (obj) {
                          $('#confirm_booking_modal').modal('hide');
                        //$arrReturn = array('booking_id'=>$key,'b_patient_name' => $c_patient_name,
                        //'b_patient_phone' => $c_patient_phone, 'b_date' => $c_date,'b_time' => $c_time ,'b_hos_name' => $c_hos_name,'b_hos_address' => $c_hos_address);
                        document.getElementById("book_id").innerHTML = obj.booking_id;
                        document.getElementById("b_name").innerHTML = obj.b_patient_name;
                        document.getElementById("b_phone").innerHTML = obj.b_patient_phone;
                        
                        document.getElementById("b_doc_name").innerHTML = c_doctor_name;
                        document.getElementById("b_hos_name").innerHTML = obj.b_hos_name;
                        document.getElementById("b_hos_address").innerHTML = obj.b_hos_address;
                       // document.getElementById("b_event_keys").innerHTML = obj.event_keys;
                        var get_url="get_all_userevents.php?book_keys="+obj.event_keys;
                        $.getJSON(get_url, function (get_obj) {
                            var eventlist = get_obj.events;
                            $.each(eventlist, function (index, event_v) {
                                  var tr = document.createElement('tr');
                                  var booking_id = document.createElement('td');
                                  var style1_td =document.createAttribute("style");
                                  style1_td.value="word-break: break-all";
                                  booking_id.setAttributeNode(style1_td);
                                  booking_id.textContent = event_v.book_key;
                                  var title = document.createElement('td');
                                   var style2_td =document.createAttribute("style");
                                  style2_td.value="word-break: break-all";
                                  booking_id.setAttributeNode(style2_td);
                                  title.textContent = event_v.title;
                                  var start = document.createElement('td');
                                  start.textContent = event_v.start;
                                   var style3_td =document.createAttribute("style");
                                  style3_td.value="word-break: break-all";
                                  start.setAttributeNode(style3_td);
                                  var end = document.createElement('td');
                                  end.textContent = event_v.end;
                                   var style4_td =document.createAttribute("style");
                                  style4_td.value="word-break: break-all";
                                  end.setAttributeNode(style4_td);
                       tr.appendChild(booking_id);
                      // tr.appendChild(title);
                       tr.appendChild(start);
                       tr.appendChild(end);
                    $('#booking_list').append(tr);

                });
                            
                        });
                        
                        
                        $('#booking_results').modal('show');
                        $('#booking_results').css("display", "block");
                    }).fail(function () {
                        alert('Unable to fetch data, please try again later.')
                    });
                }
                else
                {
                     alert('Error, Please Select doctor & Create the appointment in the Calendar.');
                } 
            }else
                {
                    console.log("invalid");
                }

            });
            $('#Search_app').click(function () {

                // if ($("#book_app").valid()) 
                {
                    console.log("hello");
                    var time_val = document.getElementById('selectTime');
                    console.log(time_val.value);
                    var place = document.getElementById('place');
                    var speciality = document.getElementById('select_doc_specialty');
                    searchData(time_val.value, place.value, speciality.value);
                    $("#book_form").toggle();
                }

            });
        });

        function showresults() {
//            if (markersdata.length > 0)
            {
                //document.getElementById('result_no').innerHTML = " records found";
                $('#result_count').modal('show');
                setTimeout(function () {



                    $('#result_count').modal('hide');
                }, 2500); // milliseconds
            }
        }

        function searchData(time_val, place, speciality) {
            markersdata = [];
            var param = "";
            var url = 'get_all_address.php';
            console.log(param);
            console.log(time_val);
            if (time_val != "")
            {
                param = '?time=' + time_val;
            }
            if (speciality != "")
            {
                if (param == "")
                {
                    console.log(param);
                    param = '?speciality=' + speciality;
                } else {
                    param += '&speciality=' + speciality;
                }
                console.log(param);
            }
            url += param;

            DeleteMarkers();
            getDefaultLocation("getdefaultlocation.php?default_location=" + place);
            //map.setCenter(chennai);
            getMapContent(url);
//        console.log(markersdata);
//        showresults();

        }
        $(function () {
            $("#datepicker").datepicker();
            $("#c_datepicker").datepicker();
        });
        $(document).ready(function () {
            $("#book_btn").click(function () {
                $("#book_form").toggle();

            });
        });


        //current location error handler
        function handleLocationError(browserHasGeolocation, infoWind, pos) {
            infoWind.setPosition(pos);
            infoWind.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
            infoWind.open(map);
        }

//get address from latlng
        function codeLatLng(lat, lng) {

            var latlng = new google.maps.LatLng(lat, lng);
            geocoder.geocode({'latLng': latlng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    console.log(results)
                    if (results[1]) {
                        //formatted address
                        // alert(results[0].formatted_address)
                        //find country name
                        for (var i = 0; i < results[0].address_components.length; i++) {
                            for (var b = 0; b < results[0].address_components[i].types.length; b++) {

                                //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                                if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                                    //this is the object you are looking for
                                    city = results[0].address_components[i].long_name;
                                    infoWind.setContent('You are Here @' + city);
                                    setTimeout(function () {
                                        infoWind.close();
                                    }, 3000);
                                    console.log(city)
                                    break;
                                }
                            }
                        }
                        //city data
                        //alert(city.short_name + " " + city.long_name)


                    } else {
                        // alert("No results found");
                    }
                } else {
                    // alert("Geocoder failed due to: " + status);
                }
            });
        }

        function calenderView()
        {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var today = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;




            $('#calendar').fullCalendar('destroy');
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaWeek,agendaDay'
                },
                defaultView: 'agendaWeek',
                defaultDate: today,
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectHelper: true,
                selectLongPressDelay: 300,
                select: function (start, end) {
                    calAddEnventModal(start, end);
                },
                eventRender: function (event, element) {
                    element.bind('dblclick', function () {
                        calEditEnventModal(event);

                    });
                },
                selectConstraint: 'businessHours',
                eventConstraint: 'businessHours',
//                        businessHours: [ // specify an array instead
//    {
//        dow: [0, 1, 2, 3, 4, 5, 6 ], // Monday, Tuesday, Wednesday
//        start: '00:00', // 8am
//        end: '24:00' // 6pm
//    }],
                businessHours: bHours,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                height: 350,
                events: events_val
            });
            

            console.log("after render :");
            console.log(events_val);
            $('#calendar').fullCalendar('render');


        }
        function calAddEnventModal(start, end)
        {
            var c_patient_na = document.getElementById("c_patient_name").value;
            var c_doctor_name = $("#c_select_doctor_label").text();
            if (c_patient_na.length == 0 || c_doctor_name.length == 0)
            {
                alert("Patient Name & Phone is Required to Book a Slot.");
                $('#calendar').fullCalendar('refetchEvents');

            } else
            {
                $('#AddCalendarApp #cal_event_start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#AddCalendarApp #cal_event_end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#AddCalendarApp').modal('show');
            }
        }
        function calEditEnventModal(event) {
            $('#EditCalendarApp #edit_cal_event_id').val(event.id);
            $('#EditCalendarApp #edit_cal_event_key').val(event.book_key);
            $('#EditCalendarApp #edit_cal_event_title').val(event.title);
            $('#EditCalendarApp #edit_cal_event_description').val(event.description);
            $('#EditCalendarApp').modal('show');
        }

        function refreshCal(callback)
        {
            $.getJSON('get_all_userevents.php', {email: "<?php echo $_SESSION['email']; ?>"}, function (obj) {
                //var parsed_data = JSON.parse(obj);
                var events_obj = obj.events;
                console.log(events_obj);
                callback(events_obj);
            });
        }
        function clearModalForm(modal_id)
        {
            $('#' + modal_id).find('input:text, input:password, select, textarea').val('');
            $('#' + modal_id).find('input:radio, input:checkbox').prop('checked', false);
        }
</script>
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
</style>




<div class="modal fade" id="AddCalendarApp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Event</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="cal_event_title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="cal_event_title" class="form-control" id="cal_event_title" placeholder="Appointment Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cal_event_description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea type="text" name="cal_event_description" id="cal_event_description" class="form-control" id="description" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <!--				  <div class="form-group">
                                                            <label for="color" class="col-sm-2 control-label">Color</label>
                                                            <div class="col-sm-10">
                                                              <select name="color" class="form-control" id="color">
                                                                      <option value="">Choose</option>
                                                                      <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                                                      <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                                                      <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
                                                                      <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                                                      <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                                                      <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                                                      <option style="color:#000;" value="#000">&#9724; Black</option>
                                                                      
                                                                    </select>
                                                            </div>
                                                      </div>-->
                    <div class="form-group">
                        <label for="cal_event_start" class="col-sm-2 control-label">Start date</label>
                        <div class="col-sm-10">
                            <input type="text" name="cal_event_start" id="cal_event_start" class="form-control" id="start" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cal_event_end" class="col-sm-2 control-label">End date</label>
                        <div class="col-sm-10">
                            <input type="text" id="cal_event_end" name="cal_event_end" class="form-control" id="end" readonly>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="add_calendar_eventbtn" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="EditCalendarApp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_cal_event_title" class="col-sm-2 control-label">ID</label>
                        <div class="col-sm-10">
                            <input type="text" name="edit_cal_event_id" class="form-control" id="edit_cal_event_id" placeholder="Booking_key" disabled="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_cal_event_key" class="col-sm-2 control-label">Booking_key</label>
                        <div class="col-sm-10">
                            <input type="text" name="edit_cal_event_id" class="form-control" id="edit_cal_event_key" placeholder="Booking_key" disabled="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_cal_event_title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="edit_cal_event_title" class="form-control" id="edit_cal_event_title" placeholder="Appointment Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_cal_event_description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea type="text" name="edit_cal_event_description" id="edit_cal_event_description" class="form-control" id="description" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <!--				  <div class="form-group">
                                                            <label for="color" class="col-sm-2 control-label">Color</label>
                                                            <div class="col-sm-10">
                                                              <select name="color" class="form-control" id="color">
                                                                      <option value="">Choose</option>
                                                                      <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                                                      <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                                                      <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
                                                                      <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                                                      <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                                                      <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                                                      <option style="color:#000;" value="#000">&#9724; Black</option>
                                                                      
                                                                    </select>
                                                            </div>
                                                      </div>-->
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label class="text-danger"><input type="checkbox" id="delete_event"  name="delete_event"> Delete event</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="edit_calendar_eventbtn" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "pagelayout/footer.php" ?>
</html>