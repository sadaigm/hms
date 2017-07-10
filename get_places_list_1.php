<?php
include_once ('./dbconfig/dbconfig.php');

$limit = 5;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
  
$sql = "SELECT * FROM appbooking order by sno ASC LIMIT $start_from, $limit";  
$rs_result = mysqli_query ($db_handle,$sql);  

?>
<ul class="list-group">
<?php  
 while ($cdrow=mysqli_fetch_array($rs_result,MYSQLI_ASSOC)) {
     $booking_id=$cdrow["booking_id"];
     $c_hos_name=$cdrow["c_hos_name"];
?>  
           <li class='list-group-item'><span><?php echo $booking_id.".".$c_hos_name;?></span></li>
<?php  
};  
?>  
 </ul> 

  <?php

$sql = "SELECT count(*) FROM appbooking";  
$rs_result = mysqli_query ($db_handle,$sql);  
$row = mysqli_fetch_row($rs_result);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit); 
$next_page =$page+1;
?>
                      
                        <div align="center">
<ul class='pagination text-center' id="pagination">

            
<?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
            if($i == $page):?>
            <li class='active'  id="<?php echo $i;?>"><a href='#'><?php echo $i;?></a></li> 
            <?php else:?>
            <li  id="<?php echo $i;?>"><a href='#'><?php echo $i;?></a></li>
        <?php endif;?>  
             
<?php endfor;endif;?>  
          <?php if($total_records>$limit)
          {
              ?>
          
            <li id="<?php echo $next_page;?>" ><a id="next_page" href="#" aria-label="Next"><span aria-hidden="true">Next »</span></a></li>
            <?php 
            }
            ?>
            
</div>