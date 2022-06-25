<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);
$vessel_id = 1105;

	$message2= 'وقت الدخول : ';
    $message2.= "\r\n";
	$message2.= 'إجمالى السيارات الحالية : *'.'*';
	$message3 = '';

    require "wapi.php";
	send($vessel_id ,$message2, 'it', false);
	send($vessel_id ,$message3, 'it', true);
?>