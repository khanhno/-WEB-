<?php
 session_start();
require_once('dbh.inc.php');
if(isset($_POST['addmonth'])){
    echo '<a href="../totaltime.php">back</a></br>';
    $day_count = 0;
    $from_date = $_POST['from-date'];
    $to_date = $_POST['to-date'];
    if ($from_date == 0 || $to_date == 0){
        header("Location: ../totaltime.php?error=no-date-values");
    }else{
    ?>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style = "border: 1px solid black;">
        <thead>
            <tr style = "border: 1px solid black;">
                <?php
                    $array = array("day","date","kubun");
                    for($x = 0; $x <= 2;$x++){
                        echo '<th> '.$array[$x].' </th>';
                    }
                ?> 
            </tr>
        </thead>
        <tbody>
        <?php
        // cách khác để tính số đếm của các thành phần 
        // tạo một function sau đó gọi các function tới đếm  chỉ cần nhập $row thì có thể đếm được không cần
        $Allovertime = 0; 
        $Allovertime2 = 0; 
        function showTime($n){
            $hour = gmdate("H",$n);
            $minutes = gmdate("i", $n);
            $Text = $hour.':'. $minutes;
            echo $Text;
          }  
        function caculateTime($n){
            $hour = floor($n/3600);
            $minutes = floor(($n/60)%60);
            return "$hour:$minutes";
        }

        while(0 == 0){
            
                 
                echo '<tr>';
                echo '<td>'.$from_date.'</td>';
                $query = "SELECT * FROM daysdb Where pickDays ='$from_date'";
                $query_run = mysqli_query($con, $query);

                $query1 = "SELECT SUM(overTime) as total FROM daysdb where pickDays ='$from_date'";
                $query1_run = mysqli_query($con,$query1);
                $values = mysqli_fetch_assoc($query1_run);
                $num_row = $values['total'];
                if ($num_row != 0){
                    $Allovertime+=$num_row;
                }

                $query2 = "SELECT SUM(overTime2) as total FROM daysdb where pickDays ='$from_date'";
                $query2_run = mysqli_query($con,$query2);
                $values2 = mysqli_fetch_assoc($query2_run);
                $num_row2 = $values2['total'];
                if ($num_row2 != 0){
                    $Allovertime2+=$num_row2;
                }
                
                if($row = mysqli_fetch_assoc($query_run)){
                   
                    $days = array("日","月","火","水","木","金","土");
                    $japanday = $days[$row['dayofweek']];
                    echo '<td>'.$japanday.'</td>';  
                    echo '<td>'.$row['diligence1'].'</td>';    
                    echo '<td>'.$row['timeStart'].'</td>';    
                    echo '<td>'.$row['timeEnd'].'</td>';    
                    echo '<td>'.$row['breakTime'].'</td>';    
                    echo '<td>'.$row['workTime'].'</td>';    
                    echo '<td>'.$row['overTime'].'</td>';    
                    echo '<td>'.$row['overTime2'].'</td>';    
                    echo '<td>'.$row['diligence'].'</td>';    
                    echo '<td>'.$Allovertime.'</td>';    
                    echo '<td>';
                    echo showTime($Allovertime);
                    echo '</td>';  
                    echo '<td>';
                    echo caculateTime($row['overTime']);
                    echo '</td>';  
                    echo '<td>';
                    echo caculateTime($Allovertime);
                    echo '</td>'; 
                    echo '<td>';
                    echo caculateTime($row['overTime2']);
                    echo '</td>'; 
                    echo '<td>';
                    echo caculateTime($Allovertime2);
                    echo '</td>';   

                }      
                else{
                    echo '<td>no data  </td>';
                }
                echo '</tr>';
                $from_date = date('Y-m-d',strtotime($from_date.'+1 days'));
            if ($from_date ==  $to_date  ) {
            break;
            }
        }?>
        </tbody>
        </table>
        <?php
    }
    
}
?>