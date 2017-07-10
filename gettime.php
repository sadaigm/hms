<?php 

//$str = "6-6.30,17-19.30,21.30-22.30";
function getConsulting_Hrs($str)
{


 $myArray = explode(',', $str);
 $i=0;
 $minTime;
 $row =  array();
 //$aa=array(array());
 foreach ( $myArray as $el)
 {
 	//print_r($el);
 	$num = explode('-', $el);
 	$j=0;
 	
 	$startHr=0;
    $startMin=0;
    $startTimeZone="am";
    $endTimeZone="am";
    $endHr=0;
    $endMin=0;
 	foreach ( $num as $t){
 
 	if (strpos($t, '.') !== false) {
 		//print_r(json_encode($j."--".sizeof($num)."---".$t."--".$t));
    $time = explode('.', $t);
    $hr =$time[0];
    $min =$time[1];
    $time_mode = 'am';
    if($hr>12)
	{
		$hr=($hr % 12);
		$time_mode = 'pm';
	}
    if($j<"1")
    {
    	$startHr=$hr;
    	$startMin=$min;
    	$startTimeZone=$time_mode ;
    }
    else
    {
    	
    	$endHr=$hr;
    	$endMin=$min;
    	$endTimeZone=$time_mode ;
    }
   // $hr=$hr+1;

}
else
{ $hr =$t;
	$min ="00";
	$time_mode = 'am';
	if($hr>12)
	{
		$hr=($hr % 12);
		$time_mode = 'pm';
	}
	
	 if($j<"1")
    {
    	$startHr=$hr;
    	$startMin=$min;
    	$startTimeZone=$time_mode ;
    }
     else
    {
    	$endHr=$hr;
    	$endMin=$min;
    	$endTimeZone=$time_mode ;

    }
	
}	
/*$row =array('startHr' => $startHr,
     'startMin' => $startMin,
     'startTimeZone' => $startTimeZone,
     'endHr' => $endHr,
     'endMin' => $endMin,
     'endTimeZone' => $endTimeZone
     );*/
$previousTime=0;
while($startHr <=$endHr)
{
	if($startHr == $endHr)
	{
		if($previousTime=="0")
		{
		//printf($startHr.".".$startMin.$startTimeZone."\n");
		$val=$startHr.".".$startMin.$startTimeZone;	
		$row[]=$val;	
		/*echo "<option value='$val'>
              $val
          </option>";*/
          if($startMin=="00")
          {
          	$mi="30";
          	$val=$startHr.":".$mi.$startTimeZone;		
          	$row[]=$val;
		/*echo "<option value='$val'>
              $val
          </option>";*/
          }
		}
		else { if($endMin!="00")
          {
          	$mi="00";
          	$val=$endHr.":".$mi.$endTimeZone;
          	$row[]=$val;		
		/*echo "<option value='$val'>
              $val
          </option>";*/
          }
          //printf($endHr.".".$endMin.$endTimeZone."\n");
		$val=$endHr.":".$endMin.$endTimeZone;	
		$row[]=$val;	
		/*echo "<option value='$val'>
              $val
          </option>";*/

      }
		
	break;		
	}
//printf($startHr.".".$startMin.$startTimeZone."\n");
	if($previousTime=="0")
		{
		//printf($startHr.".".$startMin.$startTimeZone."\n");
		$val=$startHr.":".$startMin.$startTimeZone;	
		$row[]=$val;	
		/*echo "<option value='$val'>
              $val
          </option>";*/
          if($startMin=="00")
          {
          	$mi="30";
          	$val=$startHr.":".$mi.$startTimeZone;	
          	$row[]=$val;	
		/*echo "<option value='$val'>
              $val
          </option>";*/
          }
		}
		else
		{
			 $mi="00";
			$val=$startHr.":".$mi.$startTimeZone;	
			$row[]=$val;	
/*echo "<option value='$val'>
              $val
          </option>";*/
          $mi="30";
          $val=$startHr.":".$mi.$startTimeZone;	
          $row[]=$val;	
/*echo "<option value='$val'>
              $val
          </option>";*/

		}
$previousTime=$startHr;
$startHr=$startHr+1;
}
$j++;

 	}
$aa['aa'][]=$row;
 	//print_r($num[0 ]);
 	/*if($i<"1")
 	{
 		$minTime=$num[0];
 		//print_r($minTime);
 	}
 	else if($i=(sizeof($myArray)-1))
 	{

 		$maxTime=$num[1];
 	}*/
 	$i++;

 }
$concatstr="";
foreach ($row as $strvalue)
{
	$concatstr.=$strvalue.",";
}
//echo "$concatstr";
return $concatstr;
}

//print_r(json_encode($row));
  //print_r(json_encode($aa));
 //$arrReturn = array('minTime' => $minTime, 'maxTime' => $maxTime);
 //print (json_encode($arrReturn));
//print_r(json_encode($myArray)); 



//print_r(json_encode($row));

?>