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
$hours = $_POST['hours'];
$minutes = $_POST['minutes'];
$cause = $_POST['cause'];
$ename = $_POST['ename'];
$hours = sprintf("%02d", $hours);
$minutes = sprintf("%02d", $minutes);
$stop_duration =  $hours.$minutes."00";


$query ="UPDATE   stop
        SET cause = '$cause',
                ename = '$ename',
                stop_duration = '$stop_duration'
                where  id = '$id'
                    ";

if(mysqli_query($con, $query)){

    $pusher->trigger('stop', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>