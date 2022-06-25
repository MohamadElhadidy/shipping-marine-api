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



$sn = $_POST['snc'];
$param = explode('|', urldecode($_POST['v']));
$carn = $_POST['carn'];
$str1 = $_POST['carl'];
$car_type = $_POST['ctc'];
$car_owner =trim($_POST['cnc']);
$mehwer = $_POST['mehw'];
$vacant = $_POST['empt'];
$time = $_POST['hr'].':'.$_POST['mt'];
$date = $_POST['yer'].'-'.$_POST['mon'].'-'.$_POST['dy'];

$hla1 = $_POST['hala1'];
$hla2 = $_POST['hala2'];
$mh1 = $_POST['hm1'];
$mh2 = $_POST['hm2'];

$id = $param[0];
$str2 = preg_replace('/\s\s+/u', ' ', $str1);
$str3=  preg_replace('//u', ' ', $str2);
$str4 = preg_replace('/\s+/', ' ', $str3);
$car_l =trim($str4);
$car_no =$carn.' '.$car_l ;
$start_date = $date.' '.$time;

$x= .05 * $mehwer;
$total = $x + $mehwer;    
$limits =   $total - $vacant;        


$result1 = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result1);
$vessel_id = $row['vessel_id']; 
$data['message'] = $vessel_id;

$query ="INSERT INTO cars (vessel_id, sn, car_no, car_owner, car_type, limits, start_date, mehwer, vacant, hla1, hla2, mh1, mh2 )
VALUES ('$vessel_id' , '$sn',  '$car_no', '$car_owner', '$car_type', '$limits', '$start_date', '$mehwer', '$vacant' , '$hla1', '$hla2', '$mh1', '$mh2')";

if(mysqli_query($con, $query)) {  
    $pusher->trigger('car', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('live', 'add-vessel', $data);
	if($car_type == $car_owner) $car_owner = '';
    
    $query = mysqli_query($con, "SELECT COUNT(id) as count FROM cars where  vessel_id = '$vessel_id' AND done = 0");
    $total_cars = mysqli_fetch_assoc($query );

	$message1='  تم إضافة  '.$car_type
    .' رقم '.$car_no
	.' كود '.$sn.' '.$car_owner;
    $message1.= "\r\n";

    if ($hla1 == 'حله إيجار') {
        $message1.= $hla1.'  '.$mh1.'  ';
    }elseif ($hla1 != 'بدون حِلل') {
        $message1.= $hla1.'  ';
    }

    if ($hla2 == 'حله إيجار') {
        $message1.= $hla2.'  '.$mh2.'  ';
    }elseif ($hla2 != 'بدون حله ثانيه') {
        $message1.= $hla2.'  ';
    }


	$message1.= ' إلى منظومة الشحن ';
	$message1.= "\r\n";
	$message1.= 'وقت الدخول : '.$start_date;
    $message1.= "\r\n";
	$message1.= 'إجمالى السيارات الحالية : *'.$total_cars['count'].'*';




    $message2='  تم إضافة  '.$car_type
    .' رقم '.$car_no
	.' كود '.$sn.' '.$car_owner;
    $message2.= "\r\n";

    if ($hla1 == 'حله إيجار') {
        $message2.= $hla1.'  '.$mh1.'  ';
    }elseif ($hla1 != 'بدون حِلل') {
        $message2.= $hla1.'  ';
    }

    if ($hla2 == 'حله إيجار') {
        $message2.= $hla2.'  '.$mh2.'  ';
    }elseif ($hla2 != 'بدون حله ثانيه') {
        $message2.= $hla2.'  ';
    }

    
	$message2.= ' إلى منظومة الشحن ';
	$message2.= "\r\n";
	$message2.= 'وقت الدخول : '.$start_date;
    $message2.= "\r\n";
	$message2.= 'إجمالى السيارات الحالية : *'.$total_cars['count'].'*';

	$message3 = '';

    require "../../telegram.php";
	//send($vessel_id ,$message1, 'it', false);
	send($vessel_id ,$message1, 'shipping', false);
	send($vessel_id ,$message2, 'ceo', false);
	send($vessel_id ,$message3, 'ceo', true);
    return http_response_code(200);
}
return http_response_code(422);
?>