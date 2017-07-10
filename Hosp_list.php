<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if(!isset($_SESSION))
{
  session_start();
  if(!($_SESSION['email'] && $_SESSION['email_key'] &&$_SESSION['loginMode']) )
  {
    session_destroy();
    
    header("Location: home.php");//redirect to login page to secure the welcome page without login access.
  }
  
}
include_once 'dbconfig/dbconfig.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KS Hospital Management</title>
		
	
	 <?php include "pagelayout/navbar.php" ?>
    </head>
	<link rel="stylesheet" href="assets/css/index.css">
        <link rel="stylesheet" href="assets/css/dropdown/bootstrap-select.css">
        
    <body>
	
        <div id="index_container" class="container">
            <div class="row">
            <div class="panel panel-info col-sm-12">
  <div class="panel-heading col-lg-12 doctor_panel">
    <h3 class="panel-title">Hospital List</h3>
  </div>
                <div class="panel-body col-lg-12">
                    <div class="well col-sm-12">
                        <div class="col-sm-4">
        <div class="control-group">
            <label for="add_doc_specialty">SPECIALITY *</label>
            <div class="controls">
              <!--   <input type="text" class="form-control" name="add_doc_specialty" id="add_doc_specialty" placeholder="SPECIALTY" required> </div> -->
                <select id="select_doc_specialty" class="selectpicker" name="select_doc_specialty" multiple="true" data-width="95%">
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
        </div>  <div class="control-group">
            <button class="btn btn-info" id="search_hosp" name="search_hosp" value="Search">Search</button>
        </div>
    </div>
                    </div>
                    <div id="hospital_list" >
            <div  class="panel panel-info col-sm-12">
                <div class="panel-body col-lg-12">
                    <div class="col-sm-12">
<!--            <div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                    <input type="text" class="form-control"  placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>  
                    </span>
                </div>
            </div>-->
 <?php
   //     $sql_query="SELECT * FROM testrun WHERE testrunID=".$_GET['editrun_id'];
   //  $result_set=mysql_query($sql_query);
 $rec_limit = 10;
   $Page_Name="Hosp_list.php";
         if( isset($_GET{'page'} ) ) {
            $page = $_GET{'page'} ;
            $offset = $rec_limit * ($page-1 );
             }else {
            $page = 1;
            $offset =0;
         }
          $cd_count ="SELECT * FROM markers";
          $cd_cou_res = mysqli_query($db_handle,$cd_count) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
          $cou_row = mysqli_num_rows ($cd_cou_res);
         $total_rec_count = $cou_row;
//         echo $total_rec_count;
        $total_page=intdiv($total_rec_count,$rec_limit);
        if(($total_rec_count % $rec_limit)!=0)
        {
           $total_page = $total_page +1; 
        }
//        echo "total_rec_count".$total_rec_count;
//        echo "rec_limit".$rec_limit;
//        echo "total".$total_page;
         //echo "offset".$offset;
         $cdquery="SELECT * FROM markers order by id "."LIMIT $offset, $rec_limit";
   //$result = mysqli_query($db_handle,$query);
   $cdresult=mysqli_query($db_handle,$cdquery) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
  // echo '<option value="">Select Module</option>';
   $row = mysqli_num_rows ($cdresult);
         $rec_count = $row[0];
          $left_rec = $rec_count - ($page * $rec_limit);
         $total_left_record = $total_rec_count - ($page * $rec_limit);
//         echo "total_rec_count".$total_rec_count;
//          echo "total_left_record".$total_left_record;
//         echo "page".$page;
//         echo "total_page -".$total_page;
   while ($cdrow=mysqli_fetch_array($cdresult,MYSQLI_ASSOC)) {
     $hos_name=$cdrow["name"];
     $hos_address=$cdrow["address"];
     // echo "<option value='$module_name'".
     // (($module_name == $result_set['module_name']) ? "selected='selected'":"").
     // ">$module_name</option>";
     echo "<button class='accordion'>$hos_name</button>";
     echo"<div class='cust_panel'>
  <p>$hos_address</p>
</div>";

   }
   //  echo "$selectedModuleName";
    ?>
        </div>
                     </div>
                  
                    <div class="panel-footer col-lg-12">
   <?php
   {
if( $page > 1 ) {
    $row_num = ($rec_limit*$page);
     echo "<a class='btn btn-info btn-xs' href = \"#\">count :$rec_limit</a> ";
            $last = $page - 2;
            $previous_page = $page-1;
           $next_page = $page + 1;
           echo "<a class='btn btn-default btn-xs' href = \"$Page_Name\">First</a> ";
           echo "<a class='btn btn-default btn-xs' href = \"$Page_Name?page=$previous_page\">Previous</a> ";
           echo "<a class='btn btn-danger btn-xs' href = \"#\">Page : $page of $total_page </a> ";
           if($page!=$total_page)
           {
               
                echo "<a class='btn btn-default btn-xs' href = \"$Page_Name?page=$next_page\">Next</a> ";
                echo "<a class='btn btn-default btn-xs' href = \"$Page_Name?page=$total_page\">Last</a> ";
           }
             
           
          
            
         }else if( $page == 1 ) {
             echo "<a class='btn btn-info btn-xs' href = \"#\">count :$rec_limit</a> ";
              echo "<a class='btn btn-danger btn-xs' href = \"#\">Page : $page of $total_page </a> ";
             $next_page = $page + 1;
            echo "<a class='btn btn-default btn-xs' href = \"$Page_Name?page=$next_page\">Next</a> ";
         }else if( $left_rec < $rec_limit ) {
             echo "<a class='btn btn-info btn-xs' href = \"#\">count :$rec_limit</a> ";
              echo "<a class='btn btn-danger btn-xs' href = \"#\">Page : $page of $total_page </a> ";
            $last = $page - 2;
            echo "<a class='btn btn-default btn-xs' href = \"$Page_Name?page=$total_page\">Last</a> ";
         }
   }
   ?>
        
            </div>
                </div>
                     
                  </div>
	</div>
                </div>
</div>
        <script src="assets/js/dropdown/bootstrap-select.js"></script>
 <?php include "pagelayout/footer.php" ?>
    </body>
    <script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  }
}
function filterHosp()
{
    var select_doc_specialty=$('#select_doc_specialty').val();
    console.log(select_doc_specialty);
    
   
    $.ajax({
type: 'POST',
url: 'gethosplist.php',
data: { specialities: select_doc_specialty},
success: function (data) {
    document.getElementById("hospital_list").innerHTML=data;
}
    });
}

 $('#search_hosp').click(function () {
    filterHosp(); 
 });
</script>
</html>
