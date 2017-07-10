<?php
if(isset($_POST['login-btn']))
{
  header("Location: login.php");
}
?>
<?php
include("dbconfig/dbconfig.php");
function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
?>

<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
  #signup .textlb{
    width: 60%;
  }
  #signup .textbtn{
    padding: 10px;
  }
  .signup-panel {
      margin-top: 70px;
    }
   


  </style>
   <link rel="stylesheet" href="assets/css/dropdown/bootstrap-select.css">
</head>
<body>
<?php include "pagelayout/navbar.php" ?>

  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-offset-2">
        <div class="signup-panel panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>User Registration</strong></h3>
          </div>
          <div class="panel-body">

            <form class="form-horizontal" id="signup" name="signup" action='add_user_details.php' enctype="multipart/form-data" method="POST">
              <fieldset>
                <div id="legend">
                  <legend class="">Sign-up</legend>
                </div>
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label" for="username">Username</label>
                  <div class="controls">
                    <input type="text" id="username" name="username"  onkeyup="check_username(); return false;" placeholder="" data-bv-notempty data-bv-notempty-message="The gender is required" class="form-control textlb" required>
  </div>
  <div class="textbtn">
                        <!-- <input type='button' id='check_username_availability' class="btn btn-primary" value='Check Availability'> -->
                        <span id="username_availability_result" style="font-weight:bolder;" class="usernameMessage"></span>
                      </div>
                    <p class="help-block">Username is case insensitive,should have Min 4 characters</p>
                  </div> 
                   <div class="control-group">
                    <!-- E-mail -->
                    <label class="control-label" for="role_name">User Role</label>
                  <div class="controls">
              <!--   <input type="text" class="form-control" name="add_doc_specialty" id="add_doc_specialty" placeholder="SPECIALTY" required> </div> -->
                      <select id="role_name" class="selectpicker form-control textlb" name="role_name" data-width="30%" onchange="validateRole();" required>
                  <?php
                  
                  $role_name_cdquery="SELECT DISTINCT role_name FROM roles";
                  $role_name_cdresult=mysqli_query($db_handle,$role_name_cdquery) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
                  echo '<option value="">Select Role</option>';
                  while ($role_name_cdrow=mysqli_fetch_array($role_name_cdresult,MYSQLI_ASSOC)) {
                    $role_name=$role_name_cdrow["role_name"];
                    echo "<option>$role_name</option>";

                  }
                  ?>
                </select>
                      </div>
                      <span id="role_name_result" style="font-weight:bolder;" class="usernameMessage"></span>
                      <p class="help-block">Please Select your User Role</p>
        
                     </div>
                  
                  <div class="control-group">
                    <!-- E-mail -->
                    <label class="control-label" for="email">E-mail</label>
                    <div class="controls">
                      <input type="email" id="email" name="email" onkeyup="isValidEmailAddress(); return false;" placeholder="" class="form-control textlb" required>
                      <span id="email_availability_result" style="font-weight:bolder;" class="usernameMessage"></span>
                      <p class="help-block">Please provide your E-mail</p>
                    </div>
                  </div>
                  <div class="control-group">
                    <!-- Password-->
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                      <input type="password" id="password" name="password" placeholder=""  onkeyup="checkpasswordlength(); return false;"  class="form-control textlb" required>
                       <span id="passwordMessage" class="passwordMessage"></span>
                      <p class="help-block">Provide Min 6 to Max 20 chars which contains at least 1 numeric digit, 1 uppercase and 1 lowercase letter</p>
                    </div>
                  </div>
                  <div class="control-group">
                    <!-- Password -->
                    <label class="control-label" for="password_confirm">Password (Confirm)</label>
                    <div class="controls">
                      <input type="password" id="password_confirm" name="password_confirm" placeholder="" onkeyup="checkPass(); return false;" class="form-control textlb">
                       
                      <span id="confirmMessage" class="confirmMessage"></span>
                      <p class="help-block">Please confirm password</p>
                    </div>
                  </div>
                    <div class="control-group">
                  <label class="control-label">Select File</label>
                    <div class="controls">
<input id="profile_pic" name="profile_pic" type="file" class="file"  multiple data-show-upload="false" data-preview-file-type="any" data-show-caption="true">
<div id="errorBlock" class="help-block"></div>
<p class="help-block">Please upload profile picture</p>

</div>
</div>
                  <div class="control-group">
                    <!-- Button -->
                    <div class="controls">
                      <button type="submit" id="Register"  class="btn btn-success">Register</button>
<!--                      <a href="login.php" class="btn btn-success"> <strong>Login</strong></a>-->
                        <a href="login.php" class="btn btn-danger"> <strong>Cancel</strong></a>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
   <link type="text/css" rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/file-input/fileinput.js" type="text/javascript"></script>
  <link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
      <!-- jquery validate js -->
      <script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>

      <!-- custom form validation script for this page-->
      <script src="assets/js/form-validation-script.js"></script>
      <link href="assets/css/cstyle.css" rel="stylesheet" />
  <script charset="utf-8">
  function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('password');

    var pass2 = document.getElementById('password_confirm');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    var Register = document.getElementById('Register');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match.
        //Set the color to the good color and inform
        //the user that they have entered the correct password
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
        Register.disabled = false;
        return true;
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
        Register.disabled = true;
        return false;
    }
}

function checkpasswordlength()
{
  var message = document.getElementById('passwordMessage');
    var pass1 = document.getElementById('password');
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    var pass2 = document.getElementById('password_confirm');
    console.log(pass1.value.length);

    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
//if(inputtxt.value.match(passw))
//http://www.w3resource.com/javascript/form/password-validation.php
if(!passw.test(pass1.value))
{    pass1.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.innerHTML = "Invalid Password";

      pass2.disabled = true;
      return false;
}
else
{
  pass1.style.backgroundColor = goodColor;
  message.style.color = goodColor;
  message.innerHTML = "ok";
  pass2.disabled = false;
  return true;
}
}

$(document).ready(function() {

		//the min chars for username
		var min_chars = 4;
    var goodColor = "rgb(4, 132, 4)";
    var badColor = "rgb(148, 8, 8)";
		//result texts
		var characters_error = 'Minimum amount of chars is 4';
		var checking_html = 'Checking...';
var message = document.getElementById('username_availability_result');
		//when button is clicked
		$('#check_username_availability').click(function(){
			//run the character number check
			if($('#username').val().length < min_chars){
				//if it's bellow the minimum show characters_error text '
        message.innerHTML = characters_error;
			//	$('#username_availability_result').html(characters_error);
            message.style.color = badColor;
			}else{
				//else show the cheking_text and run the function to check
          message.innerHTML = checking_html;
				//$('#username_availability_result').html(checking_html);
        check_availability();
			}
		});
	$('#Register').click(function(event){
    var isValidationPassed = onsubmit();
    var username = $('#username').val();
    var password_confirm = $('#password_confirm').val();
    var email = $('#email').val();
    var profile_pic = $('#profile_pic').val();
    console.log("isValidationPassed :"+isValidationPassed);
    console.log("username :"+username);
    console.log("password_confirm :"+password_confirm);
    console.log("email :"+email);
    console.log("profile_pic :"+profile_pic);
    if(isValidationPassed)
    {
      // $.post("add_user_details.php", { username: username ,password_confirm : password_confirm,email : email,profile_pic : profile_pic},
      //   function(result){
      //     console.log("Passed");
      //
      // });

  }
  else{
  event.preventDefault();
  }
});

  });

// f
function check_username(){
  var min_chars = 4;
  var goodColor = "rgb(4, 132, 4)";
  var badColor = "rgb(148, 8, 8)";
  //result texts
  var characters_error = 'Minimum amount of chars is 4';
  var checking_html = 'check for username availability';
var message = document.getElementById('username_availability_result');
  if($('#username').val().length < min_chars){
    //if it's bellow the minimum show characters_error text '
    message.innerHTML = characters_error;
  //	$('#username_availability_result').html(characters_error);
        message.style.color = badColor;
  }else{
    //else show the cheking_text and run the function to check
    //  message.innerHTML = checking_html;
      //message.style.color = "#000";
      check_username_availability();
    //$('#username_availability_result').html(checking_html);

  }
}
function validateRole()
{
    var goodColor = "rgb(4, 132, 4)";
  var badColor = "rgb(148, 8, 8)";
  //console.log($('#role_name').val())
  
  //result texts
  var characters_error = 'Role is missing';
  var valid_message = 'ok';
    var message = document.getElementById('role_name_result');
    if($('#role_name').val().length < 1){
    //if it's bellow the minimum show characters_error text '
    message.innerHTML = characters_error;
  //	$('#username_availability_result').html(characters_error);
        message.style.color = badColor;
        return false;
  }
  else{
       message.innerHTML = valid_message;
       message.style.color = badColor;
        return true;
  }
}
function validateUsername(){
  var min_chars = 4;
  var goodColor = "rgb(4, 132, 4)";
  var badColor = "rgb(148, 8, 8)";
  //result texts
  var characters_error = 'Minimum amount of chars is 4';
  var checking_html = 'check for username availability';
var message = document.getElementById('username_availability_result');
  if($('#username').val().length < min_chars){
    //if it's bellow the minimum show characters_error text '
    message.innerHTML = characters_error;
  //	$('#username_availability_result').html(characters_error);
        message.style.color = badColor;
        return false;
  }else{
    //else show the cheking_text and run the function to check

  return check_availability();

  }
}
function check_username_availability()
{
  //get the username
  var username = $('#username').val();
  var goodColor = "rgb(4, 132, 4)";
  var badColor = "rgb(216, 10, 10)";

  //use ajax to run the check
console.log("username : "+username);
$.post("check_username_avail.php", { username: username },
    function(result){
      //if the result is 1
      var message = document.getElementById('username_availability_result');
      if(result == 1){
        //show that the username is available
          message.innerHTML = username + " is Available";
      //	$('#username_availability_result').html(username + ' is Available');
          message.style.color = goodColor;
            return true;

      }else{
        //show that the username is NOT available
        message.innerHTML = username + " is not Available";
      //	$('#username_availability_result').html(username + ' is not Available');
          message.style.color = badColor;
          return false;
      }

  });
}

//function to check username availability
function check_availability(){

		//get the username
		var username = $('#username').val();
    var goodColor = "rgb(4, 132, 4)";
    var badColor = "rgb(216, 10, 10)";

		//use ajax to run the check
console.log("username : "+username);
	$.post("check_username_avail.php", { username: username },
			function(result){
				//if the result is 1
        var message = document.getElementById('username_availability_result');
				if(result == 1){
					//show that the username is available
            message.innerHTML = username + " is Available";
				//	$('#username_availability_result').html(username + ' is Available');
            message.style.color = goodColor;
              return true;

				}else{
					//show that the username is NOT available
          message.innerHTML = username + " is not Available";
				//	$('#username_availability_result').html(username + ' is not Available');
            message.style.color = badColor;
            return false;
				}

		});
    //console.log(resulttest);
// var ss=null;
//     resulttest.done(function( data ) {
//       console.log("ata.today_execution_count :"+data.today_execution_count);
//     //var content = data.today_execution_count;
//     if(data.today_execution_count== 1)
//     {
//         console.log(username + " is Available");
//         ss=true;
//       return true;
//     }
//     else if(data.today_execution_count== 2)
//     {
//         console.log(username + " is Invalid");
//         ss=true;
//       return true;
//     }
//     else {
//       ss=true;
//         console.log(username + " is not Available");
//       return false;
//     }
//   });
      var message = document.getElementById('username_availability_result');
      console.log(message.style.color);
      console.log(goodColor);
      if(message.style.color== goodColor)
      {
          console.log(username + " is Available");
        return true;
      }
      else {
          console.log(username + " is not Available");
        return false;
      }
//console.log("content : : "+ss);
    return false;


}

function isValidEmailAddress() {
    var email = $('#email').val();
    var goodColor = "rgb(4, 132, 4)";
    var badColor = "rgb(216, 10, 10)";
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
email_availability_result

var message = document.getElementById('email_availability_result');
var testResults = pattern.test(email);
console.log("email results : "+testResults);
if(testResults){
  //show that the username is available
    message.innerHTML = email + " - ok";
//	$('#username_availability_result').html(username + ' is Available');
    message.style.color = goodColor;
      return true;

}else{
  //show that the username is NOT available
  message.innerHTML = "\""+email + "\" is a Invalid Email Address";
//	$('#username_availability_result').html(username + ' is not Available');
    message.style.color = badColor;
    return false;
}
    return testResults;
};
function onsubmit()
{
  var isvalid = validateUsername();
  var isValidEmail = isValidEmailAddress();
  var islengthvalid =checkpasswordlength();
  var pass2 = document.getElementById('password_confirm');
 var isRoleValid = validateRole();
        //var ispasswordvalid = false;
  if(islengthvalid)
  {
    var ispasswordvalid = checkPass();

  console.log("checkpasswordlength"+islengthvalid);
  console.log("checkPassword"+ispasswordvalid);
  console.log("validateUsername : "+isvalid);
  if(ispasswordvalid && isvalid && isValidEmail && isRoleValid)
  {
    return true;
  }
  else{
    return false;
  }
}
  }


function checkForm(form)
  {
    if(form.username.value == "") {
      alert("Error: Username cannot be blank!");
      form.username.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.username.value)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      form.username.focus();
      return false;
    }

    if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
      if(form.pwd1.value.length < 6) {
        alert("Error: Password must contain at least six characters!");
        form.pwd1.focus();
        return false;
      }
      if(form.pwd1.value == form.username.value) {
        alert("Error: Password must be different from Username!");
        form.pwd1.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one number (0-9)!");
        form.pwd1.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one lowercase letter (a-z)!");
        form.pwd1.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.pwd1.value)) {
        alert("Error: password must contain at least one uppercase letter (A-Z)!");
        form.pwd1.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.pwd1.focus();
      return false;
    }

    alert("You entered a valid password: " + form.pwd1.value);
    return true;
  }

  $("#profile_pic").fileinput({
    'showPreview' : false,
    'allowedFileExtensions' : ['jpg', 'png','gif'],
'elErrorContainer': '#errorBlock',

	});
        
        $("#password_confirm").on("keyup",function(){
    if($(this).val())
        $(".glyphicon-eye-open").show();
    else
        $(".glyphicon-eye-open").hide();
    });
$(".glyphicon-eye-open").mousedown(function(){
                $("#password_confirm").attr('type','text');
            }).mouseup(function(){
            	$("#password_confirm").attr('type','password');
            }).mouseout(function(){
            	$("#password_confirm").attr('type','password');
            });
             $("#password").on("keyup",function(){
    if($(this).val())
        $(".glyphicon-eye-open").show();
    else
        $(".glyphicon-eye-open").hide();
    });
$(".glyphicon-eye-open").mousedown(function(){
                $("#password").attr('type','text');
            }).mouseup(function(){
            	$("#password").attr('type','password');
            }).mouseout(function(){
            	$("#password").attr('type','password');
            });
        
  </script>
<script src="assets/js/dropdown/bootstrap-select.js"></script>
  </html>
