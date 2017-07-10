<?php
include_once 'dbconfig/dbconfig.php';
 ?>
<?php
$username = mysqli_real_escape_string($db_handle,$_POST['username']);
if(isset($username))
{
  $check_user = "SELECT user_name user_count from users where user_name ='$username'";
  $result =  mysqli_query($db_handle,$check_user) or die("A MySQL error has occurred.<br />Your Query: " . $check_user . "<br /> Error: (" . mysqli_errno($db_handle) . ") " . mysqli_error($db_handle));
    if(mysqli_num_rows($result)>0){
    //and we send 0 to the ajax request
    echo 0;
}else{
    //else if it's not bigger then 0, then it's available '
    //and we send 1 to the ajax request
    echo 1;
}
}
else {
  echo 0;
}


?>
