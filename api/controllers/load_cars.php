<?php

// database connection
require "../../config.php";

if(isset($_POST["type"])){
 if($_POST["type"] == "vessels") {
  $result = mysqli_query($con,"SELECT * FROM vessels_log where done = 0 ORDER BY start_date desc");
  foreach($result as $row){
   $output[] = array(
    'id'  => $row["vessel_id"],
    'name'  => $row["name"],
    'type'  => $row["type"]
   );
  }
  echo json_encode($output);
 }
 else
 {
$vessel_id  = $_POST["vessel_id"];
$result = mysqli_query($con,"SELECT * FROM cars where done = 0 AND vessel_id ='$vessel_id'  ORDER BY start_date asc");
  foreach($result as $row){
   $output[] = array(
    'id'  => $row["sn"],
    'name'  => $row["car_no"]
   );
  }
  echo json_encode($output);
 }
}

?>