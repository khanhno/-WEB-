<?php
include('includes/security.inc.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Total</h6>
  </div>

  <div class="card-body">

    <div class="table-responsive">
      
      <div>
          <h2 id="tabledisplay"></h2>
      </div>
     
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <form action="includes/addmonth.inc.php" method="POST">
        <thead>
          <tr>
            <th> Date From</th>
            <th>  DAte To</th>
            <th> button </th>
          </tr>
        </thead>
        <tbody>   
          <td>
            <input type="date" name="from-date" class = "form-control">
          </td>  
          <td>
            <input type="date" name="to-date" class = "form-control">
          </td>      
          <td>
            <button  type="submit" name="addmonth" class = "form-control"> search day</button>
          </td>
        </tbody>
        </form>
      </table>  
      <?php
           if(isset($_POST['addmonth'])){
            $day_count = 0;
            $from_date = $_POST['from-date'];
            $to_date = $_POST['to-date'];
            if($from_date > $to_date){
              echo "loi 1";
            }else
            if ($from_date == 0 || $to_date == 0){
                echo "loi 2";
            }else{
            ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <?php
                      $array = array(
                        "Title",
                        "Total");
                          for($x = 0; $x <= 1;$x++){
                              echo '<th> '.$array[$x].' </th>';
                          }
                      ?> 
                </tr>
              </thead>
              <tbody>
              <?php
              // cách khác để tính số đếm của các thành phần 
              // tạo một function sau đó gọi các function tới đếm  chỉ cần nhập $row thì có thể đếm được không cần 
              $workingdateall = 0;
              $workingdate = 0;
              $changeworking = 0;
              $offworking = 0;
              $lateworking = 0;
              $holiday = 0;
              $holidaypay = 0;
              $otherday = 0;
              
              while(0 == 0){
        
                  $day_count++;
                  $from_date = date('Y-m-d',strtotime($from_date.'+1 days'));
                  $query = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date'";
                  $query1 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '欠勤'";
                  $query2 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '振替休日'";
                  $query3 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '休日出勤'";
                  $query4 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' AND (diligence = '早退' OR diligence = '遅刻') ";
                  $query5 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '有給休暇'";
                  $query6 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = '特別休暇'";
                  $query7 = "SELECT COUNT(diligence) as total FROM daysdb where pickDays ='$from_date' && diligence = 'その他'";
                  $query_run = mysqli_query($con,$query);
                  $query1_run = mysqli_query($con,$query1);
                  $query2_run = mysqli_query($con,$query2);
                  $query3_run = mysqli_query($con,$query3);
                  $query4_run = mysqli_query($con,$query4);
                  $query5_run = mysqli_query($con,$query5);
                  $query6_run = mysqli_query($con,$query6);
                  $query7_run = mysqli_query($con,$query7);
                  $values = mysqli_fetch_assoc($query_run);
                  $values1 = mysqli_fetch_assoc($query1_run);
                  $values2 = mysqli_fetch_assoc($query2_run);
                  $values3 = mysqli_fetch_assoc($query3_run);
                  $values4 = mysqli_fetch_assoc($query4_run);
                  $values5 = mysqli_fetch_assoc($query5_run);
                  $values6 = mysqli_fetch_assoc($query6_run);
                  $values7 = mysqli_fetch_assoc($query7_run);
                  $num_row = $values['total'];
                  $num_row1 = $values1['total'];
                  $num_row2 = $values2['total'];
                  $num_row3 = $values3['total'];
                  $num_row4 = $values4['total'];
                  $num_row5 = $values5['total'];
                  $num_row6 = $values6['total'];
                  $num_row7 = $values7['total'];

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
                  if ($from_date ==  $to_date  ) {
                  break;
                  }
              }?> 
                <tr>
                  <td> <span class = "form-control">出勤日数</span></td>
                  <td> <span class = "form-control"> <?php echo $workingdateall ?></span></td>
                </tr>
                <tr>
                  <td> <span class = "form-control">欠勤</span></td>
                  <td> <span class = "form-control"> <?php echo $workingdate ?></span></td>
                </tr>
                <tr>
                  <td> <span class = "form-control">振替休日</span></td>
                  <td> <span class = "form-control"> <?php echo $changeworking ?></span></td>
                </tr>
                <tr>
                  <td> <span class = "form-control">休日出勤</span></td>
                  <td> <span class = "form-control"> <?php echo $offworking ?></span></td>
                </tr>
                <tr>
                  <td> <span class = "form-control">早退 ・　遅刻</span></td>
                  <td> <span class = "form-control"> <?php echo $lateworking ?></span></td>
                </tr>
                <tr>
                  <td> <span class = "form-control">有給休暇</span></td>
                  <td> <span class = "form-control"> <?php echo $holiday ?></span></td>
                </tr>
                <tr>
                  <td> <span class = "form-control">特別休暇</span></td>
                  <td> <span class = "form-control"> <?php echo $holidaypay ?></span></td>
                </tr>
                <tr>
                  <td> <span class = "form-control">その他</span></td>
                  <td> <span class = "form-control"> <?php echo $otherday ?></span></td>
                </tr>

              <?php

          }
          
        } 

      ?>
      </tbody>
      </table>
    </div>
  </div>
</div>

</div>

<!-- /.container-fluid -->

<?php
include('includes/footer.php');
?>