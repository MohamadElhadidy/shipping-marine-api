<?php
// database connection
require "../../config.php";
require "../../vendor/autoload.php";

  $options = array(
    'cluster' => 'eu',
    'u
    seTLS' => true
  );
  $pusher = new Pusher\Pusher(
    'a6bf85244260ce098471',
    'd44f73a3efc8d7c607e5',
    '1311917',
    $options
  );

$data['message'] = 'hello world';

$sn2 = $_POST['snc'];
$param = explode('|', urldecode($_POST['v']));
$carn = $_POST['carn'];
$str1 = $_POST['carl'];

$id = $param[0];
$str2 = preg_replace('/\s\s+/u', ' ', $str1);
$str3=  preg_replace('//u', ' ', $str2);
$str4 = preg_replace('/\s+/', ' ', $str3);
$car_l =trim($str4);
$car_no =$carn.' '.$car_l ;
$date = date("Y-m-d H:i:s"); 

$result1 = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result1);
$vessel_id = $row['vessel_id'];  
    
$result2 = mysqli_query($con,"SELECT * FROM cars WHERE car_no = '$car_no'  AND vessel_id = '$vessel_id'  AND done = 0");
$row = mysqli_fetch_assoc($result2);
$sn1 = $row['sn'];

if(isset($sn1) && isset($sn2)) {
    mysqli_query($con, "UPDATE cars SET sn = '$sn2' where sn = '$sn1'  AND vessel_id = '$vessel_id' AND done = 0 ");
    mysqli_query($con, "UPDATE loading SET sn = '$sn2' where sn = '$sn1'  AND vessel_id = '$vessel_id'");
    mysqli_query($con, "UPDATE arrival SET  sn = '$sn2' where sn = '$sn1'  AND vessel_id = '$vessel_id'");
    mysqli_query($con, "UPDATE minus SET sn = '$sn2' where sn = '$sn1'  AND vessel_id = '$vessel_id'");
    mysqli_query($con, "UPDATE move SET sn = '$sn2' where sn = '$sn1'  AND vessel_id = '$vessel_id'");
    $pusher->trigger('car', 'report', $data);
    $pusher->trigger('minus', 'report', $data);
    $pusher->trigger('travel', 'report', $data);
    $pusher->trigger('quantity', 'report', $data);
    $pusher->trigger('loading', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('analysis', 'report', $data);
    $pusher->trigger('arrival', 'report', $data);
    return http_response_code(200);
}
return http_response_code(422);
?>