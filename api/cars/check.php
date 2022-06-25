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

$result2 = mysqli_query($con, "SELECT * FROM cars where sn = '$sn' AND done = 0 ");
$result3 = mysqli_query($con, "SELECT * FROM cars where car_no = '$car_no' AND   done = 0");
$result4 = mysqli_query($con, "SELECT * FROM canceled_sn where sn = '$sn' ");
$result5 = mysqli_query($con, "SELECT * FROM cars where sn = '$sn' AND vessel_id = '$vessel_id' ");

if ( mysqli_num_rows($result4) > 0)  echo "cancel";
elseif (mysqli_num_rows($result2) > 0)  echo "sn";
elseif (mysqli_num_rows($result5) > 0)  echo "sn";
elseif ( $sn != null AND substr($sn, 0, 2) != 'MA')  echo "cancel";
elseif ( mysqli_num_rows($result3) > 0)  echo "car_no";
elseif ( $sn == null ||  $str1 == '' || $carn == ''  )  echo "empty";
else echo "true";
?>