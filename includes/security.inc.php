<?php
session_start();
require_once('dbh.inc.php');
if($dbconfig){
    // echo "Database connected";
 }
else{
    header("Location: includes/dbh.inc.php");
}

if(!$_SESSION['Username'])
{
    header('location: login.php');
}

?>