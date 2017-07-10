<!DOCTYPE html >
<?php 
if(!isset($_SESSION))
{
  session_start();
  if(!($_SESSION['email'] && $_SESSION['email_key'] &&$_SESSION['loginMode']) )
  {
    session_destroy();
    
    header("Location: home.php");//redirect to login page to secure the welcome page without login access.
  }
  else{
      if(isset($_GET['default_location']))
{
$selectLocation = $_GET['default_location'];
}
else{
    $selectLocation = "chennai";
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
            .h4{
                font-size: smaller;
            }
            #form{
                padding: 0px!important;
            }
            .marker_header{
            background-color: #dd4814;
            padding: 5px;
            color: #ffffff;
            font-size: 11px;

        }
        .marker_address{
             background-color: #607D8B;
            padding: 5px;
            color: #ffffff;
            font-size: 11px;
        }
        .row{
            padding: 0px!important;
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
        .marker_address{
             background-color: #607D8B;
            padding: 5px;
            color: #ffffff;
           
        }
        .address_content{
            word-wrap: break-word;
            display: block;
            width: 150px; 
           background-color: rgba(121, 83, 72, 0.09);
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
    </style>


</head>


<?php include "pagelayout/navbar.php";
include_once 'dbconfig/dbconfig.php';
?>
<script src="assets/js/jquery.validate.min.js"></script>
<link rel="stylesheet" href="assets/css/dropdown/bootstrap-select.css">
<!--<link rel="stylesheet" href="assets/css/dropdown/bootstrap-multiselect.css">-->
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/dropdown/bootstrap-select.js"></script>
<!--<script src="assets/js/dropdown/bootstrap-multiselect.js"></script>-->
<body>

    <div class="container">
      

        <div class="row">
            <div id="map-outer" class="col-md-12">

               
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
      <div id="form"  class="col-sm-12" style="display: none; width: 500px;">
     
       
        <div class="address_header" class="col-sm-6">
 <h4 class="marker_header" >Add Doctor & Hospital <span><?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?></span> </h4>
  </div>
    <div id="address_body" class="address_body col-sm-6">
        <form class="form-validate" id="add_address_app" name="add_address_app">
            <div class="table-responsive">
     <table class="table table-striped table-condensed">
      <tr>  </tr>
     
       
      <tr><td>Hospital :</td></tr>
       
      <tr> <td><input type='text' name='loc_name'  id='loc_name'  required/> </td> </tr>
      
      <tr><td>Phone :</td></tr>
       
      <tr> <td> <input type='text'  name='phone'  id='phone' required/> </td> </tr>
      <tr><td>Type :</td> </tr>
       
      <tr><td><select id='type' required> +
                 <option value='Hospital' SELECTED>Hospital</option>
                 <option value='Clinic'>Clinic</option>
                 </select> </td></tr>
      
    
      
      <tr><td><input type='button'  class="btn-xs btn-primary" id="Save_doc" value='Save' /></td></tr>
      </table>
                </div>
      </form>
        </div>

        <div id="address_content" class="col-md-6 address_content">
            <div class="marker_address">  <strong>Location Details :</strong><br></div>
               <span name='address' id='address'></span> <br>
                <span name='latitude' id='latitude'></span> <br>
                 <span name='longitude' id='longitude'></span><br>
                 <span name='email' id='email'><strong>Email :</strong>  <?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?></span><br>
                
          </div>
    </div>

                <div id="message"  style="display: none">Location saved <a href="welcome.php">view address</a></div>
    <div id="book_form" class="col-sm-3" style="display: none">
        <form class="col-sm-6" id="book_app"  name="book_app">
            <table class="book_form" >
                <caption>Book Appointment :</caption>
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


                <tr><td>Hospital Name:</td>
                    <td>

                        <input type="text" id="ex_hosp_name" name="ex_hosp_name" required/>
                    </td>
                </tr>
                <tr>
                    <td>Location:</td>
                    <td>
                    <select id="place"  class="selectpicker" name="place" data-width="70%"  >
                    <?php
                  
                  $default_location_cdquery="SELECT DISTINCT name FROM default_location";
                  $default_location_cdresult=mysqli_query($db_handle,$default_location_cdquery) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
                  echo '<option value="">SELECT</option>';
                  while ($default_location_cdrow=mysqli_fetch_array($default_location_cdresult,MYSQLI_ASSOC)) {
                    $name=$default_location_cdrow["name"];
                    echo "<option>$name</option>";

                  }
                  ?>
                    </select>
 </tr>    
<!--                <tr><td>Time:</td>
                    <td>  <p>  <input id="selectTime"  name="selectTime" type="text" class="time" required/>
                            <span id="selectTimeTarget" style="margin-left: 30px;"></span></p></td>
               
                    <td>Location:</td>
                    <td><input id="place"  name="place" type="text" value="madurai"/></td>
</tr>
-->
<!-- <tr>
                    <td>
                        <input type='button' class="btn-primary" value='Search' id="Search_app" />
                    </td>
                </tr>-->
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

                
                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="add_doc_details_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Add details</h4>
                </div>
                <div class="modal-body">
                     <form  id="add_doc_details_form" role="form">
                        <div class="modal_fields control-group">
                            <label for="doc_name">Doctor Name :</label>
                            <input type="text" class="form-control sm-input" name="doc_name" id="doc_name" placeholder="Doctor Name" value="<?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?>" >
                        </div>
                         <div class="modal_fields control-group">
                            <label for="consulting_hr">Consulting Hrs :</label>
                           <div data-tip="7am-8am & use comma for separate 2 sections"> <input type="text" class="form-control sm-input" name="consulting_hr" id="consulting_hr" placeholder="7-8,13-14,19-21" value="" required/>
                               </div>
                        </div>
                          <div class="modal_fields control-group">
                            <label for="select_doc_specialty">Speciality Name :</label>
                         <select id="select_doc_specialty"  class="selectpicker" name="select_doc_specialty" multiple="true" data-width="50%" required>
                  <?php
                  
                  $speciality_cdquery="SELECT DISTINCT speciality_name FROM specialities";
                  $speciality_cdresult=mysqli_query($db_handle,$speciality_cdquery) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
                  echo '<option value="">SPECIALITY</option>';
                  while ($speciality_cdrow=mysqli_fetch_array($speciality_cdresult,MYSQLI_ASSOC)) {
                    $speciality_name=$speciality_cdrow["speciality_name"];
                    echo "<option>$speciality_name</option>";

                  }
                  ?>
                </select>
                         
                          </div>
                         <div class="modal_fields control-group">
                            <label  for="doc_phone">Phone No</label>
                            <input type="text" class="form-control sm-input" name="doc_phone" id="doc_phone" placeholder="Phone No">
                        </div>
                         
                         <div class="modal-footer">
                            <button type="button" name="btn-confirmbooking" id="btn-confirmbooking"  class="btn btn-success">Submit</button>
                        </div>
                    </form>

                </div>
                 </div>
             </div>
                         
                
                    </div>
               
                 <!-- add  doctor modal --> 
                 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="adddoctor-modal" class="modal fade">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                              <h4 class="modal-title">Add doctor</h4>
                          </div>
                          <div class="modal-body">
                              <form id="adddoctor_form" class="form-horizontal" role="form">
                                  <div id="row_div" class="row">

                                      <div class="panel panel-warning">
      
      <div class="panel-body">
           <div class="col-sm-6">
       <div class="control-group">
            <label for="add_doc_hosp_name">Hospital Name :</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_hosp_name" id="add_doc_hosp_name" placeholder="Hospital Name" required> </div>
        </div>
               
               
           <div class="control-group">
          
                            <label for="consulting_hrs">Consulting Hrs :</label>
          <div class="controls">
                            <div data-tip="7am-8am & use comma for separate 2 sections">
                                <input type="text" class="form-control " name="consulting_hrs" id="consulting_hrs" placeholder="7-8,13-14,19-21" required/>
                               </div>
                        </div>
             </div>
               </div>
      <div class="col-sm-6">
        <div class="control-group">
          
                            <label for="add_doc_hosp_address">Hospital Address:</label>
          <div class="controls">
              <textarea rows="5" class="form-control " name="add_doc_hosp_address" id="add_doc_hosp_address"  placeholder="Hospital Address" required></textarea>
                            
                        </div>
             </div>
    </div>
          
          
         
     </div>
     </div>
                                      
                                 
                                  <div class="panel panel-warning">
      <div class="panel-heading">Name</div>
      <div class="panel-body">
       <div class="col-sm-6">
        <div class="control-group">
            <label for="add_doc_title">TITLE *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_title" id="add_doc_title" placeholder="TITLE" required> </div>
        </div>
        <div class="control-group">
            <label for="add_doc_firstname">FIRSTNAME *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_firstname" id="add_doc_firstname" placeholder="FIRSTNAME" required> </div>
        </div>
       
        </div>
        <div class="col-sm-6">
         <div class="control-group">
            <label for="add_doc_lastname">LASTNAME *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_lastname" id="add_doc_lastname" placeholder="LASTNAME" required> </div>
        </div>
        <div class="control-group">
            <label  for="add_doc_middlename">MIDDLENAME *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_middlename" id="add_doc_middlename" placeholder="MIDDLENAME" required> </div>
        </div>
    </div>
    </div>


                                  </div>
                                 


                                  <div class="panel panel-warning">
      
      <div class="panel-body">
       <div class="col-sm-6">
           <div class="control-group">
            <label for="add_doc_gender">GENDER *</label>
            <div class="controls">
            <label class="radio-inline">
                <input type="radio" name="add_doc_gender" id="add_doc_gender" value="M" >Male
    </label>
    <label class="radio-inline">
        <input type="radio" name="add_doc_gender" id="add_doc_gender" value="F">Female
    </label>
                <!-- <input type="text" class="form-control" name="add_doc_gender" id="add_doc_gender" placeholder="GENDER" required> -->
                 </div>
        </div>
        
        <div class="control-group">
            <label for="add_doc_hosp_name">Qualification:</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_qualification" id="add_doc_qualification" placeholder="Qualification" required> </div>
        </div>
        
        </div>
          
          <div class="col-sm-6">
              <div class="control-group">
            <label for="add_doc_dob">DOB *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_dob" id="add_doc_dob" placeholder="DOB" required> </div>
        </div>
        <div class="control-group">
            <label for="add_doc_specialty">SPECIALITY *</label>
            <div class="controls">
              <!--   <input type="text" class="form-control" name="add_doc_specialty" id="add_doc_specialty" placeholder="SPECIALTY" required> </div> -->
              <select id="add_doc_specialty" class="selectpicker" name="add_doc_specialty" data-width="95%">
                  <?php
                  
                  $speciality_cdquery="SELECT DISTINCT speciality_name FROM specialities";
                  $speciality_cdresult=mysqli_query($db_handle,$speciality_cdquery) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
                  echo '<option value="">SPECIALITY</option>';
                  while ($speciality_cdrow=mysqli_fetch_array($speciality_cdresult,MYSQLI_ASSOC)) {
                    $speciality_name=$speciality_cdrow["speciality_name"];
                    echo "<option>$speciality_name</option>";

                  }
                  ?>
                </select>
        </div>
    </div>
         
        
        </div>
          </div>
                                      </div>
           <div class="panel panel-warning">
      
      <div class="panel-body">
           <div class="col-sm-6">
       <div class="control-group">
            <label for="add_doc_aadhar_no">Aadhar No *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_aadhar_no" id="add_doc_aadhar_no" placeholder="Aadhar No" required> </div>
        </div>
               
               </div>
      <div class="col-sm-6">
        <div class="control-group">
          
                            <label for="add_doc_voter_id">Voter's Id:</label>
          <div class="controls">
              <input type="text" class="form-control " name="add_doc_voter_id" id="add_doc_voter_id"  placeholder="Voter's Id" required/>
                            
                        </div>
             </div>
    </div>
          
          
         
     </div>
     </div>
 <div class="panel panel-warning">
      <div class="panel-heading">Contact Details</div>
      <div class="panel-body">
       <div class="col-sm-6">
       <div class="control-group">
            <label for="add_doc_phone">PHONE NUMBER *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_phone" id="add_doc_phone" placeholder="PHONE NUMBER" required> </div>
        </div>
         <div class="control-group">
            <label for="add_doc_email">EMAIL *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_email" id="add_doc_email" placeholder="EMAIL" value="<?php  if ($_SESSION['email']!="")
                    { echo $_SESSION['email']; }?>" disabled="true" required> </div>
        </div>
       
        </div>
        <div class="col-sm-6">
         <div class="control-group">
            <label for="add_doc_mobile">MOBILE NUMBER *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_mobile" id="add_doc_mobile" placeholder="MOBILE NUMBER" required> </div>
        </div>
        <div class="control-group">
            <label for="add_doc_altmobile">ALT MOBILE NUMBER *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_altmobile" id="add_doc_altmobile" placeholder="ALT MOBILE NUMBER" required> </div>
        </div>
    </div>
    </div>


                                  </div>

<div class="panel panel-warning">
      <div class="panel-heading">Location Details</div>
      <div class="panel-body">
       
        <div class="col-sm-12">
                                  <div class="control-group">
            <label for="add_doc_addresslineone">ADDRESSLINEONE *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_addresslineone" id="add_doc_addresslineone" placeholder="ADDRESSLINEONE" required> </div>
        </div>
        <div class="control-group">
            <label for="add_doc_addresslinetwo">ADDRESSLINETWO *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_addresslinetwo" id="add_doc_addresslinetwo" placeholder="ADDRESSLINETWO" required> </div>
        </div>
         </div>
        <div class="col-sm-6">
        <div class="control-group">
            <label for="add_doc_city">CITY *</label>
            <div class="controls">
              
                <input type="text" class="form-control" name="add_doc_city" id="add_doc_city" placeholder="CITY" required> </div>
        
         </div>
         </div>
        <div class="col-sm-6">
        <div class="control-group">
            <label for="add_doc_state">STATE *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_state" id="add_doc_state" placeholder="STATE" required> </div>
        </div>
         </div>
        <div class="col-sm-6">
        <div class="control-group">
            <label for="add_doc_country">COUNTRY *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_country" id="add_doc_country" placeholder="COUNTRY" required> </div>
        </div>
         </div>
        <div class="col-sm-6">
        <div class="control-group">
            <label for="add_doc_zip">ZIP CODE *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_zip" id="add_doc_zip" placeholder="ZIP CODE" required> </div>
        </div>
         </div>
         </div>
                                  </div>



                                  </div>
                                  </div>
                                  <div class="modal-footer">
                                  <button type="button" name="btn-adddoctor" id="btn-adddoctor"   class="btn btn-primary">Add</button>
                                </div>
                              </form>

                          </div>

                      </div>
                  </div>
                 <!-- end of add doctor modal-->
                
                
                
                
    <div id="message" style="display: none">Location saved</div>
    <div id="book-bar" class="book-bar" style="display: block"><button type="button" id="book_btn" class="btn btn-info">
            <span class="glyphicon glyphicon-new-window"></span> Hospitals
        </button></div>

    <script>
        $(function () {
            /*$('#disableTimeRangesExample').timepicker({ 'disableTimeRanges': [['2pm', '3pm'], ['5pm', '6pm']],'minTime': '2:00pm',
             'maxTime': '8:30pm', });*/
            $('#selectTime').timepicker({'disableTimeRanges': [['2pm', '3pm'], ['5pm', '6pm']], 'minTime': '2:00pm',
                'maxTime': '8:30pm', });
            $('#selectTime').on('changeTime', function () {
                $('#selectTimeTarget').text($(this).val());
            });
            $('#c_time').timepicker({'disableTimeRanges': [['2pm', '3pm'], ['5pm', '6pm']], 'minTime': '2:00pm',
                'maxTime': '8:30pm', });
            $('#c_time').on('changeTime', function () {
                $('#c_time_label').text($(this).val());
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
                        <div class="modal_fields control-group">
                            <label for="c_patient_name">Patient Name</label>
                            <input type="text" class="form-control sm-input" name="c_patient_name" id="c_patient_name" placeholder="Patient Name">
                        </div>
                        <div class="modal_fields control-group">
                            <label  for="c_patient_phone">Phone No</label>
                            <input type="text" class="form-control sm-input" name="c_patient_phone" id="c_patient_phone" placeholder="Phone No">
                        </div>
                        <div class="modal_fields control-group">
                            <label  id="c_date_Text" >Date : </label>
                            <input type="text" id="c_datepicker" name="c_datepicker" required/>
                        </div>
                        <div class="modal_fields control-group">
                            <label  id="c_time_Text" >Time : </label>
                            <input id="c_time"  name="c_time" type="text" class="time" required/>
                            <span  id="c_time_label" ></span> 
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
                        <label for="book_id" >Booking ID : </label>
                        <span id="book_id" >NA</span>
                    </div>
                    <div class="modal_fields control-group">
                        <label for="b_date" >Booking Date : </label>
                        <span id="b_date" >NA</span>
                    </div>
                    
                    <div class="modal_fields control-group">
                        <label>Booking Details : </label>
                        <div class="table-responsive" >
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>   <label for="b_name" >Name</label></td>
                                    <td> <label for="b_phone" >Phone</label></td>
                                    <td>  <label for="b_time" >Time</label></td>
                                </tr>
                                <tr>
                                    <td><span id="b_name"></span></td>
                                    <td><span id="b_phone"></span></td>
                                    <td> <span id="b_time"></span></td>
                                </tr>
                            </table>
                           
                        </div> 
                         <div >
                                <label for="book_id" >Hospital Address : </label>
                                <span id="b_hos_address"></span>
                            </div> 
                    </div>

                    <div class="modal_fields control-group">
                        <a href="search_view_address.php" class="btn btn-info" >confirmed</a>
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
            console.log(map_loc_name.textContent);
            c_datepicker.value = datepicker.value;
            c_time.value = selectTime.value;
            c_time_label.innerHTML = selectTime.value;
            c_hos_name.innerHTML = map_loc_name.textContent;
            c_hos_address.innerHTML = map_loc_address.textContent;
            $('#confirm_booking_modal').modal('show');
            // console.log(x);
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
                        
var span = document.getElementById('address');
if(span!=null)
{
 while( span.firstChild ) {
        span.removeChild( span.firstChild );
    }
    span.appendChild( document.createTextNode(results[0].formatted_address) );
}

var latitude = document.getElementById('latitude');
if(latitude!=null)
{
 while( latitude.firstChild ) {
        latitude.removeChild( latitude.firstChild );
    }
    latitude.appendChild( document.createTextNode("lat : "+marker.getPosition().lat()) );
}
var longitude = document.getElementById('longitude');
if(longitude!=null)
{
 while( longitude.firstChild ) {
        longitude.removeChild( longitude.firstChild );
    }
    longitude.appendChild( document.createTextNode("lng : "+marker.getPosition().lng()) );
}

/*$('#latitude').val(marker.getPosition().lat());*/
/*$('#longitude').val(marker.getPosition().lng());*/
infowindow.content.style.cssText="display:block";
infowindow.open(map, marker);
                        
                        
                       /** var address = results[0].formatted_address;
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
            */
           
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
var default_loc ;
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
var  infoWind ,city;
function getcurretLoc()
{
            infoWind = new google.maps.InfoWindow;
        // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        console.log(position);
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      codeLatLng(pos.lat,pos.lng);

      infoWind.setPosition(pos);
      
      infoWind.open(map);
      map.setCenter(pos);
    }, function() {
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
             getDefaultLocation("getdefaultlocation.php?default_location="+<?php echo $selectLocation?>);
           
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
            var doc_email =  "<?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?>";
              
              if(doc_email=='')
              {
                  alert("invalid Session -  try login again.if not reach the admin");
                  window.location.href='logout.php';
              }
              else
              {
            getMapContent('get_all_address.php?useremail='+doc_email);
        }
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
                    var latId = document.createAttribute("id");
                    latId.value = "hosp_lat";
                    lat.setAttributeNode(latId);
                    lat.textContent = "lat : " + latitude;
                    infowincontent.appendChild(lat);
                    infowincontent.appendChild(document.createElement('br'));
                    var lng = document.createElement('text');
                    var lngId = document.createAttribute("id");
                    lngId.value = "hosp_lng";
                    lng.setAttributeNode(lngId);
                    
                    lng.textContent = "lng : " + longitude;
                    infowincontent.appendChild(lng);
                    infowincontent.appendChild(document.createElement('br'));
                    var addform = document.createElement('input');
                    var typeform = document.createAttribute("type");
                    typeform.value = "button";
                    var idform = document.createAttribute("id");
                    idform.value = doc_id;
                    var btnonclick = document.createAttribute("onclick");
                    btnonclick.value = "linkdoctor()";
                    var btnval = document.createAttribute("value");
                    btnval.value = "Link";
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
                     console.log(marker.getPosition());
                    marker.addListener('click', function () {
                        /* var formcontent = document.getElementById("form");
                         infowincontent.appendChild(formcontent);*/
                        console.log(marker.position);
                        console.log(marker.customInfoName);
                        $('#name').val(marker.customInfoName);
                        /* reinittimer(marker.customdate_filter);*/

                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });
                });
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
        
        
           function saveData() {

        var doc_name = escape(document.getElementById('doc_name').value);
        var name = escape(document.getElementById('loc_name').value);
        var consulting_hrs =  escape(document.getElementById('consulting_hrs').value);
        var phone =  escape(document.getElementById('phone').value);
        var add = $('#address').text();
        var address = escape($('#address').text());
        var type = document.getElementById('type').value;
        var latlng = marker.getPosition();
        var doc_email =  "<?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?>";
              if(doc_email=='')
              {
                  alert("invalid Session -  try login again.if not reach the admin");
              }
              else
              {
        var url = 'location_addrow.php?name=' + name + '&address=' + address +
                  '&type=' + type + '&lat=' + latlng.lat() + '&lng=' + latlng.lng() +
                  '&consulting_hrs=' + consulting_hrs + '&phone=' + phone+'&add_doc_email='+doc_email;

        downloadUrl(url, function(data, responseCode) {
            console.log(responseCode);
            console.log(data.response);
             var parsed_data = JSON.parse(data.response);
          if (responseCode == 200) {
            infowindow.close();
            document.getElementById('add_doc_hosp_name').value = name;
            document.getElementById('add_doc_hosp_address').value = add;
            // set data to modal
            var c_add_doc_title = document.getElementById("add_doc_title");
            var c_add_doc_dob = document.getElementById("add_doc_dob");
            var c_add_doc_firstname = document.getElementById("add_doc_firstname");
            var c_add_doc_lastname = document.getElementById("add_doc_lastname");
            var c_add_doc_middlename = document.getElementById("add_doc_middlename");
            var c_add_doc_gender = document.getElementById("add_doc_gender");
            var c_add_doc_qualification = document.getElementById("add_doc_qualification");
            var c_add_doc_phone = document.getElementById("add_doc_phone");
            var c_add_doc_mobile = document.getElementById("add_doc_mobile");
            var c_add_doc_altmobile = document.getElementById("add_doc_altmobile");
            var c_add_doc_email = document.getElementById("add_doc_email");
            var c_add_doc_specialty = document.getElementById("add_doc_specialty");
            var c_add_doc_addresslineone = document.getElementById("add_doc_addresslineone");
            var c_add_doc_addresslinetwo = document.getElementById("add_doc_addresslinetwo");
            var c_add_doc_city = document.getElementById("add_doc_city");
            var c_add_doc_state = document.getElementById("add_doc_state");
            var c_add_doc_country = document.getElementById("add_doc_country");
            var c_add_doc_zip = document.getElementById("add_doc_zip");
            var c_consulting_hrs = document.getElementById("consulting_hrs");
            var c_add_doc_aadhar_no = document.getElementById("add_doc_aadhar_no");
            var c_add_doc_voter_id = document.getElementById("add_doc_voter_id");
           
            
            c_add_doc_title.value = parsed_data.doctor.add_doc_title;
            c_add_doc_dob.value = parsed_data.doctor.add_doc_dob;
            c_add_doc_firstname.value = parsed_data.doctor.add_doc_firstname;
            c_add_doc_lastname.value = parsed_data.doctor.add_doc_lastname;
            c_add_doc_middlename.value = parsed_data.doctor.add_doc_middlename;
            c_add_doc_gender.value = parsed_data.doctor.add_doc_gender;
            c_add_doc_qualification.value = parsed_data.doctor.add_doc_qualification;
            c_add_doc_phone.value = parsed_data.doctor.add_doc_phone;
            c_add_doc_mobile.value = parsed_data.doctor.add_doc_mobile;
            c_add_doc_altmobile.value = parsed_data.doctor.add_doc_altmobile;
            $('#add_doc_specialty').val(parsed_data.doctor.add_doc_specialty);
             $("#add_doc_specialty").selectpicker('refresh');
            c_add_doc_addresslineone.value = parsed_data.doctor.add_doc_addresslineone;
            c_add_doc_addresslinetwo.value = parsed_data.doctor.add_doc_addresslinetwo;
            c_add_doc_city.value = parsed_data.doctor.add_doc_city;
            c_add_doc_state.value = parsed_data.doctor.add_doc_state;
            c_add_doc_country.value = parsed_data.doctor.add_doc_country;
            c_add_doc_zip.value = parsed_data.doctor.add_doc_zip;
            c_add_doc_aadhar_no.value = parsed_data.doctor.add_doc_aadhar_no;
            c_add_doc_voter_id.value = parsed_data.doctor.add_doc_voter_id;
            
            
            var $radios = $('input:radio[name=add_doc_gender]');
    if($radios.is(':checked') === false) {
        $radios.filter('[value="'+parsed_data.doctor.add_doc_gender+'"]').prop('checked', true);
    }

            
            
            // eof set data to modal
             $('#adddoctor-modal').modal('show');
                        //$('#add_doc_details').css("display", "block");
           // messagewindow.content.style.cssText="display:block";
           // messagewindow.open(map, marker);
          }
        });
    }
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCphOSKQQie7vS98SET868Ljvx-lAJ-gTY&libraries=places&callback=initMap">
    </script>
    <?php include "pagelayout/footer.php" ?>
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
        $(document).ready(function () {
            
             $( "#ex_hosp_name" ).autocomplete({
        source: 'gethospdrop.php',
        minLength: 0,
        scroll: true
       }).focus(function() {
        $(this).autocomplete("search", "");
    });
   
// $('#ex_hosp_name').autocomplete({
//            source: 'gethospdrop.php',
//            minLength: 0,
//            scroll: true
//        }).keyup(function() {
//         //  $(this).autocomplete("search", $(this).val());
//           $(this).autocomplete("search", "");
//        });
    $( "#ex_hosp_name" ).keyup(function() { 
        $( "#ex_hosp_name" ).autocomplete({
        source: 'gethospdrop.php?hosp='+$(this).val()
    });
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
            
            
            
              $("#adddoctor_form").validate({
                rules: {
                    add_doc_title: {
                        required: true,
                    },
                    add_doc_dob: {
                        required: true,
                    },
                    add_doc_firstname: {
                        required: true,
                    },
                    add_doc_lastname: {
                        required: true,
                    },
                    add_doc_middlename: {
                        required: true,
                    },
                    add_doc_gender: {
                        required: true,
                    },
                    add_doc_phone: {
                        required: true,
                    },
                    add_doc_mobile: {
                        required: true,
                    },
                    add_doc_altmobile: {
                        required: true,
                    },
                    add_doc_email: {
                        required: true,
                    },
                    add_doc_specialty: {
                        required: true,
                    },
                    add_doc_addresslineone: {
                        required: true,
                    },
                    add_doc_addresslinetwo: {
                        required: true,
                    },
                    add_doc_city: {
                        required: true,
                    },
                    add_doc_state: {
                        required: true,
                    },
                    add_doc_country: {
                        required: true,
                    },
                    add_doc_zip: {
                        required: true,
                    },
                },
                focusInvalid: false,
                messages: {
                    add_doc_title: "Please specify add_doc_title",
                    add_doc_dob: "Please specify add_doc_dob",
                    add_doc_firstname: "Please specify add_doc_firstname",
                    add_doc_lastname: "Please specify add_doc_lastname",
                    add_doc_middlename: "Please specify add_doc_middlename",
                    add_doc_gender: "Please specify add_doc_gender",
                    add_doc_phone: "Please specify add_doc_phone",
                    add_doc_mobile: "Please specify add_doc_mobile",
                    add_doc_altmobile: "Please specify add_doc_altmobile",
                    add_doc_email: "Please specify add_doc_email",
                    add_doc_specialty: "Please specify add_doc_specialty",
                    add_doc_addresslineone: "Please specify add_doc_addresslineone",
                    add_doc_addresslinetwo: "Please specify add_doc_addresslinetwo",
                    add_doc_city: "Please specify add_doc_city",
                    add_doc_state: "Please specify add_doc_state",
                    add_doc_country: "Please specify add_doc_country",
                    add_doc_zip: "Please specify add_doc_zip",
                    add_doc_aadhar_no: "Please specify add_doc_aadhar_no",

                }

            });

 $('#btn-adddoctor').click(function () {
//     if ($("#adddoctor_form").valid()) {
{
           $('#adddoctor-modal').modal('hide');
                    console.log("valid");
                    var c_add_doc_title = document.getElementById("add_doc_title");
                    var c_add_doc_dob = document.getElementById("add_doc_dob");
                    var c_add_doc_firstname = document.getElementById("add_doc_firstname");
                    var c_add_doc_lastname = document.getElementById("add_doc_lastname");
                    var c_add_doc_middlename = document.getElementById("add_doc_middlename");
                    var c_add_doc_gender = document.getElementById("add_doc_gender");
                    var c_add_doc_phone = document.getElementById("add_doc_phone");
                    var c_add_doc_mobile = document.getElementById("add_doc_mobile");
                    var c_add_doc_altmobile = document.getElementById("add_doc_altmobile");
                    var c_add_doc_email = document.getElementById("add_doc_email");
                    var c_add_doc_specialty = document.getElementById("add_doc_specialty");
                    var c_add_doc_addresslineone = document.getElementById("add_doc_addresslineone");
                    var c_add_doc_addresslinetwo = document.getElementById("add_doc_addresslinetwo");
                    var c_add_doc_city = document.getElementById("add_doc_city");
                    var c_add_doc_state = document.getElementById("add_doc_state");
                    var c_add_doc_country = document.getElementById("add_doc_country");
                    var c_add_doc_zip = document.getElementById("add_doc_zip");
                    var c_consulting_hrs = document.getElementById("consulting_hrs");
                    var c_add_doc_aadhar_no = document.getElementById("add_doc_aadhar_no");
                    var c_add_doc_voter_id = document.getElementById("add_doc_voter_id");
                    var c_add_doc_hosp_name = document.getElementById("add_doc_hosp_name");
                    var c_add_doc_qualification = document.getElementById("add_doc_qualification");
                    
                    
                      $.ajax({
type: 'POST',
url: 'adddoctor.php',
data: { add_doc_title: c_add_doc_title.value ,
add_doc_dob: c_add_doc_dob.value ,
add_doc_firstname: c_add_doc_firstname.value ,
add_doc_lastname: c_add_doc_lastname.value ,
add_doc_middlename: c_add_doc_middlename.value ,
add_doc_gender: c_add_doc_gender.value ,
add_doc_phone: c_add_doc_phone.value ,
add_doc_mobile: c_add_doc_mobile.value ,
add_doc_altmobile: c_add_doc_altmobile.value ,
add_doc_email: c_add_doc_email.value ,
add_doc_specialty: c_add_doc_specialty.value ,
add_doc_addresslineone: c_add_doc_addresslineone.value ,
add_doc_addresslinetwo: c_add_doc_addresslinetwo.value ,
add_doc_city: c_add_doc_city.value ,
add_doc_state: c_add_doc_state.value ,
add_doc_country: c_add_doc_country.value ,
add_doc_zip: c_add_doc_zip.value,
consulting_hrs:c_consulting_hrs.value,
add_doc_voter_id: c_add_doc_voter_id.value,
add_doc_aadhar_no:c_add_doc_aadhar_no.value,
add_doc_hosp_name:c_add_doc_hosp_name.value,
add_doc_qualification:c_add_doc_qualification.value

},
success: function (obj) {
    var parsed_data = JSON.parse(obj);
    console.log(parsed_data.status);
   if(parsed_data.status=="passed")
   {
      alert('Updated  the data Successfully. Status : '+parsed_data.status);
      window.location.href='my_account.php';
   }
   else{
        alert('Failed, please try again later. Reason : '+parsed_data.reason);
   }
}
    });
     }
 });
            $('#btn-confirmbooking').click(function () {

                if ($("#confirm_booking_form").valid()) {
                    $('#confirm_booking_modal').modal('hide');
                    console.log("valid");
                    var c_patient_name = document.getElementById("c_patient_name");
                    var c_patient_phone = document.getElementById("c_patient_phone");
                    var c_date = document.getElementById("c_datepicker");
                    var c_hos_name = document.getElementById("c_hos_name");
                    var c_hos_address = document.getElementById("c_hos_address");
                    var c_time = document.getElementById('c_time');
                    var c_time_label = document.getElementById('c_time_label');
                    //values
                    var pname = c_patient_name.value;
                    var cno = c_patient_phone.value;
                    var cdate = c_date.value;
                    var ctime = c_time_label.textContent;
                    var chosname = c_hos_name.textContent;
                    var chosaddress = c_hos_address.textContent;
                    var url = 'addbooking.php?c_patient_name=' + pname + '&c_patient_phone=' + cno + '&c_date=' + cdate + '&c_time=' + ctime + '&c_hos_name=' + chosname + '&c_hos_address=' + chosaddress
                    $.getJSON(url, function (obj) {
                        //$arrReturn = array('booking_id'=>$key,'b_patient_name' => $c_patient_name,
                        //'b_patient_phone' => $c_patient_phone, 'b_date' => $c_date,'b_time' => $c_time ,'b_hos_name' => $c_hos_name,'b_hos_address' => $c_hos_address);
                        document.getElementById("book_id").innerHTML = obj.booking_id;
                        document.getElementById("b_name").innerHTML = obj.b_patient_name;
                        document.getElementById("b_phone").innerHTML = obj.b_patient_phone;
                        document.getElementById("b_date").innerHTML = obj.b_date;
                        document.getElementById("b_time").innerHTML = obj.b_time;
                        document.getElementById("b_hos_name").innerHTML = obj.b_hos_name;
                        document.getElementById("b_hos_address").innerHTML = obj.b_hos_address;
                        $('#booking_results').modal('show');
                        $('#booking_results').css("display", "block");
                    }).fail(function () {
                        alert('Unable to fetch data, please try again later.')
                    });
                } else
                {
                    console.log("invalid");
                }

            });
            $('#Search_app').click(function () {

                if ($("#book_app").valid()) {
                    console.log("hello");
                    var hosp_name = document.getElementById('ex_hosp_name');
                     var place = document.getElementById('place');
                    searchData(hosp_name.value,place.value);
                }

            });
            
            //add address code
             $("#add_address_app").validate({
       rules: {   
         loc_name: {
            required: true,
           } ,
           select_doc_specialty:{
               required: true,
           }
        },
         messages: {
            loc_name: "Please specify location name",
            select_doc_specialty: "Please specify your specialty",

        }
      
    });  
    //save address
$('#Save_doc').click(function() {
        
         if ($("#add_address_app").valid()) {
             console.log("hello");
             saveData();
        }
       
    });
        });

        function showresults() {
            if (markersdata.length > 0)
            {
                document.getElementById('result_no').innerHTML = markersdata.length + " records found";
                $('#result_count').modal('show');
                setTimeout(function () {



                    $('#result_count').modal('hide');
                }, 2000); // milliseconds
            }
        }
        function linkdoctor()
        {

        var doc_name = escape(document.getElementById('doc_name').value);
        var name = escape($('#map_loc_name').text());
        var consulting_hrs =  escape(document.getElementById('consulting_hrs').value);
        var phone =  escape(document.getElementById('phone').value);
        var add = $('#address').text();
        var address = escape($('#map_loc_address').text());
        var type = document.getElementById('type').value;
        var hosp_lat = escape($('#hosp_lat').text());
        var hosp_lng = escape($('#hosp_lng').text());
        var doc_email =  "<?php  if ($_SESSION['email']!="")
      { echo $_SESSION['email']; }?>";
              if(doc_email=='')
              {
                  alert("invalid Session -  try login again.if not reach the admin");
              }
              else
              {
        var url = 'location_addrow.php?name=' + name + '&address=' + address +
                  '&type=' + type + '&lat=' + hosp_lat + '&lng=' + hosp_lng +
                  '&consulting_hrs=' + consulting_hrs + '&phone=' + phone+'&add_doc_email='+doc_email;

        downloadUrl(url, function(data, responseCode) {
            console.log(responseCode);
            console.log(data.response);
             var parsed_data = JSON.parse(data.response);
          if (responseCode == 200) {
            infowindow.close();
            document.getElementById('add_doc_hosp_name').value = name;
            document.getElementById('add_doc_hosp_address').value = add;
            // set data to modal
            var c_add_doc_title = document.getElementById("add_doc_title");
            var c_add_doc_dob = document.getElementById("add_doc_dob");
            var c_add_doc_firstname = document.getElementById("add_doc_firstname");
            var c_add_doc_lastname = document.getElementById("add_doc_lastname");
            var c_add_doc_middlename = document.getElementById("add_doc_middlename");
            var c_add_doc_gender = document.getElementById("add_doc_gender");
            var c_add_doc_qualification = document.getElementById("add_doc_qualification");
            var c_add_doc_phone = document.getElementById("add_doc_phone");
            var c_add_doc_mobile = document.getElementById("add_doc_mobile");
            var c_add_doc_altmobile = document.getElementById("add_doc_altmobile");
            var c_add_doc_email = document.getElementById("add_doc_email");
            var c_add_doc_specialty = document.getElementById("add_doc_specialty");
            var c_add_doc_addresslineone = document.getElementById("add_doc_addresslineone");
            var c_add_doc_addresslinetwo = document.getElementById("add_doc_addresslinetwo");
            var c_add_doc_city = document.getElementById("add_doc_city");
            var c_add_doc_state = document.getElementById("add_doc_state");
            var c_add_doc_country = document.getElementById("add_doc_country");
            var c_add_doc_zip = document.getElementById("add_doc_zip");
            var c_consulting_hrs = document.getElementById("consulting_hrs");
            var c_add_doc_aadhar_no = document.getElementById("add_doc_aadhar_no");
            var c_add_doc_voter_id = document.getElementById("add_doc_voter_id");
           
            
            c_add_doc_title.value = parsed_data.doctor.add_doc_title;
            c_add_doc_dob.value = parsed_data.doctor.add_doc_dob;
            c_add_doc_firstname.value = parsed_data.doctor.add_doc_firstname;
            c_add_doc_lastname.value = parsed_data.doctor.add_doc_lastname;
            c_add_doc_middlename.value = parsed_data.doctor.add_doc_middlename;
            c_add_doc_gender.value = parsed_data.doctor.add_doc_gender;
            c_add_doc_qualification.value = parsed_data.doctor.add_doc_qualification;
            c_add_doc_phone.value = parsed_data.doctor.add_doc_phone;
            c_add_doc_mobile.value = parsed_data.doctor.add_doc_mobile;
            c_add_doc_altmobile.value = parsed_data.doctor.add_doc_altmobile;
            $('#add_doc_specialty').val(parsed_data.doctor.add_doc_specialty);
             $("#add_doc_specialty").selectpicker('refresh');
            c_add_doc_addresslineone.value = parsed_data.doctor.add_doc_addresslineone;
            c_add_doc_addresslinetwo.value = parsed_data.doctor.add_doc_addresslinetwo;
            c_add_doc_city.value = parsed_data.doctor.add_doc_city;
            c_add_doc_state.value = parsed_data.doctor.add_doc_state;
            c_add_doc_country.value = parsed_data.doctor.add_doc_country;
            c_add_doc_zip.value = parsed_data.doctor.add_doc_zip;
            c_add_doc_aadhar_no.value = parsed_data.doctor.add_doc_aadhar_no;
            c_add_doc_voter_id.value = parsed_data.doctor.add_doc_voter_id;
            
            
            var $radios = $('input:radio[name=add_doc_gender]');
    if($radios.is(':checked') === false) {
        $radios.filter('[value="'+parsed_data.doctor.add_doc_gender+'"]').prop('checked', true);
    }

            
            
            // eof set data to modal
             $('#adddoctor-modal').modal('show');
                        //$('#add_doc_details').css("display", "block");
           // messagewindow.content.style.cssText="display:block";
           // messagewindow.open(map, marker);
          }
        });
    }
     
        }

        function searchData(hosp_name,place) {
            markersdata = [];
            var url = 'get_all_address.php?hosp_name=' + hosp_name;
            DeleteMarkers();
             getDefaultLocation("getdefaultlocation.php?default_location="+place);
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
               // $("#add_doc_details_modal").toggle();
                 //$('#adddoctor-modal').modal('show');

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
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      console.log(results)
        if (results[1]) {
         //formatted address
        // alert(results[0].formatted_address)
        //find country name
             for (var i=0; i<results[0].address_components.length; i++) {
            for (var b=0;b<results[0].address_components[i].types.length;b++) {

            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                    //this is the object you are looking for
                    city= results[0].address_components[i].long_name;
                    infoWind.setContent('You are Here @'+city);
                     setTimeout(function () { infoWind.close(); }, 3000);
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
</script>

</html>