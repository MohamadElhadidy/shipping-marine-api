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


$vessel_id = $_POST['vessel_id'];
$sn = $_POST['sn'];
$date = $_POST['date'];
$time = $_POST['time'];
$cause = $_POST['cause'];
$employee = $_POST['employee'];
$data['message'] = $vessel_id;
$exit_date =  date("Y-m-d H:i:s", strtotime($date.' '.$time));

$result1 = mysqli_query($con, "select count(*) as count from loading where sn ='$sn' AND vessel_id = '$vessel_id'");
$row1 = mysqli_fetch_assoc($result1);
$count1 = $row1['count'];
    
$result2 = mysqli_query($con, "select count(*) as count from arrival where sn ='$sn' AND vessel_id = '$vessel_id'");
$row2 = mysqli_fetch_assoc($result2);
$count2 = $row2['count'];
    
        
if ($count1 == $count2) { 
$query =mysqli_query($con, "INSERT INTO cars_exit  (vessel_id, sn, cause, ename, date)
        VALUES('$vessel_id','$sn' , '$cause', '$employee','$exit_date')") ;

if($query) $query2 = mysqli_query($con, "UPDATE cars SET done = 1, exit_date = '$exit_date' where sn = '$sn'  AND  vessel_id = '$vessel_id'  AND done = 0 ");

if($query2){
    $pusher->trigger('car', 'report', $data);
    $pusher->trigger('stats', 'report', $data);

    $result =  mysqli_query($con,"SELECT *  FROM cars  where vessel_id = '$vessel_id' AND sn ='$sn'  ");
    $row = mysqli_fetch_assoc($result);
    if($row["car_type"] ==$row["car_owner"]) $row["car_owner"] = '';

    $query = mysqli_query($con, "SELECT SUM(qnt) as sum FROM move where sn = '$sn' AND vessel_id = '$vessel_id' ");
    $quantity= mysqli_fetch_assoc($query );
    $qnt = $quantity['sum'];

    $query = mysqli_query($con, "SELECT COUNT(id) as count FROM move where sn = '$sn' AND vessel_id = '$vessel_id'  AND arrival = '1'");
    $counts= mysqli_fetch_assoc($query );
    $moves = $counts['count'];
    


    $query = mysqli_query($con, "SELECT COUNT(id) as count FROM cars where  vessel_id = '$vessel_id' AND done = 0");
    $total_cars = mysqli_fetch_assoc($query );
  

      if($moves != 0  ){
        $avg =$qnt /$moves ;
        $qnt=number_format($qnt, 3);
        $avg=number_format($avg, 3);
      }else{
        $avg=0;
      }

      $message1=' تم خروج  '.$row["car_type"]
        .' رقم '.$row["car_no"]
	      .' كود '.$sn.' '.$row["car_owner"]
	      .'  من منظومة الشحن '.' بإجمالي  '.  $qnt . ' طن '
	      . 'لعدد '  . $moves .'  نقله  ' 
	      . ' بمتوسط ' . $avg .' طن/نقله  .   ';
	    $message1.= "\r\n";	
	    $message1.= 'وقت الخروج : ' .$exit_date;
	    $message1.= "\r\n";
	    $message1.= 'وقت الدخول : '.$row["start_date"];
      $message1.= "\r\n";
	    $message1.= 'إجمالى السيارات الحالية : *'.$total_cars['count'].'*';

      $message2=' تم خروج  '.$row["car_type"]
        .' رقم '.$row["car_no"]
	      .' كود '.$sn.' '.$row["car_owner"]
	      .'  من منظومة الشحن '.' بإجمالي  '.  $qnt . ' طن '
	      . 'لعدد '  . $moves .'  نقله  ' 
	      . ' بمتوسط ' . $avg .' طن/نقله  .   ';
	    $message2.= "\r\n";	
	    $message2.= 'وقت الخروج : ' .$exit_date;
	    $message2.= "\r\n";
	    $message2.= 'وقت الدخول : '.$row['start_date'];
      $message2.= "\r\n";
	    $message2.= 'إجمالى السيارات الحالية : *'.$total_cars['count'].'*';

	    $message3 = '';


      require "../../telegram.php";
      send($vessel_id ,$message1, 'shipping', false);
	    send($vessel_id ,$message2, 'ceo', false);
	    send($vessel_id ,$message3, 'ceo', true);
      echo json_encode(array('car_no' => $row["car_no"]));
}
else return http_response_code(422);
}
else echo json_encode(array('car_no' => false));
?>