<!DOCTYPE html>

<?php
if(!isset($_SESSION))
{
  session_start();
  //printf("check1 ");
  
  if((isset($_SESSION['email'] )&& isset($_SESSION['email_key'] )) || (isset($_SESSION['userData'])&& isset($_SESSION['loginMode'])) )
  {
	  //printf($_SESSION['email'] );
	 // printf($_SESSION['email_key'] );
   // session_destroy();
      if(isset($_SESSION['role']) && $_SESSION['role']=="DOCTOR")
      {
            header("Location: my_account.php");//redirect to login page to secure the welcome page without login access.
    
      }
      else
      {
        header("Location: index.php");//redirect to login page to secure the welcome page without login access.
      }
  }
//  if(!isset($_SESSION['role']))
//  {
//      $_SESSION['role']="customer";
//  }
  
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KS Hospital Management</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/css/dropdown/bootstrap-select.css">
    
    <script src="assets/js/jquery.min.js"></script>
<!--    <script src="assets/bootstrap/js/bootstrap.min.js"></script>-->
    
    
    
</head>

<body>
   <?php 
   include_once 'dbconfig/dbconfig.php';
   include "pagelayout/navbar.php" ?>
    
    <div class="container">

        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-8">
    <div id="promo">
        <div class="jumbotron">
            <h1>Health is Wealth</h1>
            <p>Assuring. Advanced. Accessible.Our team of over 5000 doctors join me in giving you the best of modern healthcare to ensure you stay healthy, always.</p>
            <p><a class="btn btn-primary" role="button" href="#">Check your Appointment</a></p>
        </div>
    </div>
     </div>
            <div class="col-md-4">
                <h1>Login Here</h1>
                <div style="text-align: center">
                <a class="btn btn-info" id="doctor_login" href="#">I am a doctor</a>
                <a class="btn btn-success" id="customer_login" href="#">I am a customer</a>
                </div>
                <div style="text-align: center">
                    HMS allow the user to Direct Login using Google Account
                </div>
            </div>
            </div>
        </div>
    
    
     <script src="assets/js/dropdown/bootstrap-select.js"></script>
    
</body>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="selectrole_modal" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">select your role</h4>
            </div>
            <div class="modal-body">
              
              

                    <div class="control-group">
                        <label for="user_role">Role *</label>
                        <div class="controls">
                            <select id="user_role" class="selectpicker" name="user_role" data-width="95%">
                                <?php
                                $role_name_cdquery = "SELECT DISTINCT role_name FROM roles order by role_id";
                                $role_name_cdresult = mysqli_query($db_handle, $role_name_cdquery) or die("Query to get data from firsttable failed: " . mysqli_error($db_handle));
                                echo '<option value="">Select Role</option>';
                                while ($role_name_cdrow = mysqli_fetch_array($role_name_cdresult, MYSQLI_ASSOC)) {
                                    $role_name = $role_name_cdrow["role_name"];
                                    echo "<option>$role_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" name="select_role" id="select_role"  class="btn btn-success">Submit</button>
                    </div>
               

            </div>

        </div>
    </div>
</div>
 
    <script type="text/javascript" >
        $(document).ready(function() {
             $('.selectpicker').selectpicker();
        $('#sign_in').click(function(event){
            $('#selectrole_modal').modal('show');
//        $('#selectrole_modal').css('display','block'); 
        });
         $('#doctor_login').click(function(event){
            window.location.href="login.php?role=DOCTOR";
        });
         $('#customer_login').click(function(event){
            window.location.href="login.php?role=CUSTOMER";
        });
         $('#select_role').click(function(event){
         var user_role =  $('#user_role').val();
           window.location.href="login.php?role="+user_role;
        });
    });
        </script>
        
</html>