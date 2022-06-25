<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإحصائيات</title>
    <style>
    body {
        direction: rtl;
        text-align: center;
        line-height: 1;
    }

    .header th,
    td {
        border: 1px solid #424242;
    }

    ::placeholder {
        color: blue;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: center;
        padding: 3px;
    }


    th {
        background-color: #ffffff;
        border: 1px solid #424242;
        color: #000000;
    }

    table tbody {
        Background-color: #fff;
        color: #000;
        font-weight: bold;

    }

    tr:nth-child(even) {
        background-color: #979797
    }

    tr {
        border-bottom: 0px;
    }

    .header th {
        background-color: #f1ffee26;
        color: black;
    }

    .header td {
        color: red;
    }

    .clock th {
        font-weight: bold;
        color: green;
        background-color: #ee82ee;
    }
    </style>
</head>

</html>
<?php
$vessel_id=$_GET["vessel_id"];
require '../../config.php';
$outputa = '';
$outputb = '';
$outputc = '';
$outputf = '';
$outputff = '';
$output1= '';
$output2= '';
$output3= '';
$output4= '';
$output5= '';
$output6= '';
$output8= '';
$output00 = '';

$colors =['#0a8fdb','#ff8000','#0a8fdb','#0a8fdb','#0a8fdb','#0a8fdb'];

$query1 ="select * from vessels_log  WHERE vessel_id = '$vessel_id'  ";
$result1 = mysqli_query($con, $query1);

if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $vessel = $row1["name"];
    $type =$row1["type"];
    $quay =$row1["quay"];
    $client =$row1["client"];
    $start_date =$row1["start_date"];
    $qnt =$row1["qnt"];
    $done=$row1["done"];
}
if($done == 0)$search =" done = 0 AND";else $search ="";


$query8 ="select count(*) as count from cars where done =0 AND  vessel_id = '$vessel_id'  ";
$result8 = mysqli_query($con, $query8);

if(mysqli_num_rows($result8) > 0) {
    $row8= mysqli_fetch_assoc($result8);
    $count7 = $row8['count'];
}

$query8 ="select count(*) as count from cars where   vessel_id = '$vessel_id'    ";
$result8 = mysqli_query($con, $query8);

if(mysqli_num_rows($result8) > 0) {
    $row8= mysqli_fetch_assoc($result8);
    $count2 = $row8['count'];
}



$query2 ="select count(*) as count from cars where done =0 AND  vessel_id = '$vessel_id'     ";
$result2 = mysqli_query($con, $query2);

if(mysqli_num_rows($result2) > 0) {
    $row2= mysqli_fetch_assoc($result2);
    $count1 = $row2['count'];
}


$count1=0;
$query8 ="select  * from cars where  done =0 and  vessel_id = '$vessel_id'  GROUP BY  car_no  ";
$result8 = mysqli_query($con, $query8);

        while ($row8 = mysqli_fetch_assoc($result8)) {
         $count1++;
        }


$count3=0;
$query8 ="select  * from cars where   vessel_id = '$vessel_id'  GROUP BY  car_no  ";
$result8 = mysqli_query($con, $query8);

        while ($row8 = mysqli_fetch_assoc($result8)) {
         $count3++;
        }

$query3 ="select count(*) as count from move where  arrival = 1 AND vessel_id = '$vessel_id'";
$result3 = mysqli_query($con, $query3);

if(mysqli_num_rows($result3) > 0) {
    $row3 = mysqli_fetch_assoc($result3);
    $count0 = $row3['count'];
}


$count4=0;
$query33 ="select * from cars where vessel_id = '$vessel_id' AND  $search car_type='سيارة الشركة'  GROUP BY car_no";
$result33 = mysqli_query($con, $query33);
 while (mysqli_fetch_assoc($result33)) {
         $count4++;
        }
$count5=0;
$query44 ="select * from cars where  $search  vessel_id = '$vessel_id' AND  car_type='سيارة قلاب'   GROUP BY car_no";  
$result44 = mysqli_query($con, $query44);

 while (mysqli_fetch_assoc($result44)) {
         $count5++;
        }
$count6=0;
$query3 ="select * from cars where   vessel_id = '$vessel_id' AND $search car_type='سيارة توكتوك'   GROUP BY car_no";
$result3 = mysqli_query($con, $query3);

while (mysqli_fetch_assoc($result3)) {
         $count6++;
        }
$count7=0;
$query11 ="select * from cars where   vessel_id = '$vessel_id' AND $search car_type='سيارة جرار'   GROUP BY car_no";
$result11 = mysqli_query($con, $query11);

while (mysqli_fetch_assoc($result11)) {
         $count7++;
        }


$query4 = "SELECT date FROM arrival where  vessel_id = '$vessel_id' LIMIT 1";
$result4 = mysqli_query($con, $query4);

if(mysqli_num_rows($result4) > 0) {
    $row4= mysqli_fetch_assoc($result4);
          $date= $row4['date'];
          $date2 =strtotime($date);
             $current_time = strtotime(date("Y-m-d H:i:s"));

       //time
        $query1 ="select * from vessels_log WHERE vessel_id = '$vessel_id'  AND done ='1'";
      
      $result1 = mysqli_query($con, $query1);
      if (mysqli_num_rows($result1) > 0) {
       $query4 = "SELECT date FROM arrival where  vessel_id = '$vessel_id' AND id=(SELECT MAX(id) FROM arrival where vessel_id = '$vessel_id')";
    $result4 = mysqli_query($con, $query4);
 if(mysqli_num_rows($result4) > 0) {
        $row4= mysqli_fetch_assoc($result4);
        $date3= $row4['date'];
        $current_time =strtotime($date3);
      }}
     

  $diff =  $current_time -$date2;

    $d = $diff / 86400 % 7;
    $h = $diff / 3600 % 24;
    $m = $diff / 60 % 60;
    $s = $diff % 60;

    $timer= "  {$d} : {$h} : {$m} :{$s} secs  ";
    $day=$d." "."يوم";
    $hour=$h." "."ساعة";
    $minute=$m." "."دقيقة";
} else {
    $day="0"." "."يوم";
    $hour="0"." "."ساعة";
    $minute="0"." "."دقيقة";
}

echo' 



	<table  id="customers" >
  <thead>
            <tr>
             <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 13px;"> اسم الباخره  </th>
                <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 13px;">رقم الرصيف  </th>
                   <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 13px;"> الصنف</th>
                   <th style="background-color: #808080; color:white; border: 2px solid black;padding: 1px;font-size: 13px;"> الكمية</th>


            </tr>

        </thead>
        
        <tbody>
             <tr>
                <th style="background-color: #FFF8DC;color:#660033; border: 2px solid #000000;padding: 1px;font-size: 13px;">  '.$vessel.'</th>
                <th style="background-color: #FFF8DC;color:#660033; border: 2px solid #000000;padding: 1px;font-size: 13px;"> '.$quay.'</th>
                 <th style="background-color:#FFF8DC;color:#660033; border: 2px solid #000000;padding: 1px;font-size: 13px;">  '.$type.'</th>
             <th style="background-color: #FFF8DC;color:#000000; border: 2px solid #000000;padding: 1px;font-size: 13px;">    <span style="color:#660033;">' . $qnt . '</span> طن</th>

 
            </tr>

        </tbody>
       
        </table>
        ';
echo'
        
   	<table  id="customers" style= "margin-bottom:5px;margin-top:5px;">
  
        <tbody>
            <tr>
                  <th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
                 إجمالي السيارات من البدايه
                 :  <span style="color:#ff1a1a;">' . $count3 . '</span></th>
                 ';
                 if($done == 0){
                     echo'
                 <th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">السيارات الحاليه :  <span style="color:#ff1a1a;">' . $count1 . '</span></
            th>';
                 }
   if($count6!= 0   ){      
if($count6==0 AND $done ==0)$g=0; else { echo ' 
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
سـ توكتوك
:  <span style="color:#ff1a1a;">' . $count6 . '</span></th>';}}
 if($count5!= 0   ){ 
if($count5==0 AND $done ==0)$g=0; else { echo '
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
سـ قلاب 
:  <span style="color:#ff1a1a;">' . $count5 . '</span></th>';}}
  if($count4!=0   ){            
if($count4==0 AND $done ==0)$g=0; else { echo '
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">
سـ شركة 
:  <span style="color:#ff1a1a;">' . $count4 . '</span></th>';}}
 if($count7!=0   ){ 
if($count7==0 AND $done ==0)$g=0; else { echo '
<th style="background-color: #FFF8DC;color:#110259; border: 2px solid #000;padding: 1px;font-size:14px;">سـ جرار

:  <span style="color:#ff1a1a;">' . $count7 . '</span></th>';}}

          echo'  </tr>

        </tbody>
        </table>
        ';
$jum ="select SUM(jumbo) as jumbos from loading where  vessel_id = '$vessel_id' ";
$resultj = mysqli_query($con, $jum);

if ($resultj->num_rows > 0) {
    $rowj = mysqli_fetch_assoc($resultj);
    $jumbo = $rowj["jumbos"];
}

$queryf ="select SUM(qnt) as qnts ,Count(*) as count,  SUM(jumbo) as jumbo from loading where qnt_date  IS  NOT NULL AND   vessel_id = '$vessel_id' ";
$resultf = mysqli_query($con, $queryf);

if ($resultf->num_rows > 0) {
    $rowf = mysqli_fetch_assoc($resultf);
    $qntsf = $rowf["qnts"];
    $countq= $rowf['count'];
    $jumbof =$rowf['jumbo'];
}


echo '
        
        		<table  id="customers" style= "margin-bottom:10px;">
  
        <thead>
            <thead>
            <tr>
             <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:13px;">نقلات وصلت  </th>
                <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:13px;">الرصيد الآن </th>

                   <th style="background-color: #b35900; color:white; border: 2px solid black;padding: 1px;font-size:13px;"> جامبو</th>


            </tr>

        </thead>


           <tbody>
            <tr>
             <th  style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:16px;">   <span style="color:blue;">' . $count0 . '</span> </th>
                <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:16px;">  <span style="color:red;">(' . number_format((float)$qntsf, 3, '.', '') .' ) </span> 
             <span style="font-size: 16px;color:blue;">  ( '.$countq .'  )</span> <span style="font-size: 16px;color:green;">  ( '.$jumbof .') </span>  </th>
               <th style="background-color: #FFFFFF ;color:black; border: 2px solid black;padding: 1px;font-size:16px;">   <span style="color:green;">' . $jumbo . '</span>  </th>

            </tr>

        </tbody>
        </table>
        ';
echo'
<table  id="customers" style= "margin-bottom:5px;margin-top:5px;">
  
        <tbody>
            <tr>
                <th style="background-color: #fff5e6;color:#000000;"> مدة التشغيل</th>
               <th style="background-color: #fff5e6;color:#000000; "><span style="color:green;">'.$day.'</span> </th>
                <th style="background-color: #fff5e6;color:#000000;"><span style="color:green;">'.$hour.'</span> </th>

                 <th style="background-color: #fff5e6;color:#000000; "><span style="color:green;">'.$minute.'</span> </th>
                
            </tr>

        </tbody>
        </table>
        ';


$output0='<div class="row"><div class="col-lg-4">';

$query2 ="select * from  move where  vessel_id = '$vessel_id'   GROUP BY store_no  ";
$result2 = mysqli_query($con, $query2);
$i=1;
$output2 .= '
        	<table  id="customers"  style= "margin-bottom:5px;"> 
        <thead>
            <tr>
             <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">رقم المخزن</th>
                  <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">عدد النقلات </th>
                                <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">اجمالي الكمية </th>

            </tr>

        </thead>
        <tbody>';
if ($result2->num_rows > 0) {
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $name2 = $row2["store_no"];
        $query22 = "select SUM(qnt) as qnts , store_no ,COUNT(id) as count ,SUM(jumbo) as jumbo from move where store_no = '$name2' AND  vessel_id = '$vessel_id' ";
        $result22 = mysqli_query($con, $query22);
        if (mysqli_num_rows($result22) > 0) {
            $row22 = mysqli_fetch_assoc($result22);
            $qnts2 = $row22['qnts'];
            $jumbo2 = $row22['jumbo'];
        }
        $output2 .= '<tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row22["store_no"].'</span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:blue;">'.$row22["count"]. ' </span> </th>
                          <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:red;">(' . number_format((float)$qnts2, 3, '.', '')  . ') </span> <span style="color:green;">(' . $jumbo2 . ' )</span></th>

            </tr> ';
    }
}
$output2 .='</tbody></table>';



$query8 ="select * from  move where  vessel_id = '$vessel_id'   GROUP BY type  ";
$result8 = mysqli_query($con, $query8);
$i=1;
$output8 .= '
        	<table  id="customers"  style= "margin-bottom:5px;"> 
        <thead>
            <tr>
           <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;"> الصنف</th>
            <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">عدد النقلات </th>
           <th style="background-color:'.$colors[$i].'; color:white; border: 1px solid black;font-size:12px;">اجمالي الكمية </th>

            </tr>

        </thead>
        <tbody>';
if ($result8->num_rows > 0) {
    while ($row8 = mysqli_fetch_assoc($result8)) {
        $name8 = $row8["type"];
        $query88 = "select SUM(qnt) as qnts , type ,COUNT(id) as count ,SUM(jumbo) as jumbo  from move where type = '$name8' AND  vessel_id = '$vessel_id' ";
        $result88 = mysqli_query($con, $query88);
        if (mysqli_num_rows($result88) > 0) {
            $row88 = mysqli_fetch_assoc($result88);
            $qnts8 = $row88['qnts'];
            $jumbo8 = $row88['jumbo'];
        }
        
        $output8 .= '<tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$row88["type"].'</span> </th>
              <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:blue;">'.$row88["count"]. ' </span> </th>
                          <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:red;">(' . number_format((float)$qnts8, 3, '.', '')  . ') </span> <span style="color:green;">(' . $jumbo8 . ' )</span></th>

            </tr> ';
    }
}
$output8 .='</tbody></table>';




$query7="select * from  cars where vessel_id = '$vessel_id' group by car_no ";
$result7 = mysqli_query($con, $query7);
$i=5;
$output7 ='
<div class ="col-lg-8">
        <table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
            
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">كود</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">رقم السيارة</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">النوع </th>
             <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;font-size:12px;">مقاول</th>
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">نقلات</th>
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">الكميه </th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">المتوسط</th>';
                if ($jumbo !='0'){ $output7 .= '<th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">جامبو</th>';}

            
                $output7 .= ' <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px">دخول</th>
                  <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px">خروج</th>

            </tr>

        </thead>
        <tbody>';

if ($result7->num_rows > 0) {
    $m=1;
    while ($row7 = mysqli_fetch_assoc($result7)) {
        $car_no = $row7["car_no"];
        $query777="select * from  cars where vessel_id = '$vessel_id' and car_no = '$car_no' order by start_date asc";
        $result777 = mysqli_query($con, $query777);
        $sns=[];
        $color=[];
        $start_date=[];
        $exit_date=[];
    if ($result777->num_rows > 0) {
        $qnts7=0;
        $count7=0;
        $count77=0;
        $count999=0;
        
        while ($row777 = mysqli_fetch_assoc($result777)) {
            array_push($sns,$row777['sn']);
            array_push($start_date,$row777['start_date']);
            if($row777['exit_date']!=''){
                array_push($exit_date,$row777['exit_date']);
            }else{
                array_push($exit_date,'_______');
            }
            
            
        $query77 ="select SUM(qnt) as qnts ,count(id) as count from move where sn = '".$row777["sn"]."' AND vessel_id = '$vessel_id' ";
        $result77= mysqli_query($con, $query77);
        if(mysqli_num_rows($result77) > 0) {
            $row77= mysqli_fetch_assoc($result77);
            $qnts7 += $row77['qnts'];
            $count7 += $row77['count'];
        }
        $query77 ="select SUM(qnt) as qnts ,count(id) as count from move where sn = '".$row777["sn"]."' AND vessel_id = '$vessel_id' AND arrival = '1' ";
        $result77= mysqli_query($con, $query77);
        if(mysqli_num_rows($result77) > 0) {
            $row77= mysqli_fetch_assoc($result77);
            $count77 += $row77['count'];
        }
         $query779="select SUM(jumbo) as jumbo ,count(id) as count from move where sn = '".$row777["sn"]."' AND vessel_id = '$vessel_id'  ";
        $result779= mysqli_query($con, $query779);
        if(mysqli_num_rows($result779) > 0) {
            $row779= mysqli_fetch_assoc($result779);
            $count999 += $row779['jumbo'];
        }
         if($row777['done']==0){
            array_push($color,'green');
            $row777["exit_date"] ='ــــــــــ';
        }
        else {
            array_push($color,'red');
        }
      
        }
        }
       
        
        if($count77  != 0 ){
             $avg =$qnts7 /$count77 ;
        }else {
            $avg='';
        }
        
        $output7 .= '
       <tr>  
            <th >  
            ';
            for($i=0;$i < count($sns); $i++){
                $sn = $sns[$i];
             $output7 .= '
            <span style="color:'. $color[$i].';padding: 1px;font-size:12px;">' .$sn . ' </span> 
            
            ';
            }
            $output7 .= '
            
            </th>
            
            
            
            
            
            
            
            
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$row7["car_no"].'</span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$row7["car_type"].'</span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$row7["car_owner"].'</span> </th>

            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$count77.'</span> </th> 
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">' . number_format((float)$qnts7, 3, '.', '') . ' </span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:12px;">' . number_format((float)$avg, 3, '.', '') . ' </span> </th>';
                   if ($jumbo !='0'){ $output7 .= ' <th >  <span style="color:'. end($color).';padding: 1px;font-size:12px;">'.$count999.'</span> </th>';}
                    $output7 .= '<th >   <span style="color:'. end($color).';padding: 1px;font-size:10px;">' . $start_date[0] . ' </span> </th>
            <th >   <span style="color:'. end($color).';padding: 1px;font-size:10px;">
                   '.end($exit_date).'
                     </span> </th>
        </tr>';
        $m++;
    }
}
$output7 .='</tbody></table>';


$output77 ='
        	<div class ="col-lg-8">
        <table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
              <th style="background-color:#000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">المقاول</th>
             <th style="background-color:red; color:white; border: 1px solid black;padding: 1px;font-size:12px;">عدد </th>
             <th style="background-color:green; color:white; border: 1px solid black;padding: 1px;font-size:12px;">الآن</th>
             <th style="background-color:#000; color:white; border: 1px solid black;padding: 1px;font-size:12px;"> نقلات</th>
             <th style="background-color:#000; color:white; border: 1px solid black;padding: 1px;font-size:12px;"> الكمية</th>
             
             ';

           $output77 .=' </tr>

        </thead>
        <tbody>
        ';
       
       
$query9 ="select * from  cars where vessel_id = '$vessel_id'  group by car_owner   ";
$result9= mysqli_query($con, $query9); 
   if ($result9->num_rows > 0) {
    while ($row9 = mysqli_fetch_assoc($result9)) {
        $moves=0;
        $qnts=0;
        $jumbos=0;
        $moves2=0;
        $car_owner=$row9['car_owner'];
        $cars =[];
        $cars2 =[];

        $output77 .= '
                <tr>  
             <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:black;">'.$car_owner.'</span> </th>
             ';
             
       $query99 ="select * from  cars where car_owner = '$car_owner'  AND  vessel_id = '$vessel_id' ";
        $result99= mysqli_query($con, $query99);
        if ($result99->num_rows > 0) {
          while ($row99 = mysqli_fetch_assoc($result99)) {
               array_push($cars,$row99["sn"]);
         }
         }

          $query99 ="select * from  cars where car_owner = '$car_owner'  AND  vessel_id = '$vessel_id' AND done = 0";
        $result99= mysqli_query($con, $query99);
        if ($result99->num_rows > 0) {
          while ($row99 = mysqli_fetch_assoc($result99)) {
               array_push($cars2,$row99["sn"]);
         }
         }
         $count= count($cars);
         $count2= count($cars2);
        for($s=0;$s<$count;$s++){
             
        $query099 ="select SUM(qnt) as qnts ,COUNT(id) as count, SUM(jumbo) as jumbos  from move where sn = '$cars[$s]'  AND vessel_id = '$vessel_id' AND arrival = 1";
        $result099= mysqli_query($con, $query099);
        if(mysqli_num_rows($result099) > 0) {
            $row099= mysqli_fetch_assoc($result099);
            $moves += $row099['count'];
          
        }  


                $query099 ="select SUM(qnt) as qnts ,COUNT(id) as count, SUM(jumbo) as jumbos  from loading where sn = '$cars[$s]'  AND vessel_id = '$vessel_id'  AND qnt_date is not null";
        $result099= mysqli_query($con, $query099);
        if(mysqli_num_rows($result099) > 0) {
            $row099= mysqli_fetch_assoc($result099);
            $qnts += $row099['qnts'];
            $moves2 += $row099['count'];
            $jumbos += $row099['jumbos'];
          
        }  
        
        }
        
           $output77 .= '
            <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:red;">
           ' . $count  . ' </th>
              <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:green;">
           ' . $count2  . ' </th>
           <th color:red; border: 1px solid black;font-size:12px;">   <span style="color:black;">
           ' . $moves  . ' </th>
           
        <th color:black; border: 1px solid black;font-size:12px;">   <span style="color:red;">(' . number_format((float)$qnts, 3, '.', '')  . ') </span><span style="color:blue;">(' . $moves2 . ' )</span> <span style="color:green;">(' . $jumbos . ' )</span></th>

           ';
           
           
       
             $output77 .= ' </tr>';
 
              }}
$output77 .='</tbody></table></div>';
$query7="select * from  cars where vessel_id = '$vessel_id' group by car_no";
$result7 = mysqli_query($con, $query7);
$i=5;
$output17 ='
<div class ="col-lg-8">
        <table  id="customers"  style= "margin-bottom:5px;">
        <thead>
            <tr>
            
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">كود</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">رقم السيارة</th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">النوع </th>
             <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;font-size:12px;">مقاول</th>
             <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;font-size:12px;">رقم الحله</th>
             
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">وزن المحاور</th>
                <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">وزن الفارغ </th>
                 <th style="background-color:#008000; color:white; border: 1px solid black;padding: 1px;font-size:12px;">حد الحمولة</th>

            </tr>

        </thead>
        <tbody>';

if ($result7->num_rows > 0) {
    $m=1;
    while ($row7 = mysqli_fetch_assoc($result7)) {
        if($row7['done']==0){
            $color ='green';
            $row7["exit_date"] ='ــــــــــ';
        }
        else {
            $color = 'red';
        }
     $mehwer = $row7["mehwer"];
      $vacant = $row7["vacant"];
     
      
        $output17 .= '
       <tr>  
            <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;">' . $row7["sn"] . ' </span> </th>
            <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;">'.$row7["car_no"].'</span> </th>
            <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;">'.$row7["car_type"].'</span> </th>
            <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;">'.$row7["car_owner"].'</span> </th>
            <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;">'.$row7["hla1"].' - '.$row7["hla2"] .'</span> </th>
             <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;"> '. number_format((float)$mehwer, 3, '.', '') .'</span> </th>
              <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;">'. number_format((float)$vacant, 3, '.', '') .'</span> </th>
               <th >   <span style="color:'.$color.';padding: 1px;font-size:12px;">'.number_format((float)$row7["limits"], 3, '.', '').'</span> </th>
               
               
              </tr>';
                   
        $m++;
    }
}
$output17 .='</tbody></table>';




echo $outputa;
echo $outputb;
echo $outputf;
echo $outputc;
echo $output0;

//type
echo $output8;

//store_no
echo $output2;


echo '</div>';

//cars
echo $output77;
echo $output7;
echo $output17;
