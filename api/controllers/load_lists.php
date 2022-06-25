<?php

// database connection
require "../../config.php";

if(isset($_POST["table"])){
    $table = $_POST["table"];
  $result = mysqli_query($con,"SELECT * FROM $table ");
  foreach($result as $row){
   $output[] = array(
    'id'  => $row["vessel_id"],
    'name'  => $row["name"]
   );
  }
  echo json_encode($output);
 
}

?>