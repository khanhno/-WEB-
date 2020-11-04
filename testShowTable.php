<?php
include('includes/security.inc.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

      
<div class="row">
  <div class="col-xl-3 col-lg-4">

    <!-- Area Chart -->
    <div class="card shadow mb-4">
      <div class="card-header py-2">
        <h6 class="m-0 font-weight-bold text-primary">集計期間</h6>
      </div>
      <div class="card-body">
        <div class="">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <form action="testShowTable.php" method="POST">
            <thead>
            </thead>
            <tbody>  
              <tr>
                <td><b>集計開始日</b>
                <input type="date" name="from-date" class = "form-control"></td>  
              </tr>
              <tr>
                <td><b>集計終了</b>
                <input type="date" name="to-date" class = "form-control"></td>
              </tr>
            <tr>
              <td><button  type="submit" name="addmonth" class = "form-control btn btn-warning btn-icon-split"> OK</button></td>
            </tr> 
            </tbody>
          </form>
        </table>
        <hr>
        OK ボタンをクリックすると<code><h4>集計結果を表示する</h4></code>
        </div>
      </div>
    </div>

    <!-- Bar Chart -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">集計</h6>
      </div>
      <div class="card-body">
        <div class="">
        <?php
           if(isset($_POST['addmonth'])){
            $idUser = $_SESSION['UserID'];
            $from_date = $_POST['from-date'];
            $to_date = $_POST['to-date'];
            if($from_date > $to_date){
              //echo '<h6 class ="text-danger">すべての空白を埋めてください。</h6>';
            }else
            if ($from_date == 0 || $to_date == 0){
              //echo '<h5 class ="text-danger">終了時間は開始時間よりも大きくする必要があります。</h5>';
            }else{
            ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <form action="">
            <thead>
              
            </thead>
            <tbody>  
            <?php
              // cách khác để tính số đếm của các thành phần 
              // tạo một function sau đó gọi các function tới đếm  chỉ cần nhập $row thì có thể đếm được không cần 
              function caculateTime($n){
                $hour = floor($n/3600);
                $minutes = floor(($n/60)%60);
                return "$hour:$minutes";
            }
              $workingdateall = 0;
              $Allovertime = 0;
              $Allovertime2 = 0;
              $workingdate = 0;
              $changeworking = 0;
              $offworking = 0;
              $lateworking = 0;
              $holiday = 0;
              $holidaypay = 0;
              $otherday = 0;
              while(0 == 0){
                  $query = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' AND ID_User = '$idUser'";
                  $query1 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '欠勤'AND ID_User = '$idUser'";
                  $query2 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '振替休日'AND ID_User = '$idUser'";
                  $query3 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '休日出勤'AND ID_User = '$idUser'";
                  $query4 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' AND (diligence = '早退' OR diligence = '遅刻') AND ID_User = '$idUser'";
                  $query5 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '有給休暇'AND ID_User = '$idUser'";
                  $query6 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '特別休暇'AND ID_User = '$idUser'";
                  $query7 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = 'その他'AND ID_User = '$idUser'";
                  $query8 = "SELECT SUM(overTime) as total FROM daysdb where pickDays ='$from_date'AND ID_User = '$idUser'";
                  $query9 = "SELECT SUM(overTime2) as total FROM daysdb where pickDays ='$from_date'AND ID_User = '$idUser'";
                  $query_run = mysqli_query($con,$query);
                  $query1_run = mysqli_query($con,$query1);
                  $query2_run = mysqli_query($con,$query2);
                  $query3_run = mysqli_query($con,$query3);
                  $query4_run = mysqli_query($con,$query4);
                  $query5_run = mysqli_query($con,$query5);
                  $query6_run = mysqli_query($con,$query6);
                  $query7_run = mysqli_query($con,$query7);
                  $query8_run = mysqli_query($con,$query8);
                  $query9_run = mysqli_query($con,$query9);
                  $values = mysqli_fetch_assoc($query_run);
                  $values1 = mysqli_fetch_assoc($query1_run);
                  $values2 = mysqli_fetch_assoc($query2_run);
                  $values3 = mysqli_fetch_assoc($query3_run);
                  $values4 = mysqli_fetch_assoc($query4_run);
                  $values5 = mysqli_fetch_assoc($query5_run);
                  $values6 = mysqli_fetch_assoc($query6_run);
                  $values7 = mysqli_fetch_assoc($query7_run);
                  $values8 = mysqli_fetch_assoc($query8_run);
                  $values9 = mysqli_fetch_assoc($query9_run);
                  $num_row = $values['total'];
                  $num_row1 = $values1['total'];
                  $num_row2 = $values2['total'];
                  $num_row3 = $values3['total'];
                  $num_row4 = $values4['total'];
                  $num_row5 = $values5['total'];
                  $num_row6 = $values6['total'];
                  $num_row7 = $values7['total'];
                  $num_row8 = $values8['total'];
                  $num_row9 = $values9['total'];

                  if ($num_row != 0){
                      $workingdateall+=$num_row;
                  }
                  if ($num_row1 != 0){
                      $workingdate+=$num_row1;
                  }
                  if ($num_row2 != 0){
                      $changeworking+=$num_row2;
                  }
                  if ($num_row3 != 0){
                      $offworking+=$num_row3;
                  }
                  if ($num_row4!= 0){
                      $lateworking+=$num_row4;
                  }
                  if ($num_row5!= 0){
                      $holiday+=$num_row5;
                  }
                  if ($num_row6!= 0){
                      $holidaypay+=$num_row6;
                  }
                  if ($num_row7 != 0){
                      $otherday += $num_row7;
                  }
                  if ($num_row8 != 0){
                      $Allovertime += $num_row8;
                  }
                  if ($num_row9 != 0){
                      $Allovertime2 += $num_row9;
                  }
                  $from_date = date('Y-m-d',strtotime($from_date.'+1 days'));
                  if ($from_date ==  date('Y-m-d',strtotime($to_date.'+1 days'))  ) {
                  break;
                  }
                  
              }
              $array = array(
                "所定労働日数",
                "時間外時間",
                "休日時間",
                "欠勤",
                "振替休日",
                "休日出勤",
                "早退 ・　遅刻",
                "有給休暇",
                "特別休暇",
                "その他");
                $array2 = array(
                  "$workingdateall",
                  caculateTime($Allovertime),
                  caculateTime($Allovertime2),
                  "$workingdate",
                  "$changeworking",
                  "$offworking",
                  "$lateworking",
                  "$holiday",
                  "$holidaypay",
                  "$otherday");
                  for($x = 0; $x <= 9;$x++){
                      echo '<tr>';
                      echo '<th> '.$array[$x].' </th>';
                      echo '<td>'.$array2[$x].'</td>';
                      echo '</tr>';
                  }
              ?> 
              
            <?php
          }
        } 
      ?>
            </tbody>
          </form>
        </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Donut Chart -->
  <div class="col-xl-9 col-lg-8">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">タイムシート</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="">
        <?php
        if(isset($_POST['addmonth'])){
            $idUser = $_SESSION['UserID'];
            $from_date = $_POST['from-date'];
            $to_date = $_POST['to-date'];
            
            if($from_date > $to_date){
              echo '<h2 class ="text-danger">終了時間は開始時間よりも大きくする必要があります。</h2>';
            }else
            if ($from_date == 0 || $to_date == 0){
              echo '<h2 class ="text-danger">すべての空白を埋めてください。</h2>';
            }else{
            ?>
            <div> <h2> <?php echo date('Y年m月d日',strtotime($from_date)).' ~ '.date('Y年m月d日',strtotime($to_date))?> </h2> </div>
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <?php
                      $array = array(
                        "日付",
                        "曜日",
                        "区分",
                        "始業時刻",
                        "終業時刻",
                        "休憩時間",
                        "時間内時間",
                        "時間外時間",
                        "休日時間",
                        "事務内容",
                        "勤怠");
                          for($x = 0; $x <= 10;$x++){
                              echo '<th> '.$array[$x].' </th>';
                          }
                      ?> 
                </tr>
              </thead>
              <tbody>
                <?php
                function showTime($n){
                  $hour = gmdate("H",$n);
                  $minutes = gmdate("i", $n);
                  $Text = $hour.':'. $minutes;
                  echo $Text;
                }  
                while(0 == 0){
                    $from_date = date('Y-m-d',strtotime($from_date));
                        echo '<tr>';
                        echo '<td>'.$from_date.'</td>';
                        $query = "SELECT * FROM daysdb Where pickDays ='$from_date'AND ID_User = '$idUser' ";
                        $query_run = mysqli_query($con, $query);
                        
                        if($row = mysqli_fetch_assoc($query_run)){
                        
                          $days = array("日","月","火","水","木","金","土");
                          $japanday = $days[$row['dayofweek']];
                          echo '<td>'.$japanday.'</td>';  
                          echo '<td>'.$row['diligence1'].'</td>';    
                          echo '<td>'.$row['timeStart'].'</td>';    
                          echo '<td>'.$row['timeEnd'].'</td>';   
                          echo '<td>';
                            showTime($row['breakTime']);
                          echo '</td>';   
                          echo '<td>';
                            showTime($row['workTime']);
                          echo '</td>';
                          echo '<td>';
                          showTime($row['overTime']);
                          echo '</td>';
                          echo '<td>';
                            showTime($row['overTime2']);
                          echo '</td>';
                          echo '<td>'.$row['comments'].'</td>';    
                          echo '<td>'.$row['diligence'].'</td>';  
                          
                        }             
                        else{
                          $dayofweek = date('w', strtotime($from_date));
                          $days = array("日","月","火","水","木","金","土");
                          $japanday = $days[$dayofweek];
                            echo '<td>'.$japanday.'</td>';
                          if($japanday == "土"|| $japanday == "日"){
                            echo '<td>休日</td>';
                          }
                          else{
                            echo '<td>平日</td>';
                          }
                          for($x = 0; $x <= 7;$x++){
                            echo '<td></td>';
                        }
                           
                        }
                        $from_date = date('Y-m-d',strtotime($from_date.'+1 days'));
                        echo '</tr>';
                    if ($from_date ==  date('Y-m-d',strtotime($to_date.'+1 days'))  ) {
                    break;
                    }
                }?>
                </tbody>
                </table>
                <?php
               
            }
            
        }
      ?>
        </div>
        <hr>
        
      </div>
    </div>
  </div>
</div>

</div>

<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>