<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_POST["email"]<>'') { 
$ToEmail = $_POST["email"]; 
$EmailSubject = $_POST["subject"]; 
$MESSAGE_BODY = $_POST["message"]; 
$mailheader = "From: admin@kshms.app\r\n"; 
$mailheader .= "Reply-To: no-reply@kshms.app\r\n"; 
$mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
 $places_json = array('ToEmail' => $ToEmail, 'EmailSubject' => $EmailSubject, "mailheader" => $mailheader, "MESSAGE_BODY" => $MESSAGE_BODY);
print (json_encode($places_json));
 mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader) or die ("Failure"); 

}
?>