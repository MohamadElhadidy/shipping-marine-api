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

$sn = $_POST['sn1'];
$param = explode('|', urldecode($_POST['v']));
$type = $_POST['type1'];
$store_no = $_POST['store_no1'];
$qnt = $_POST['qnt1'];
$jumbo = $_POST['jumbo1'];
$ename = $_POST['oname1']; 
$notes = $_POST['notes1']; 

$id = $param[0];
$load_date = date("Y-m-d H:i:s");
$move_id=1;

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result);
$vessel_id = $row['vessel_id']; 
$data['message'] = $vessel_id;
if(empty($notes))$notes="-";

//select move_id
$sql = "select * from loading where vessel_id = '$vessel_id'   ORDER BY move_id  DESC LIMIT 1";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)  > 0 ){
        $row = mysqli_fetch_assoc($result);
        $move_id +=$row['move_id']; 
}else {
    $move_id = $vessel_id.'0000';
}

if($move_id !=1){

      //insert loading
      $query ="INSERT INTO loading (vessel_id,sn,type, store_no,qnt,jumbo, ename,notes,move_id, date) VALUES 
      ('$vessel_id' ,'$sn','$type', '$store_no','$qnt','$jumbo', '$ename','$notes','$move_id', '$load_date')";
      mysqli_query($con, $query);

    //insert move
    $query2 ="INSERT INTO move (vessel_id,sn,move_id,qnt,loading, jumbo,store_no,type,load_date)
      VALUES ('$vessel_id','$sn','$move_id','$qnt','1','$jumbo','$store_no','$type','$load_date') ";
    mysqli_query($con, $query2);
    $pusher->trigger('travel', 'report', $data);
    $pusher->trigger('quantity', 'report', $data);
    $pusher->trigger('loading', 'report', $data);
    $pusher->trigger('stats', 'report', $data);
    $pusher->trigger('analysis', 'report', $data);
    $pusher->trigger('live', 'add-vessel', $data);


    $query =mysqli_query($con,"SELECT  count(*) as count from move where   vessel_id = '$vessel_id' "); ;
    $counts = mysqli_fetch_assoc($query);
    $moves = $counts['count'];
    
    $query =mysqli_query($con,"SELECT * from cars  where vessel_id = '$vessel_id' AND  sn  = '$sn' "); ;
    $row2 = mysqli_fetch_array($query);
    $car_no = $row2['car_no'];
    $car_type = $row2['car_type'];
    $car_owner = $row2['car_owner'];
    if( $car_type == $car_owner ) $car_owner = '';

    $message1= '<<  تم تحميل '.$car_type.' رقم '.$car_no.' كود '.$sn.' '.$car_owner.' من مخزن ' .$store_no;
    $message1.= "\r\n";
    $message1.= "\r\n";
    $message1.= 'وقت التحميل  : '.$load_date;
    $message1.= "\r\n";
    $message1.=' عدد النقلات التي تم تحميلها من المخزن الآن : ' .$moves. ' نقله ';
	  $message1.= "\r\n";
    
  require "../../telegram.php";
    //send($vessel_id ,$message1, 'it', false);
    send($vessel_id ,$message1, 'shipping', false);

    echo json_encode(array('car_no' => $row["car_no"]));
    
}
else return http_response_code(422);