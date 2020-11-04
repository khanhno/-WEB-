<?php
    require_once('includes/dbh.inc.php');
    $commentNewCount = $_POST['commentNewCount'];
    $sql = "SELECT * FROM comments LIMIT  ";
    $result = mysqli_query($con,$sql);
    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo"<p>";
            echo $row['author'];
            echo "<p>";
            echo $row['message'];
            echo "</p>";

        }
    }
    else{
    echo "There are no comments!!";
    }
?>