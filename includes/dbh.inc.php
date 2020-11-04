<?php
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "projectv2";

    $con = mysqli_connect($servername,$dBUsername,$dBPassword,$dBName);
    $dbconfig = mysqli_select_db($con,$dBName);
    if($dbconfig){
        // echo "Database connected";
     }
     else{
         echo "database connection failed";
     }
?>
