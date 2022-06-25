<?php

// database connection
require "../../config.php";
$vessel_id =  $_POST["vessel_id"];
$result1 = mysqli_query($con,"SELECT *  FROM vessels_log   where vessel_id = '$vessel_id' AND done = 0 ");
$row = mysqli_fetch_assoc($result1);
$done =  $row['done'];

$result1 = mysqli_query($con,"SELECT count(*) as total_cars  FROM cars   where vessel_id = '$vessel_id'");
$total_cars = mysqli_fetch_assoc($result1);

$result1 = mysqli_query($con,"SELECT count(*) as active_cars  FROM cars   where vessel_id = '$vessel_id' AND done = 0 ");
$active_cars = mysqli_fetch_assoc($result1);

$result1 = mysqli_query($con,"SELECT count(*) as toktok_cars  FROM cars   where vessel_id = '$vessel_id' AND car_type = 'سيارة توكتوك'  AND done = '$done'");
$toktok_cars = mysqli_fetch_assoc($result1);

$result1 = mysqli_query($con,"SELECT count(*) as qlab_cars  FROM cars   where vessel_id = '$vessel_id' AND car_type = 'سيارة قلاب' AND done = '$done' ");
$qlab_cars = mysqli_fetch_assoc($result1);

$result1 = mysqli_query($con,"SELECT count(*) as company_cars  FROM cars   where vessel_id = '$vessel_id' AND car_type = 'سيارة الشركة' AND done = '$done' ");
$company_cars = mysqli_fetch_assoc($result1);

$result1 = mysqli_query($con,"SELECT count(*) as grar_cars FROM cars   where vessel_id = '$vessel_id' AND car_type = 'سيارة جرار'  AND done = '$done' ");
$grar_cars = mysqli_fetch_assoc($result1);


$result1 = mysqli_query($con,"SELECT count(*) as moves FROM move   where vessel_id = '$vessel_id' AND arrival = 1   ");
$moves = mysqli_fetch_assoc($result1);

$query =mysqli_query($con,"SELECT SUM(qnt) as qnt  from loading  where vessel_id = '$vessel_id'  AND  qnt  IS NOT NULL "); ;
$rows = mysqli_fetch_assoc($query);
$qnt= $rows["qnt"];

echo json_encode(array(
    'active_cars' => $active_cars['active_cars'],
    'toktok_cars' => $toktok_cars['toktok_cars'],
    'qlab_cars' => $qlab_cars['qlab_cars'],
    'company_cars' => $company_cars['company_cars'],
    'grar_cars' => $grar_cars['grar_cars'],
    'moves' => $moves['moves'],
    'qnt' =>  number_format((float)$qnt, 3, '.', ''),
    'vessel' => $row
));

?>