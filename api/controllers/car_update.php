<?php
// database connection
require "../../config.php";
require "../../vendor/autoload.php";

  $options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    'a6bf85244260ce098471',
    'd44f73a3efc8d7c607e5',
    '1311917',
    $options
  );



$id = $_POST['id'];
$str1 = $_POST['carl'];
$carn = $_POST['carn'];
$car_type = $_POST['car_type'];
$car_owner = $_POST['car_owner'];
$mehwer = $_POST['mehwer'];
$vacant = $_POST['vacant'];

$str2 = preg_replace('/\s\s+/u', ' ', $str1);
$str3=  preg_replace('//u', ' ', $str2);
$str4 = preg_replace('/\s+/', ' ', $str3);
$car_l =trim($str4);
$car_no =$carn.' '.$car_l ;

$x= .05 * $mehwer;
$total = $x + $mehwer;    
$limits =   $total - $vacant;     

$query ="UPDATE   cars
        SET car_no = '$car_no',
                car_type = '$car_type',
                car_owner = '$car_owner',
                mehwer = '$mehwer',
                vacant = '$vacant',
                limits = '$limits'
                where  id = '$id'
                    ";

if(mysqli_query($con, $query)){
    $data['message'] = 'hello world';
  $pusher->trigger('car', 'report', $data);
    echo json_encode(array('success' => 1));
}
else return http_response_code(422);  
?>