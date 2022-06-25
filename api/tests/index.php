<?php   
 require "../../config.php";
$query =mysqli_query($con,"SELECT Count(*) as count  from loading  where vessel_id = '1106'    "  ); ;
$rows = mysqli_fetch_assoc($query);
$count1= $rows["count"];

$query =mysqli_query($con,"SELECT Count(*) as count  from arrival  where vessel_id = '1106'    "); ;
$rows = mysqli_fetch_assoc($query);
$count2= $rows["count"];

$query =mysqli_query($con,"SELECT Count(*) as count  from move  where vessel_id = '1106'   "); ;
$rows = mysqli_fetch_assoc($query);
$count3= $rows["count"];

echo  $count1.' loading';
echo '<br>';
echo $count2.' arrival';
echo '<br>';
echo $count3.' move';
?>