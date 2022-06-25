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
$room_no = $_POST['room_no'];
$seer = $_POST['seer'];
$hla1 = $_POST['hla1'];
$hla2 = $_POST['hla2'];
$crane = $_POST['crane'];
$kbsh = $_POST['kbsh'];
$type = $_POST['type'];
$move_id = $_POST['move_id'];
$vessel_id = $_POST['vessel_id'];

$query ="UPDATE   arrival
        SET room_no = '$room_no',
                seer = '$seer',
                hla1 = '$hla1',
                hla2 = '$hla2',
                crane = '$crane',
                kbsh = '$kbsh',
                type = '$type'
                where  id = '$id'
                    ";

if(mysqli_query($con, $query)){
$query2 ="UPDATE   move
        SET room_no = '$room_no',
                seer = '$seer',
                hla1 = '$hla1',
                hla2 = '$hla2',
                crane = '$crane',
                kbsh = '$kbsh'
                where  move_id = '$move_id' AND vessel_id = '$vessel_id'
                    ";
}
if(mysqli_query($con, $query2)){
    $pusher->trigger('arrival', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>