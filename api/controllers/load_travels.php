<?php

// database connection
require "../../config.php";


$vessel_id = $_POST["vessel_id"];

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$rowLength = '';
if($rowperpage  == -1)$rowLength = '';
else $rowLength = "limit ".$row.",".$rowperpage;
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " AND (sn like '%".$searchValue."%' or 
        car_no like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

$sel = "SELECT count(*) as allcount FROM cars where  vessel_id = '$vessel_id' AND done =0  ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];





## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM cars where  vessel_id = '$vessel_id' AND done =0  AND  1  ".$searchQuery." ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records


//$empQuery = "SELECT * FROM minus where  vessel_id = '$vessel_id' ;    
$empQuery = "SELECT * FROM cars WHERE   vessel_id = $vessel_id  AND done =0 AND 1  $searchQuery order by  $columnName $columnSortOrder  $rowLength ";
$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

    
$sn = $row['sn'];
$result = mysqli_query($con,"SELECT *  FROM move   where sn = '$sn' AND vessel_id = $vessel_id order by  load_date desc  limit 1 ");
$row2 = mysqli_fetch_assoc($result); 
        
if ($row2['arrival'] == 1) {
        $to = strtotime($row2['arrival_date']);
        $from =  strtotime(date("Y-m-d H:i:s"));
        $diff =  $from - $to;
        $day = $diff / 86400 % 7 . " " . "يوم";
        $hour = $diff / 3600 % 24 . " " . "ساعة";
        $minute = $diff / 60 % 60 . " " . "دقيقة";
        if($diff / 86400 % 7 == 0 )    $day ='';
        if($diff / 3600 % 24 == 0 )    $hour ='';
        if($diff / 60 % 60 == 0 )    $minute ='';
        $duration = $minute . " " . $hour . " " . $day;
        $direction = 'الى المخزن';
        $date = $row2['arrival_date'];
}elseif(mysqli_num_rows($result ) == 0){
        $direction = 'لم يتم   تحميل او تعتيق السيارة بعد';
        $date = '';
}elseif($row2['arrival'] == 0){
        $to = strtotime($row2['load_date']);
        $from =  strtotime(date("Y-m-d H:i:s"));
        $diff =  $from - $to;
        $day = $diff / 86400 % 7 . " " . "يوم";
        $hour = $diff / 3600 % 24 . " " . "ساعة";
        $minute = $diff / 60 % 60 . " " . "دقيقة";
        if($diff / 86400 % 7 == 0 )    $day ='';
        if($diff / 3600 % 24 == 0 )    $hour ='';
        if($diff / 60 % 60 == 0 )    $minute ='';
        $duration = $minute . " " . $hour . " " . $day;
        $direction = 'الى الرصيف';
        $date = $row2['load_date'];
}


   $data[] = array( 
      "sn"=> $row['sn'],
      "car_no"=>$row['car_no'],
      "duration"=>$duration,
      "direction"=>$direction,
      "date"=>$date,
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);

?>