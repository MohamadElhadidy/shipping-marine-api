<?php

// database connection
require "../../config.php";

$ver = $_POST['ver'];  
$password = $_POST['pass'];

$password=md5($password);
$date = date("Y-m-d H:i:s");

// check username && password
$result1 = mysqli_query($con,"SELECT *  FROM login   where username = 'arrival' AND  ver ='$ver'  ");
$result2 = mysqli_query($con,"SELECT *  FROM login   where username = 'arrival' AND password ='$password'  ");

if(mysqli_num_rows($result1) == 0) { echo "ver"; }
elseif ( $_POST['pass'] == null )  echo "empty";
elseif(mysqli_num_rows($result2) > 0) { $row = mysqli_fetch_assoc($result2); echo $row["username"]; }
else{ echo "false"; }

?>