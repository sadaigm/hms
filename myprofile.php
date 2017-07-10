<!DOCTYPE html>

<?php
if(!isset($_SESSION))
{
  session_start();
  if(!($_SESSION['email'] && $_SESSION['email_key'] ) )
  {
    session_destroy();
    header("Location: home.php");//redirect to login page to secure the welcome page without login access.
  }
}
?>
<html>

<head>
    <meta charset="utf-8">
   
    <title>Register</title>
   
</head>
 
    <link rel="stylesheet" href="assets/css/reg_user.css">
	<link rel="stylesheet" href="assets/css/style.min.css">
	
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<body>
   <?php include "pagelayout/navbar.php" ?>
<div id="content" class="col-lg-10 col-sm-11  full">
			
						
			<ol class="breadcrumb">
			  	<li><a href="home.php">Home</a></li>
				<li class="active"><a href="myprofile.php">Profile</a></li>
			  </ol>

			<div class="row profile">
				
				<div class="col-sm-3">
					
					<div class="row">
						<div class="">
							<img height="350"  class="profile-image" alt="" src="assets/img/gallery/photo9.jpg">
						</div>
						<div class="col-xs-12 col-sm-12">
							
							
							<h3>General Information</h3>
							
							

							<ul class="profile-details">
								<li>
									<div><i class="fa fa-briefcase"></i> position</div>
									CEO
								</li>
								<li>
									<div><i class="fa fa-building-o"></i> company</div>
									creativeLabs
								</li>
							</ul>		

							<h3>Contact Information</h3>

							
							<ul class="profile-details">
								<li>
									<div><i class="fa fa-phone"></i> phone</div>
									+48 123 456 789
								</li>
								<li>
									<div><i class="fa fa-tablet"></i> mobile phone</div>
									+48 123 456 789
								</li>
								<li>
									<div><i class="fa fa-envelope"></i> e-mail</div>
									lukasz@bootstrapmaster.com
								</li>
								<li>
									<div><i class="fa fa-map-marker"></i> address</div>
									Konopnickiej 42<br>
									43-190 Mikolow<br>
									Slask, Poland
								</li>
							</ul>
					<!--		
							<ul class="list-group">
            <li class="list-group-item text-muted">Profile</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span> 2.13.2014</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Last seen</strong></span> Yesterday</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Real name</strong></span> Joseph Doe</li>
            
          </ul>  -->
						</div>	
					</div><!--/row-->	

				</div><!--/col-->
				
				<div class="col-sm-9">
					
					<ul class="nav nav-tabs" id="myTab">
					  	<li class="active"><a href="myprofile.php#skills">Skills</a></li>
					  	<li class=""><a href="myprofile.php#friends">Friends</a></li>
					  	<li class=""><a href="myprofile.php#photos">Photos</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="skills">
							
							<div class="row">
								
								<div class="col-sm-5">
									<h2>About Me</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									<h2>Bio</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									<h2>Job</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									<h2>Languages</h2>
									<div class="row">
										<div class="col-xs-4">
											<div style="width: 110px; height: 110px; line-height: 110px;" class="language-skill1 easyPieChart" data-percent="90"><span>90</span>%<canvas width="110" height="110"></canvas></div>
						                    <div style="text-align:center">English</div>
										</div><!--/col-->
										<div class="col-xs-4">
											<div style="width: 110px; height: 110px; line-height: 110px;" class="language-skill2 easyPieChart" data-percent="43"><span>43</span>%<canvas width="110" height="110"></canvas></div>
						                    <div style="text-align:center">Spanish</div>
										</div><!--/col-->
										<div class="col-xs-4">
											<div style="width: 110px; height: 110px; line-height: 110px;" class="language-skill3 easyPieChart" data-percent="17"><span>-146654</span>%<canvas width="110" height="110"></canvas></div>
						                    <div style="text-align:center">German</div>
										</div><!--/col-->
									</div><!--/row-->
										
								</div><!--/col-->
								
								<div class="col-sm-7">
									<h2>History</h2>
									<!-- <ul class="skill-bar">
							        	<li>
							            	<h5>Web Design</h5>
							            	<div class="meter"><span class="lightBlue" style="width: 40%;">36%</span></div>
							          	</li>
							          	<li>
							            	<h5>Wordpress</h5>
							            	<div class="meter"><span class="green" style="width: 80%;">71%</span></div>
							          	</li>
							          	<li>
							            	<h5>Branding</h5>
							            	<div class="meter"><span class="red" style="width: 100%;">89%</span></div>
							          	</li>
							          	<li>
							            	<h5>SEO Optmization</h5>
							            	<div class="meter"><span class="lightOrange" style="width: 60%;">54%</span></div>
							          	</li>
										
							      	</ul>
							
									<h2>Other Skills</h2>
									<canvas id="canvas" class="chartjs" height="450" width="450" style="width: 450px; height: 450px;"></canvas>
									-->
										<ul class="list-group">
            <li class="list-group-item text-muted">Profile</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span> 2.13.2014</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Last seen</strong></span> Yesterday</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Real name</strong></span> Joseph Doe</li>
            
          </ul>
								</div><!--/col-->
									
							</div><!--/row-->		
							
						</div>
					  	<div class="tab-pane" id="friends">
							<ul class="friends-list clearfix">
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar.jpg"></a>
									<div>Lukasz Holeczek</div>
									<span class="label label-success">active</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar2.jpg"></a>
									<div>Ann Polansky</div>
									<span class="label label-warning">busy</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar3.jpg"></a>
									<div>May Lin</div>
									<span class="label label-important">blocked</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar4.jpg"></a>
									<div>Kate Norman</div>
									<span class="label label-default">offline</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar5.jpg"></a>
									<div>Mia Lopez</div>
									<span class="label label-important">blocked</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar6.jpg"></a>
									<div>Katia Svoboda</div>
									<span class="label label-success">active</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar7.jpg"></a>
									<div>Blanka Rosicky</div>
									<span class="label label-warning">busy</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar8.jpg"></a>
									<div>Garry Old</div>
									<span class="label label-success">active</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
								<li>
									<a class="avatar" href="page-profile.html#"><img src="assets/img/avatar9.jpg"></a>
									<div>Nick White</div>
									<span class="label label-success">active</span>
									<a href="page-profile.html#" class="fa fa-facebook-square"></a>
									<a href="page-profile.html#" class="fa fa-twitter-square"></a>
									<a href="page-profile.html#" class="fa fa-linkedin-square"></a>
								</li>
							</ul>	
						
					  	</div>
					  	<div class="tab-pane" id="photos">
					  		
							<div class="row">
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo1.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo2.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo3.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo4.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo5.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo6.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo7.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo8.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo9.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo10.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo11.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo12.jpg" alt="Sample Image">
								</div>
																<div style="margin-bottom:30px" class="col-sm-2 col-xs-6">
									<img class="img-thumbnail" src="assets/img/gallery/photo13.jpg" alt="Sample Image">
								</div>
															</div>
					
					  	</div>
					</div>
					
				</div><!--/col-->	

			</div><!--/profile-->		
			
       
					
			</div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/myprofile_toggle.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

</html>