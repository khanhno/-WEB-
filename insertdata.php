<?php
    include ('includes/dbh.inc.php');
    $username = $_POST['username'];
    $message = $_POST['message'];

    $query = "INSERT INTO comments(author,message) VALUES ('$username','$message')";
    $query_run = mysqli_query($con,$query);
    if($query_run){
        echo "Data Inserted Successfully";
    }
    else{
        echo "Data NOt Inserted";
    }


?>