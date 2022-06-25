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
  


$id = $_POST['id'];
$sn = $_POST['sn'];
$quantity = $_POST['quantity'];
$jumbo = $_POST['jumbo'];
$move_id = $_POST['move_id'];
$vessel_id = $_POST['vessel_id'];
$qnt_date = date("Y-m-d H:i:s");
$data['message'] = $vessel_id;

$query ="UPDATE   loading
        SET qnt = '$quantity',
                jumbo = '$jumbo',
                qnt_date = '$qnt_date'
                where  id = '$id'
                    ";
mysqli_query($con, $query);
$query2 ="UPDATE   move
        SET qnt = '$quantity',
                jumbo = '$jumbo'
                where  move_id = '$move_id' AND vessel_id = '$vessel_id'";
      $result = mysqli_query($con, $query2);
    if($result){

    $pusher->trigger('loading', 'report', $data);
    $pusher->trigger('quantity', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('analysis', 'report', $data);
    $pusher->trigger('live', 'add-vessel', $data);
   
    
    $query =mysqli_query($con,"SELECT * from cars  where vessel_id = '$vessel_id' AND  sn  = '$sn' "); ;
    $row = mysqli_fetch_array($query);
    $car_no = $row['car_no'];
    $car_type = $row['car_type'];
    $car_owner = $row['car_owner'];
    if( $car_type == $car_owner ) $car_owner = '';

    $query =mysqli_query($con,"SELECT SUM(qnt) as qnt , SUM(jumbo) as jumbo  from loading  where vessel_id = '$vessel_id'  AND  qnt  IS NOT NULL "); ;
    $rows = mysqli_fetch_assoc($query);
    $qnt= $rows["qnt"];
    $jumbos= $rows["jumbo"];

    $query =mysqli_query($con,"SELECT COUNT(*) as count from loading  where vessel_id = '$vessel_id'  AND  qnt_date   is not null "); ;
    $rows2 = mysqli_fetch_assoc($query);
    $moves= $rows2["count"];


  $message1= 'تم إضافة وزن : '.$quantity.' طن ';
  if($jumbo != 0){
      $message1.=$jumbo. ' جامبو '; 
    }
	$message1.= "\r\n";
	$message1.= 'لـ'.$car_type
	. '  رقم '.$car_no
	.' كود '.$sn.'   '.$car_owner;
	$message1.= "\r\n";
  $message1.= "\r\n";
    $message1.='*إجمالي الكميه الآن*: '. number_format((float)$qnt, 3, '.', ''). ' طن ، لعدد ' 
    .$moves. ' نقلة '; 
    if($jumbo != 0){
      $message1.='  لعدد '.$jumbos. ' جامبو '; 
    }
    $message1.= "\r\n";
	

	$message2= 'تم إضافة وزن : '.$quantity.' طن ';
      if($jumbo != 0){
      $message2.=$jumbo. ' جامبو '; 
    }
	$message2.= "\r\n";
	$message2.= 'لـ'.$car_type
	. '  رقم '.$car_no
	.' كود '.$sn.'   '.$car_owner;
	$message2.= "\r\n";
  $message2.= "\r\n";
    $message2.='*إجمالي الكميه الآن*: '. number_format((float)$qnt, 3, '.', ''). ' طن ، لعدد ' 
    .$moves. ' نقلة '; 
    if($jumbo != 0){
      $message2.='  لعدد '.$jumbos. ' جامبو '; 
    }
    $message2.= "\r\n";

  $message3 = '';

  $message4= 'تم إضافة وزن: '.$quantity.' طن ';
	$message4.= "\r\n";
	$message4.= "\r\n";
    $message4.='*إجمالي الكميه الآن*: '. number_format((float)$qnt, 3, '.', ''). ' طن ، لعدد ' 
	.$moves. ' نقلة ';
  $message4.= "\r\n";

  require "../../telegram.php";
  send($vessel_id ,$message1, 'shipping', false);
	send($vessel_id ,$message2, 'ceo', false);
	send($vessel_id ,$message3, 'ceo', true);
  //send($vessel_id ,$message4, 'client', false);
  echo json_encode(array('success' => 1));
    
}else return http_response_code(422); 
?>