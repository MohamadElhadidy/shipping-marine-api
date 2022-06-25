<?php
// database connection
require "../../config.php";

 // selecet vessels from DB
$result = mysqli_query($con,"SELECT  *  FROM vessels_log WHERE done = 0 ");
if (mysqli_num_rows($result)  > 0){
            $i=0;
            $v='';
    foreach ($result as $row){
                $v = '';
                $data[]=$row;
                $v.= $data[$i]['id'].'|';
                $v.="\r\n" ;
                $v.='اسم الباخرة : '.$data[$i]['name'];
                $v.="\r\n" ;
                $v.='الصنف : '.$data[$i]['type'];
                $v.="\r\n" ;
                $v.='الكمية : '.$data[$i]['qnt'] .' طن  ';
                $v.="\r\n" ;
                $v.='الرصيف : '.$data[$i]['quay'];
                $v.="\r\n" ;
                $arr[$i]=['vessel' =>$v ]; 
                $i++;
        }
            //print vessel in json format
        echo json_encode($arr);
}
        
?>