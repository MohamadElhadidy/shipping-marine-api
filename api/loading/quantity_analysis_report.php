<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> بيان تحليلي بالكميات</title>
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Changa:wght@600&display=swap");

    :root {
        --bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
        --bs-body-font-family: "Changa", sans-serif !important;
        --bs-body-font-size: 13px;
        --bs-body-line-height: 1.5;
        --bs-body-color: #212529;
        --bs-body-bg: #fff;
    }

    body {
        direction: rtl;
        margin: 0 auto;
        font-family: var(--bs-body-font-family);
        font-size: var(--bs-body-font-size);
        line-height: var(--bs-body-line-height);
        color: var(--bs-body-color);
        text-align: var(--bs-body-text-align);
        background-color: var(--bs-body-bg);
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;

    }

    table td,
    table th {
        border: solid black 1px;
        text-align: center;
    }

    .no-border {
        border-bottom: 1px solid Transparent !important;
        ;
    }

    .right-border {
        border-right: 1px solid black !important;
        ;
    }

    .table>:not(caption)>*>* {
        background-color: var(--bs-table-bg);
        border-bottom-width: 1px;
        box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    }

    table {
        caption-side: bottom;
        border-collapse: collapse;
    }

    .table {
        --bs-table-bg: transparent;
        --bs-table-accent-bg: transparent;
        --bs-table-striped-color: #212529;
        --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
        --bs-table-active-color: #212529;
        --bs-table-active-bg: rgba(0, 0, 0, 0.1);
        --bs-table-hover-color: #212529;
        --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-color: #dee2e6;
    }

    table td {
        font-weight: normal !important;
    }

    table th {
        font-weight: bolder !important;
        font-size: 1.1rem !important;
    }
    </style>
</head>

</html>
<?php
$vessel_id=$_GET["vessel_id"];

require '../../config.php';


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

$countAll =0;
$query2 ="select * from cars where   vessel_id = '$vessel_id'   group by car_no  ";
$result2 = mysqli_query($con, $query2);

if(mysqli_num_rows($result2) > 0) {
     while ($row2 = mysqli_fetch_assoc($result2)) {
            $countAll++;
        }
}

$query3 ="select count(*) as count from cars where done =0 AND  vessel_id = '$vessel_id'     ";
$result3 = mysqli_query($con, $query3);

if(mysqli_num_rows($result3) > 0) {
    $row3= mysqli_fetch_assoc($result3);
    $countNow = $row3['count'];
}


$queryMove ="select count(*) as count from move where arrival =1 AND  vessel_id = '$vessel_id'     ";
$resultMove = mysqli_query($con, $queryMove );

if(mysqli_num_rows($resultMove ) > 0) {
    $rowMove = mysqli_fetch_assoc($resultMove );
    $countMove  = $rowMove ['count'];
}


$countTok=0;
$queryTok ="select * from cars where   vessel_id = '$vessel_id' AND  car_type='سيارة توكتوك'   GROUP BY car_no";
$resultTok = mysqli_query($con, $queryTok);

if(mysqli_num_rows($resultTok) > 0) {
while (mysqli_fetch_assoc($resultTok)) {
         $countTok++;
        }
}

$countCom=0;
$queryCom ="select * from cars where vessel_id = '$vessel_id' AND car_type='سيارة الشركة'   GROUP BY car_no";
$resultCom = mysqli_query($con, $queryCom);

if(mysqli_num_rows($resultCom) > 0) {
while (mysqli_fetch_assoc($resultCom)) {
         $countCom++;
        }
}

$countAlab=0;
$queryAlab ="select * from cars where vessel_id = '$vessel_id' AND  car_type='سيارة قلاب'   GROUP BY car_no";
$resultAlab = mysqli_query($con, $queryAlab);

if(mysqli_num_rows($resultAlab) > 0) {
while (mysqli_fetch_assoc($resultAlab)) {
         $countAlab++;
        }
}

$countGrar=0;
$queryGrar ="select * from cars where  vessel_id = '$vessel_id' AND  car_type='سيارة جرار'    GROUP BY car_no";
$resultGrar = mysqli_query($con, $queryGrar);

if(mysqli_num_rows($resultGrar) > 0) {
while (mysqli_fetch_assoc($resultGrar)) {
         $countGrar++;
        }
}

$cars = [];
$i = 0;
$query4 ="select  * from cars where   vessel_id = '$vessel_id'  GROUP BY  car_no order by  id ASC ,  car_owner    ";
$result4 = mysqli_query($con, $query4);

        while ($row4 = mysqli_fetch_assoc($result4)) {
            $cars["car_no"][$i]=$row4['car_no'];
            $cars["mehwer"][$i]=$row4['mehwer'];
            $cars["empty"][$i]=$row4['empty'];
            $cars["owner"][$i]=$row4['car_owner'];
            $cars["type"][$i]=$row4['car_type'];
            $cars["sn"][$i]=$row4['sn'];
            $i++;
        }



$ouput111 = "<table class='table'>
        <thead style='background-color: #808080;color:white;font-size:13px;'>
            <td>اسم الباخره	</td>
            <td>رقم الرصيف	</td>
            <td>الصنف	</td>
            <td>الكمية</td>
           </thead> 
        
         <thead style='background-color: #FFF8DC;color: #660033;'>
            <td>$vessel</td>
            <td>$quay</td>
            <td>$type</td>
            <td>$qnt</td>
            ";
            
        $ouput111.='</thead> 
        </table>';
 
 
 
 
 
$ouput222=" <table class='table'>
       
         <thead style='background-color: #FFF8DC;color: #660033;'>
            <td>إجمالي السيارات :  <span style='color:#ff1a1a'> $countAll</span></td>
            ";
            if($countTok != 0 ){$ouput222.="
            <td>سيارة توكتوك :  <span style='color:#ff1a1a;'>$countTok</span></td>";
            }if($countAlab != 0 ){$ouput222.="
            <td>سيارة قلاب :  <span style='color:#ff1a1a;'>$countAlab</span></td>";
            }if($countCom != 0 ){$ouput222.="
            <td>سيارة شركة :  <span style='color:#ff1a1a;'>$countCom</span></td>";
            }if($countGrar != 0 ){$ouput222.="
            <td>سيارة جرار :  <span style='color:#ff1a1a;'>$countGrar</span></td>";
            }if($countMove != 0 ){$ouput222.="
            <td> عدد النقلات :  <span style='color:#ff1a1a;'>$countMove</span></td>
            
            ";
            }
        $ouput222.='</thead> 
        </table>';
 
 
 
 
$ouput000=' <table class="table">
        <thead style="background-color: #fff;">
            <th> المقاول/الشركة</th>
            ';
            for ($i=0; $i < $countAll; $i++) { 
                $owner =$cars["owner"][$i];
                $ouput000.= "<td>$owner</td>";
            }
            
        $ouput000.='</thead>
        <thead>
            <th>النوع</th>';
            
            for ($i=0; $i < $countAll; $i++) { 
                $type =$cars["type"][$i];
                $ouput000.= "<td>$type</td>";
            }
            
        $ouput000.=' </thead><thead><td>كود السيارة</td>';
       
            for ($i=0; $i < $countAll; $i++) { 
                $sn =$cars["sn"][$i];
                $ouput000.= "<td>$sn</td>";
            }
            
       $ouput000.=' </thead>
       <thead style="background-color: #7EE8F2;"><th>رقم السيارة</th>';
               

            for ($i=0; $i < $countAll; $i++) { 
                $car_no =$cars["car_no"][$i];
                $ouput000.= "<td>$car_no</td>";
            }
            
       $ouput000.=' </thead>
        <thead style="background-color: #fff;">
            <th>المحاور</th>
           ';
            for ($i=0; $i < $countAll; $i++) { 
                $mehwar = $cars["mehwer"][$i];
                $ouput000.= "<td>" . number_format((float)$mehwar, 3, '.', '') ."</td>";
            }
            
       $ouput000.=' </thead>
        <thead>
            <th>المسموح</th>
            ';
            for ($i=0; $i < $countAll; $i++) { 
                $allow = $cars["mehwer"][$i] * .05;
                $ouput000.= "<td>$allow</td>";
            }
        
       $ouput000.=' </thead>
        <thead>
            <th>الاجمالى</th>
           ';
            for ($i=0; $i < $countAll; $i++) { 
                $allow = $cars["mehwer"][$i] * .05;
                $total = $cars["mehwer"][$i]+$allow;
                $ouput000.= "<td>$total</td>";
            }
            
       $ouput000.=' </thead>
        <thead style="background-color: #fff;">
            <th>الوزن الفارغ</th>
            ';
            for ($i=0; $i < $countAll; $i++) { 
                $empty = $cars["empty"][$i];
                $ouput000.= "<td>" . number_format((float)$empty, 3, '.', '') ."</td>";
            }
           
        $ouput000.='</thead>

        <thead style="background-color: #38c728;">
            <th>حد الحموله</th>
            ';
            for ($i=0; $i < $countAll; $i++) { 
                $allow = $cars["mehwer"][$i] * .05;
                $total = $cars["mehwer"][$i]+$allow;
                $pure = $total - $cars["empty"][$i];
                $ouput000.= "<td>$pure</td>";
            }
           
        $ouput000.='</thead>';
        
        $counts =[];
        
         for ($i=0; $i < $countAll; $i++) { 
            $sn = $cars["sn"][$i];
            $query5 ="select count(*) as count from move where sn = '$sn' AND  vessel_id = '$vessel_id' AND arrival ='1' ";
            $result5 = mysqli_query($con, $query5);

            if(mysqli_num_rows($result5) > 0) {
                $row5 = mysqli_fetch_assoc($result5);
                $counts['move'][$i] = $row5['count'];
                }
         }

        $max =max($counts['move']);

        $qnts = [];
        $totals = [];
         for ($i=0; $i < $countAll; $i++) { 
            $sn = $cars["sn"][$i];
            
            $qnts['sn'][$i] = $sn;
            $totals ['sn'][$i] = $sn;
            $query6 ="select  * from move where  sn ='$sn' AND  vessel_id = '$vessel_id'   ";
            $result6 = mysqli_query($con, $query6);
            $j = 0;
            $totals['qnt'][$i] = 0;
            while ($row6 = mysqli_fetch_assoc($result6)) {
                $qnts['qnt'][$j][$i] = $row6["qnt"];
                $totals['qnt'][$i]+= $row6["qnt"];
                $j++;
            }
                 
            
        } 
        

          for ($i=0; $i < $max; $i++) { 
            $ouput000.= '<thead style="background-color:#fff">';
                 if ($i == '0') {
                    $ouput000.= '<th>وزن التحميل</th>';
                }else{
                    $ouput000.= '<th class="no-border"></th>';
                }
                for ($j=0; $j < $countAll; $j++) { 
                $qnt = $qnts['qnt'][$i][$j];
                $ouput000.= "<td>$qnt</td>";
                
          }
          $ouput000.= '</thead>';
          }
               

     $ouput000.='  <thead style="background-color: #FFFF7E;">
            <th>الاجمالى</th>';
             for ($i=0; $i < $countAll; $i++) { 
                $all = $totals['qnt'][$i];
                $ouput000.= "<td>$all</td>";
            }
      $ouput000.='  </thead>
        <thead style="background-color: #FB637E;">
            <th>عدد النقلات</th>
           ';
             for ($i=0; $i < $countAll; $i++) { 
                $move = $counts["move"][$i];
                $ouput000.= "<td>$move</td>";
            }
            
     $ouput000.='   </thead>
        

    </table>';

echo $ouput111;
echo $ouput222;
echo $ouput000;