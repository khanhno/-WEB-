<?php
    include ('includes/dbh.inc.php');

    $query = "SELECT * FROM comments";
    $query_run = mysqli_query($con, $query);
    echo '
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th> ID </th>
        <th> Username </th>
        <th>Email </th>
      </tr>
    </thead>
    <tbody>
     ';
    if($query_run){
        while($row = mysqli_fetch_array($query_run)){
            echo "<tr>";
            echo   "<td>";
            echo  $row['id'];
            echo "</td>";
            echo   "<td>";
            echo  $row['author'];
            echo "</td>";
            echo   "<td>";
            echo  $row['message'];
            echo "</td>";
            echo "</tr>" ;
        };
    }
    else{
        echo "dont have any record ";
    }
    echo '
    </tbody>
    </table>   
    ';
?>