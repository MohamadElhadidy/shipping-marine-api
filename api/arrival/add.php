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
$room_no = $_POST['room1'];
// $hla1 = $_POST['hala1'];
// $hla2 = $_POST['hala2'];
$seer = $_POST['con1'];
$kbsh = $_POST['kbash1'];
$crane = $_POST['cran1'];
$ename = $_POST['oname1']; 
$notes = $_POST['notes1']; 
$move_id = '';

$id = $param[0];
$arrival_date = date("Y-m-d H:i:s");

$result = mysqli_query($con,"SELECT *  FROM vessels_log   where id = '$id' AND done = 0 ");
$row = mysqli_fetch_assoc($result);
$vessel_id = $row['vessel_id']; 
$data['message'] = $vessel_id;
      
if(empty($notes))$notes="-";
    
//select move_id
$result1 = mysqli_query($con, "SELECT * FROM move WHERE sn = '$sn'  AND vessel_id = '$vessel_id'  AND  arrival = 0");
$row = mysqli_fetch_assoc($result1);
$move_id = $row['move_id']; 
$load_date = $row['load_date'];   

$resultSn= mysqli_query($con, "SELECT * FROM cars WHERE sn = '$sn'  AND vessel_id = '$vessel_id'  AND  done = 0");
$rowSn = mysqli_fetch_assoc($resultSn);
$hla1 = $rowSn['hla1']; 
$hla2 = $rowSn['hla2'];   



//assign vessel_start_date
$result2 = mysqli_query($con, "SELECT * FROM  arrival where vessel_id = '$vessel_id' " );
if(mysqli_num_rows($result2) == 0)  mysqli_query($con,"UPDATE vessels_log SET start_date = '$arrival_date' Where vessel_id = '$vessel_id'");

if($move_id != ''){
      //insert arrival 
    $result3 = mysqli_query($con, "INSERT INTO arrival(vessel_id, sn, type, room_no, hla1, hla2,seer, kbsh, crane, ename, notes, move_id, date)
      VALUES('$vessel_id', '$sn','$type','$room_no', '$hla1', '$hla2', '$seer','$kbsh', '$crane', '$ename','$notes', '$move_id','$arrival_date')");
      if($result3){
        //update move
        mysqli_query($con, "UPDATE move  
            SET arrival = 1,
            room_no = '$room_no',
            hla1 = '$hla1',
            hla2 = '$hla2',
            seer = '$seer',
            kbsh = '$kbsh',
            crane = '$crane',
            arrival_date = '$arrival_date'
            Where move_id = '$move_id' AND sn = '$sn'  AND vessel_id = '$vessel_id'");

            $pusher->trigger('travel', 'report', $data);
            $pusher->trigger('arrival', 'report', $data);
            $pusher->trigger('stats', 'report', $data);
            $pusher->trigger('analysis', 'report', $data);
            $pusher->trigger('live', 'add-vessel', $data);
            
            $date1 =strtotime($load_date); 
            $date2 =strtotime($arrival_date);
            $diff =  $date2  - $date1;
            $h = $diff / 3600 % 24;
            $m = $diff / 60 % 60; 
            if($h == 0) $hour = ''; else $hour=$h." "."ساعة";
            if($m == 0) $minute = ''; else $minute=$m." "."دقيقة";
            $time_now=$minute." ".$hour;

            $query =mysqli_query($con,"SELECT * from cars  where vessel_id = '$vessel_id' AND  sn  = '$sn' "); ;
            $row = mysqli_fetch_array($query);
            $car_no = $row['car_no'];
            $car_type = $row['car_type'];
            $car_owner = $row['car_owner'];
            if( $car_type == $car_owner ) $car_owner = '';

            $query =mysqli_query($con,"SELECT  count(*) as count from move where   vessel_id = '$vessel_id' AND arrival =1 "); ;
            $counts = mysqli_fetch_assoc($query);
            $moves = $counts['count'];

            $query =mysqli_query($con,"SELECT  count(*) as count from move where   vessel_id = '$vessel_id'  AND arrival =1 AND   sn  = '$sn'  "); ;
            $nums = mysqli_fetch_assoc($query);
            $num = $nums['count'];

            if( $seer == 'بدون سيور شحن' ) $seer = '';
            if( $hla1 == 'بدون حِلل'  or $hla1 == 'بدون حله ثانيه') $hla1 = '';
            if( $hla2 == 'بدون حِلل'  or $hla2 == 'بدون حله ثانيه') $hla2 = '';
            if( $kbsh == 'بدون كباشات أوناش' ) $kbsh = '';
            if( $crane == 'بدون أوناش' ) $crane = '';

            $message1=' >>  تم تعتيق '.$car_type.' رقم '.$car_no.' كود  '.$sn.'  '.$car_owner.' '.$room_no.' '.$seer.' '.$hla1.' '.$hla2.' '.$kbsh.' '.$crane; 
            $message1.= "\r\n";
            $message1.= "\r\n";
            $message1.= 'وقت التعتيق : '.$arrival_date;
            $message1.= "\r\n";
            $message1.= 'مدة الرحلة : '.$time_now;
            $message1.= "\r\n";
            $message1.=' عدد نقلات السيارة النقل الآن : ' .$num. ' نقله ';
            $message1.= "\r\n";
            $message1.= "\r\n";
            $message1.=' عدد النقلات التي تم شحنها الآن : ' .$moves. ' نقله ';
            $message1.= "\r\n";
            
            require "../../telegram.php";
            //send($vessel_id ,$message1, 'it', false);
            send($vessel_id ,$message1, 'shipping', false);
    }
}