<?php

// database connection
require "../../config.php";

$sn = $_POST['snc'];
$param = explode('|', urldecode($_POST['v']));
$str1 = $_POST['carl'];
$carn = $_POST['carn'];

$id = $param[0];
$str2 = preg_replace('/\s\s+/u', ' ', $str1);
$str3=  preg_replace('//u', ' ', $str2);
$str4 = preg_replace('/\s+/', ' ', $str3);
$car_l =trim($str4);
$car_no =$carn.' '.$car_l ;

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result); 
$vessel_id =  $row['vessel_id'];

$result2 = mysqli_query($con, "SELECT * FROM cars where sn = '$sn' AND vessel_id = '$vessel_id' ");
$result3 = mysqli_query($con, "SELECT * FROM cars where car_no = '$car_no' AND vessel_id = '$vessel_id' AND  done = 0");

if (mysqli_num_rows($result2) > 0)  echo "sn";
elseif ( $sn == null ||  $str1 == '' || $carn ==  ''  )  echo "empty";
elseif ( mysqli_num_rows($result3) == 0)  echo "car_no";
else echo "true";
?>