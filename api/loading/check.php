<?php
// database connection
require "../../config.php";

$sn = $_POST['snc'];
$param = explode('|', urldecode($_POST['v']));
$id = $param[0];

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result); 
$vessel_id =  $row['vessel_id'];

$result1 = mysqli_query($con, "SELECT * FROM cars where sn ='$sn' AND vessel_id = '$vessel_id' AND  done = 0 ");
$row = mysqli_fetch_assoc($result1);

$result2 = mysqli_query($con, "SELECT *  FROM move where  arrival = '0' AND sn ='$sn' AND vessel_id = '$vessel_id'");

if ( $sn == null )  echo "empty";
elseif (mysqli_num_rows($result1) == 0)  echo "sn";
elseif ( mysqli_num_rows($result2) > 0)  echo "move";
else echo $row["car_no"];
?>