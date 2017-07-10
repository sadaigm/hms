<?php
include_once ('./dbconfig/dbconfig.php');

$limit = 5;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

$sql = "SELECT * FROM appbooking order by sno DESC LIMIT $start_from, $limit";
$rs_result = mysqli_query($db_handle, $sql);
$next_page =$page+1;
?>
<ul onscroll="getNext(<?php echo $next_page;?>)" class="chat" id="<?php echo $page;?>">
    <?php
    while ($cdrow = mysqli_fetch_array($rs_result, MYSQLI_ASSOC)) {
        $booking_id = $cdrow["booking_id"];
        $c_hos_name = $cdrow["c_hos_name"];
        $c_patient_name = $cdrow["c_patient_name"];
        $c_patient_phone = $cdrow["c_patient_phone"];
        $last_updated_date = $cdrow["last_updated_date"];
        $c_date = $cdrow["c_date"];
        $c_time = $cdrow["c_time"];
        $intial_char = ucwords(mb_substr($c_patient_name, 0, 1));
        
        ?>  
        <li class="left clearfix"><span class="chat-img pull-left">
                <div class="avatar-circle">
                    <span class="initials">
                        <?php echo $intial_char; ?>
                    </span>
                </div>

            </span>
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">
                      Patient Name :  <?php echo $c_patient_name; ?> 
                    </strong> <small class="pull-right text-muted">
                        <span class="glyphicon glyphicon-time"></span>
                        <?php echo $last_updated_date; ?>
                    </small>
                </div>
                <div class="details_content" >
                    <span class="label_content">Booking Id: </span> <?php echo $booking_id; ?>
                   <br>
                 <span class="label_content"> Hospital Name: </span><?php echo $c_hos_name; ?>
                    <br>
                 <span class="label_content">  Timing : </span><?php echo $c_date; ?> @<?php echo $c_time; ?>
<!--                 <table class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr class="success">
                                        <th>Name</th>
                                        <th>Details</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Booking Id</td>
                                        <td class="details_content"> </td>
                                    </tr>
                                    <tr>
                                        <td>Hospital Name</td>
                                        <td class="details_content"> </td>
                                    </tr>
                                    <tr>
                                        <td>App Date</td>
                                        <td class="details_content"></td>
                                    </tr>
                                    <tr>
                                        <td>App Time</td>
                                        <td class="details_content"><?php echo $c_time; ?></td>
                                    </tr>
                                </tbody>
                 </table>-->
                </div>
            </div>
        </li>

        <?php
    };
    ?>  
</ul> 

