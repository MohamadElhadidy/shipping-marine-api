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


$id = $_POST['id'];
$move_id = $_POST['move_id'];
$vessel_id = $_POST['vessel_id'];
$store_no = $_POST['store_no'];
$type = $_POST['type'];
$ename = $_POST['ename'];
$notes = $_POST['notes'];

$query ="UPDATE   loading
        SET store_no = '$store_no',
                type = '$type',
                ename = '$ename',
                notes = '$notes'
                where  id = '$id'";

if(mysqli_query($con, $query)){
$query2 ="UPDATE   move
        SET store_no = '$store_no',
                type = '$type'
                where  move_id = '$move_id' AND vessel_id = '$vessel_id'";
}
if(mysqli_query($con, $query2)){
    $pusher->trigger('loading', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>