
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button><a class="navbar-brand navbar-link" href="index.php"><strong>KS Hospital Management </strong></a></div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="" role="presentation"><a href="Hosp_list.php">Hospitals </a></li>
                    <li role="presentation"><a href=<?php 
					if(!isset($_SESSION))
{
	
 echo "\"patients.php\">Patients";
}
else{
	 if((isset($_SESSION['email'] )&& isset($_SESSION['email_key'] ) ))
  {
             if($_SESSION['email'] =="GUEST")
      {
          echo "\"#\">Verify Account";
      }
      else{
     echo "\"myprofile.php\">MyProfile";
     }
  }
  else{
      
          echo "\"patients.php\">Patients";
      
	
}	
	
}

?></a></li>
                    <li role="presentation"><a href="#">Contact Us</a></li>
                    
                    <li role="presentation"><a href=<?php
if(!isset($_SESSION))
{
	
  echo "\"#\" id='sign_in' name='sign_in'>Sign In";
}
else
{
	 if((isset($_SESSION['email'] )&& isset($_SESSION['email_key'] ) ))
  {
    if(isset($_SESSION['role'] ) && $_SESSION['email']=="DOCTOR")
    {
      echo "\"bookappointment.php\">DOCTOR Appointment";
    }
    else if(isset($_SESSION['role'] ) && $_SESSION['email']=="CUSTOMER")
    {
      echo "\"bookappointment.php\">CUSTOMER Appointment";
    }
    else{
      echo "\"bookappointment.php\">Book Appointment";
    }



      
  }
  else if(isset($_SESSION['role'] ))
      {
	echo "\"signup.php\" id='register' name='register'>Register";
}
else
      {
	echo "\"#\" id='sign_in' name='sign_in'>Sign In";
}
  
}
?></a></li>
                   <?php
if(isset($_SESSION))
{
  if((isset($_SESSION['email'] )&& isset($_SESSION['email_key'] ) ))
  {
     echo " <li role=\"presentation\"><a href=\"logout.php\">Sign Out</a></li>";
  }
//  else{
//	echo "\"register.php\">Register";
//}	
}
//else{
//	echo "\"register.php\">Register";
//}

?>
                </ul>
            </div>
        </div>
    </nav>
   
    <script src="assets/js/jquery.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    
    
   
    
    
