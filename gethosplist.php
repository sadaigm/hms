<?php
include_once 'dbconfig/dbconfig.php';
if(isset($_POST['specialities']))
{

$c_specialities = $_POST['specialities'];
$itr="";
if($c_specialities!="")
{

   $comm="";
      foreach($c_specialities as $selected) {
         //printf("mod_name".$selected);
   $itr.=$comm.$selected;
   $comm="','";
 }
}
echo $itr;
 //$iteration_subquery="SELECT DISTINCT iteration_name FROM iteration where iteration_name in ('$itr')";
?>

            <div class="panel panel-info col-sm-12">
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
   $Page_Name="index.php";
         if( isset($_GET{'page'} ) ) {
            $page = $_GET{'page'} ;
            $offset = $rec_limit * ($page-1 );
             }else {
            $page = 1;
            $offset =0;
         }
         $cd_count ="SELECT * FROM markers";
         $cdquery="SELECT * FROM markers order by id "."LIMIT $offset, $rec_limit";
         if($itr!="")
         {
          $cd_count ="SELECT * FROM markers where speciality_name in ('$itr')";
           $cdquery="SELECT * FROM markers where speciality_name in ('$itr') order by id "."LIMIT $offset, $rec_limit";
         }
          $cd_cou_res = mysqli_query($db_handle,$cd_count) or die ("Query to get data from firsttable failed: ".mysqli_error($db_handle));
          $cou_row = mysqli_num_rows ($cd_cou_res);
         $total_rec_count = $cou_row;
         if($total_rec_count>0)
         {
//         echo $total_rec_count;
        $total_page=intdiv($total_rec_count,$rec_limit);
        if(($total_rec_count % $rec_limit)!=0)
        {
           $total_page = $total_page +1; 
          
        }
         //echo "offset".$offset;
        
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
               
<?php 
}
?>