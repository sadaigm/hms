<?php
include_once 'dbconfig/dbconfig.php';
 ?>
<?php
$username = mysqli_real_escape_string($db_handle,$_POST['username']);
$password_confirm = mysqli_real_escape_string($db_handle,$_POST['password_confirm']);
$email = mysqli_real_escape_string($db_handle,$_POST['email']);
$role_name = mysqli_real_escape_string($db_handle,$_POST['role_name']);
$file_message = "";
$profile_pic = "avatar1.jpg";
if($_FILES['profile_pic']['name']!="")
{
$profile_pic = $username."_".$_FILES['profile_pic']['name'];
}
print_r($username+$password_confirm+$email);
 if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], "img/users/".$profile_pic))
 {
   $file_message = "Received $profile_pic - its size is {$_FILES['profile_pic']['size']}";
   //print "Received {$_FILES['profile_pic']['name']} - its size is {$_FILES['profile_pic']['size']}";
   print $file_message."";
   } else {
       //print "Upload failed!";
   }
$profile_pic_path = $username."_".$_FILES['profile_pic']['name'];
print_r($username+$password_confirm+$email+$profile_pic_path);
$sql_query = "INSERT INTO users (user_name, user_pass,user_email,profile_pic_path,role) VALUES ('$username','$password_confirm','$email','$profile_pic_path','$role_name')";
$value = mysqli_query($db_handle,$sql_query);// or die("A MySQL error has occurred.<br />Your Query: " . $sql_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
if($value)
{
  ?>
  <script type="text/javascript">

  alert('Data Are Inserted Successfully');
  window.location.href='login.php?role=<?php echo $role_name ?>';
  </script>
  <?php
}
else
{
  ?>
  <script type="text/javascript">


  alert('error occured while inserting your data');
  </script>
  <?php
}



?>
