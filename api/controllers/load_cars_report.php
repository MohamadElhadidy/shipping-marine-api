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
$columnName = ", ".$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " AND (sn like '%".$searchValue."%' or 
        car_no like '%".$searchValue."%' or 
        car_type like '%".$searchValue."%' or 
        car_owner like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

$sel = "SELECT count(*) as allcount FROM cars where done = 0 AND vessel_id = '$vessel_id'  ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];





## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM cars where done = 0 AND vessel_id = '$vessel_id'  AND  1  ".$searchQuery." ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records


$empQuery = "SELECT * FROM cars where done = 0 AND vessel_id = '$vessel_id' AND 1  ".$searchQuery." order by  start_date desc ".$columnName." ".$columnSortOrder."  ".$rowLength.""; 
   

$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

  
   $data[] = array( 
      "sn"=>$row['sn'],
      "car_no"=>$row['car_no'],
      "car_type"=>$row['car_type'],
      "car_owner"=>$row['car_owner'],
      "start_date"=>$row['start_date'],
      "hla"=> $row['hla1'].' - '.$row['hla2'],
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