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

$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = 1;
if($searchValue != ''){
$searchQuery = " (loading.type like '%".$searchValue."%' or 
        loading.sn like'%".$searchValue."%' or
        cars.car_no like'%".$searchValue."%' or
        loading.qnt like'%".$searchValue."%' or
        loading.store_no like'%".$searchValue."%' or
        loading.jumbo like'%".$searchValue."%' or
        loading.ename like'%".$searchValue."%' or
        loading.notes like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

$sel = "SELECT count(*) as allcount FROM loading LEFT JOIN cars ON loading.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE loading.vessel_id= $vessel_id ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];
$count  = $totalRecords;




## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM loading LEFT JOIN cars ON loading.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE loading.vessel_id= $vessel_id AND   $searchQuery ";

$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT *,  loading.id as loading_id, loading.qnt as loading_qnt FROM loading LEFT JOIN cars ON loading.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE loading.vessel_id= $vessel_id AND   $searchQuery   order by loading.date desc";
$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

$id= $row['loading_id'];

$data[] = array( 
        "count"=>$count,
        "date"=>$row['date'],
        "car_no"=>$row['car_no'],
        "qnt"=>$row['loading_qnt'],
        "jumbo"=>$row['jumbo'],
        "notes"=>$row['notes']
    );
    $count--;
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