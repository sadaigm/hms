<?php
if(!isset($_SESSION))
{
  session_start();
  if(!($_SESSION['email'] && $_SESSION['email_key'] &&$_SESSION['loginMode']) )
  {
    session_destroy();
      header("Location: login.php");//redirect to login page to secure the welcome page without login access.
  }
}
?>
<?php
include_once 'dbconfig/dbconfig.php';

// delete condition
if(isset($_GET['delete_doctor_id']))
{
  $myArray = explode(',', base64_decode($_GET['delete_doctor_id']));
  print_r($myArray);
$sql_query="DELETE FROM doctor WHERE doctor_id=".$myArray[1];
 mysql_query($sql_query);
 header("Location: $_SERVER[PHP_SELF]");
}
// delete condition

//edit doctor
if(isset($_GET['editdoctor_id']))
{
    $myArray = explode(',', base64_decode($_GET['editdoctor_id']));
    // print_r($myArray[1]);
 $sql_query="SELECT * FROM doctor WHERE doctor_id=".$myArray[1];
 $result_set=mysql_query($sql_query);
// print_r($result_set);
// print_r(json_encode(mysql_query($sql_query)));
	die(json_encode(mysql_fetch_assoc($result_set)));

}

//update doctor btn-editdoctor
if(isset($_POST['btn-editdoctor']))
{
  $doctor_id = mysql_real_escape_string($_POST['editdoctor_id']);
  $doctor_name = mysql_real_escape_string($_POST['editdoctorName']);
  $created_user = mysql_real_escape_string($_POST['editdoctor_user']);
  $oldmod_name="SELECT doctor_name FROM doctor where doctor_id = '$doctor_id'";
           $oldmod_nameresult1=mysql_query($oldmod_name) or die ("Query to get data from firsttable failed: ".mysql_error());

           if ($oldmod_namerow=mysql_fetch_array($oldmod_nameresult1)) {
           $olddoctor_name=$oldmod_namerow["doctor_name"];
           }


  $sql_query = "UPDATE doctor SET doctor_name = '$doctor_name', created_user= '$created_user' WHERE doctor_id='$doctor_id'";
    $testcase_query = "UPDATE testcases SET doctor = '$doctor_name' WHERE doctor='$olddoctor_name'";
$testcase_query_value = mysql_query($testcase_query);
  $value = mysql_query($sql_query);// or die("A MySQL error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
  if($value && $testcase_query_value)
  {
    $sql_query1 = "UPDATE doctor_wise_audit SET doctor = '$doctor_name', created_user= '$created_user' WHERE doctor_id='$doctor_id'";

    $value1 = mysql_query($sql_query1);// or die("A MySQL error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
if($value1)
{
    ?>
    <script type="text/javascript">
    window.location.href='listdoctors.php';
    alert('Data Are Inserted Successfully ');
    </script>
    <?php
  }
  else{
    echo '<script type="text/javascript">alert("A MySQL error has occurred while inserting your data \n \n Your Query: \n'. $sql_query1 .' \n\n Error Message: \n'.mysql_real_escape_string(mysql_error()).'");</script>';
  }
  }
  else
  {

    echo '<script type="text/javascript">alert("A MySQL error has occurred while inserting your data \n \n Your Query: \n'. $sql_query .' \n\n Error Message: \n'.mysql_real_escape_string(mysql_error()).'");</script>';

  }
}

// add doctor

if(isset($_POST['btn-adddoctor']))
{
  $add_doctor_id = 0;
  $add_doc_title = mysqli_real_escape_string($db_handle , $_POST['add_doc_title']);
  $add_doc_dob = mysqli_real_escape_string($db_handle , $_POST['add_doc_dob']);
  $add_doc_firstname = mysqli_real_escape_string($db_handle , $_POST['add_doc_firstname']);
  $add_doc_lastname = mysqli_real_escape_string($db_handle , $_POST['add_doc_lastname']);
  $add_doc_middlename = mysqli_real_escape_string($db_handle , $_POST['add_doc_middlename']);
  $add_doc_gender = mysqli_real_escape_string($db_handle , $_POST['add_doc_gender']);
  $add_doc_phone = mysqli_real_escape_string($db_handle , $_POST['add_doc_phone']);
  $add_doc_mobile = mysqli_real_escape_string($db_handle , $_POST['add_doc_mobile']);
  $add_doc_altmobile = mysqli_real_escape_string($db_handle , $_POST['add_doc_altmobile']);
  $add_doc_email = mysqli_real_escape_string($db_handle , $_POST['add_doc_email']);
  $add_doc_specialty = mysqli_real_escape_string($db_handle , $_POST['add_doc_specialty']);
  $add_doc_addresslineone = mysqli_real_escape_string($db_handle , $_POST['add_doc_addresslineone']);
  $add_doc_addresslinetwo = mysqli_real_escape_string($db_handle , $_POST['add_doc_addresslinetwo']);
  $add_doc_city = mysqli_real_escape_string($db_handle , $_POST['add_doc_city']);
  $add_doc_state = mysqli_real_escape_string($db_handle , $_POST['add_doc_state']);
  $add_doc_country = mysqli_real_escape_string($db_handle , $_POST['add_doc_country']);
  $add_doc_zip = mysqli_real_escape_string($db_handle , $_POST['add_doc_zip']);
  /*$add_doc_profilepic = mysqli_real_escape_string($db_handle , $_POST['add_doc_profilepic']);*/

  $sql_query = "INSERT INTO doctors (doctor_id,title,dob,firstname,lastname,middlename,gender,phone,mobile,altmobile,email,specialty,addresslineone,addresslinetwo,city,state,country,zip) VALUES ('$add_doctor_id','$add_doc_title','$add_doc_dob','$add_doc_firstname','$add_doc_lastname','$add_doc_middlename','$add_doc_gender','$add_doc_phone','$add_doc_mobile','$add_doc_altmobile','$add_doc_email','$add_doc_specialty','$add_doc_addresslineone','$add_doc_addresslinetwo','$add_doc_city','$add_doc_state','$add_doc_country','$add_doc_zip')";
  $value = mysqli_query($db_handle,$sql_query);// or die("A mysqli error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysqli_errno() . ") " . mysqli_error());
  if($value)
  {
    
    ?>
    <script type="text/javascript">
    window.location.href='listdoctors.php';
    alert('Data Are Inserted Successfully ');
    </script>
    <?php
  }
  else
  {

    echo '<script type="text/javascript">alert("A mysqli error has occurred while inserting your data \n \n Your Query: \n'. $sql_query .' \n\n Error Message: \n'.mysqli_real_escape_string($db_handle,mysqli_error($db_handle)).'");</script>';

  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>List Of Doctors</title>

  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/jquery.dataTables.css">
  <link href="assets/bootstrap/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/dataTables.responsive.css">
<link rel="stylesheet" href="assets/css/dropdown/bootstrap-select.css">

    
</head>
 <?php include "pagelayout/footer.php" ?>
    <?php include "pagelayout/navbar.php" ?>
<body>
  <!-- container section start -->
  <section id="container" class="">

   


    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div id="row_div" class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> <b>List of Doctors</b></h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php"><b>Home</b></a></li>
              <li><i class="fa fa-bars"></i><a href="listdoctor.php"><b>Doctors</b></a></li>

            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="content">
          <div id="row_div" class="row">
            <div id="toolbar_div" class="col-sm-10 col-sm-offset-0">
              <!-- <h3>Test Case Management</h3> -->
              <!-- <a class="dashlink" href="index.php">back to Dashboard</a> -->
              <!-- <a href='adddoctor.php'>   <button type="button" class="btn btn-primary">Adddoctor</button></a> -->
              <a href="#adddoctor-modal" data-toggle="modal" class="btn btn-primary">Adddoctor</a>


              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="adddoctor-modal" class="modal fade">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                              <h4 class="modal-title">Add doctor</h4>
                          </div>
                          <div class="modal-body">
                              <form id="adddoctor_form" class="form-horizontal" method="post" role="form">
                                  <div id="row_div" class="row">

                                 
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
       <div class="col-sm-4">
        <div class="control-group">
            <label for="add_doc_dob">DOB *</label>
            <div class="controls">
                <input type="text" class="form-control" name="add_doc_dob" id="add_doc_dob" placeholder="DOB" required> </div>
        </div>
        </div>
        <div class="col-sm-4">
        <div class="control-group">
            <label for="add_doc_gender">GENDER *</label>
            <div class="controls">
            <label class="radio-inline">
      <input type="radio" name="add_doc_gender">Male
    </label>
    <label class="radio-inline">
      <input type="radio" name="add_doc_gender">Female
    </label>
                <!-- <input type="text" class="form-control" name="add_doc_gender" id="add_doc_gender" placeholder="GENDER" required> -->
                 </div>
        </div>
        </div>
        <div class="col-sm-4">
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
                <input type="text" class="form-control" name="add_doc_email" id="add_doc_email" placeholder="EMAIL" required> </div>
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
                                  <button type="submit" name="btn-adddoctor" class="btn btn-primary">Add</button>
                                </div>
                              </form>

                          </div>

                      </div>
                  </div>
              </div>



              <!-- <a href='addtestcase.php'>   <button type="button" class="btn btn-primary">AddTestCase</button></a> -->



            </div>
            <div id="edit_dialog"></div>


            <div id="listdoctor_div" class="col-sm-11 col-sm-offset-0">
              <table id="doctor" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>

                  <tr>
                    <th>Doctor ID</th>
                    <th>Doctor Name</th>
                    <th>Mobile</th>
                    <th>AreaName</th>
                    <th>City</th>
                      <th>Actions</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>

        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
  </section>
 
<script src="assets/js/datatable/jquery.js"></script>
    <!-- <script src="assets/bootstrap/js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="assets/bootstrap/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/dataTables.responsive.min.js"></script>


<!-- Latest compiled and minified JavaScript -->

<script src="assets/js/dropdown/bootstrap-select.js"></script>
  <!-- custom dataTable display script -->
  <script type="text/javascript" language="javascript" class="init">

  $(document).ready(function() {
    $('#doctor').dataTable( {
      "aProcessing": true,
      "aServerSide": true,
      responsive: true,
      "ajax": "server-response_doctor.php"
    } );
  } );

  function editRow(id) {
    if ( 'undefined' != typeof id ) {
      $.getJSON('listdoctors.php?editdoctor_id=' + id, function(obj) {
        $('#editdoctor_user').val(obj.created_user);
        $('#editdoctor_id').val(obj.doctor_id);
        $('#editdoctorName').val(obj.doctor_name);
        $('#editdoctor_id-modal').modal('show');
        $('#editdoctor_id-modal').css("display","block");
      }).fail(function() {
        alert('Unable to fetch data, please try again later.') });
    } else alert('Unknown row id.');
  }
  </script>
  <script type="text/javascript">
  function edt_doctor(id)
  {
    if(confirm('Sure to edit ?'))
    {

      /*edit button as popup*/

      var dlg=$('#editdoctor_id').dialog({
        title: 'editdoctor_id',
        resizable: true,
        autoOpen:false,
        modal: true,
        hide: 'fade',
        width:600,
        height:400
      });

      dlg.load('listdoctors.php?editdoctor_id='+id, function(){
        dlg.dialog('open');

      });
      // window.location.href='edit_testcase.php?Test_case_idpk='+id;
    }
  }
  function delete_doctor(id)
  {
    console.log(id);
    if(confirm('Sure to Delete ?'))
    {
      window.location.href='listdoctors.php?delete_doctor_id='+id;
    }
  }
  </script>
  <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editdoctor_id-modal" class="modal fade">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                  <h4 class="modal-title">Add doctor</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" method="post" role="form">
                    <div class="control-group">
                        <label  for="editdoctor_id">doctor Id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                         <div class="controls">
                        <input  type="text" class="form-control" name="editdoctor_id" id="editdoctor_id" placeholder="doctor Id" readonly >
                    </div>
                    </div>

                      <div class="control-group">
                          <label for="editdoctorName">doctor Name</label>
                           <div class="controls">
                          <input type="text" class="form-control" name="editdoctorName" id="editdoctorName" placeholder="doctor Name" >
                      </div>
                      </div>
                      <div class="control-group">
                          <label for="editdoctor_user">Created User</label>
                           <div class="controls">
                          <input  type="text" class="form-control sm-input " name="editdoctor_user" id="editdoctor_user" placeholder="Created User" >
                      </div>
                      </div>
                      <div class="modal-footer">
                      <button type="submit" name="btn-editdoctor" class="btn btn-success">update</button>
                    </div>
                  </form>

              </div>

          </div>
      </div>
  </div>
</body>

</html>
