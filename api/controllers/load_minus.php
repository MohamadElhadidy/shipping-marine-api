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
if($columnIndex == 2){
    $columnName = " cars.".$_POST['columns'][$columnIndex]['data']; }
else{
    $columnName = " minus.".$_POST['columns'][$columnIndex]['data']; // Column name
}
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " AND (minus.cause like '%".$searchValue."%' or 
        minus.sn like'%".$searchValue."%' or
        cars.car_no like'%".$searchValue."%' or
        minus.ename like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

$sel = "SELECT  count(*) as allcount FROM minus LEFT JOIN cars ON minus.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE minus.vessel_id= $vessel_id  ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'];





## Total number of record with filtering
$sel = "SELECT  count(*) as allcount FROM minus LEFT JOIN cars ON minus.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE minus.vessel_id= $vessel_id AND 1  $searchQuery  ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'];

## Fetch records


//$empQuery = "SELECT * FROM minus where  vessel_id = '$vessel_id' ;    
$empQuery = "SELECT *,minus.id as minus_id   FROM minus LEFT JOIN cars ON minus.sn=cars.sn AND cars.vessel_id = $vessel_id  WHERE minus.vessel_id= $vessel_id AND 1  $searchQuery order by  $columnName $columnSortOrder  $rowLength ";
$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

$id = $row['minus_id'];


   $data[] = array( 
      "sn"=> $row['sn'],
      "edit"=>'<a class= "btn btn-primary btn-large" href="update_minus.php?id='.$id.' ">تعديل</a>',
      "car_no"=>$row['car_no'],
      "minus_duration"=>$row['minus_duration'],
      "cause"=>$row['cause'],
      "ename"=>$row['ename'],
      "date"=>$row['date'],
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