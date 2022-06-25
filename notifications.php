<?php
function sendNotification($vessel_name,$name,$body,$domain,$type)
{
    $url ="http://197.51.23.158/url.php?".$domain;
    $timezone = date_default_timezone_set("Africa/Cairo");
    $con = mysqli_connect("localhost","ops_shipping","0123636674@it","ops_marine_shipping");
    $date = date("Y-m-d H:i:sa"); //current date

    $query = "INSERT INTO notifications(vessel_name,ename, body,date, domain,type) VALUES ('$vessel_name','$name', '$body','$date''$url','$type' )";

    mysqli_query($con, $query);
}




