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
$searchQuery = 1;
if($searchValue != ''){
   $searchQuery = "  (sn like '%".$searchValue."%' or 
        car_no like '%".$searchValue."%' or 
        car_type like '%".$searchValue."%' or 
        car_owner like'%".$searchValue."%' ) ";
}


## Total number of records without filtering

$sel = "SELECT count(*) as allcount FROM cars  WHERE vessel_id= $vessel_id AND done = 0  ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];





## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM cars     WHERE vessel_id= $vessel_id AND done = 0 AND   $searchQuery ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records


//$empQuery = "SELECT * FROM cars where  vessel_id = '$vessel_id' ;    
$empQuery = "SELECT * FROM cars   WHERE vessel_id= $vessel_id  AND done = 0 AND   $searchQuery order by  $columnName $columnSortOrder  $rowLength ";
$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

   $id= $row['id'];

   $data[] = array( 
      "sn"=> $row['sn'],
      "edit"=>'<a class= "btn btn-primary btn-large" href="update.php?id='.$id.' ">تعديل</a>',
      "car_no"=>$row['car_no'],
      "start_date"=>$row['start_date'],
      "car_type"=>$row['car_type'],
      "car_owner"=>$row['car_owner'],
      "mehwer"=>$row['mehwer'],
      "vacant"=>$row['vacant'],
      "limits"=>$row['limits']
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