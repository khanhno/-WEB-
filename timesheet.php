<?php
include('includes/security.inc.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>営業日追加</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/process.inc.php" method="POST">

        <div class="modal-body">
            <div class="form-group">
                <label><b>日付</b></label>
                <input type="date" name="pickDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
            </div>
            <div class="form-group">
                <label><b>始業時刻</b></label>
                <label for="starttime_hour"></label>
                <input type="text" name = "starttime_hour" id = "starttime_hour" size = "2" maxlength = "2">
                :
                <label for="starttime_minute"></label>
                <input type="text" name = "starttime_minute" id = "starttiem_minute" size = "2" maxlength= "2">
                <label for=""> 00:00 ~ 23:59 </label>
            </div>
            <div class="form-group">
                <label><b>終業時刻</b></label>
                <label for="endtime_hour"></label>
                <input type="text" name = "endtime_hour" id = "endtime_hour" size = "2" maxlength = "2">
                 :
                <label for="endtime_minute"></label>
                <input type="text" name = "endtime_minute" id = "endtiem_minute" size = "2" maxlength= "2">
                <label for=""> 00:00 ~ 23:59</label>
                </br>
                <label for=""></label>
                </br>
                <label for=""> <b>注意 1:</b> 始業時刻は終業時刻よりも長くする必要があります。</label>            
                <label for=""> <b>注意 2:</b> 始業時刻と終業時刻を同じにすることはできません。</label>            
            </div>
            <div class="form-group">
                <label><b>区分</b></label>
                <select class="form-control" name="diligence1">
                  <option value='平日'>平日</option>
                  <option value='休日'>休日</option>
                </select>
            </div>
            <div class="form-group">
                <label><b>事務内容</b></label>
                <label for="details"></label>
                <textarea class="form-control" name="comments" id="details" cols="40" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label><b>勤怠</b></label>
                <select class="form-control" name="diligence">
                  <option value='欠勤'>欠勤</option>
                  <option value='振替休日'>振替休日</option>
                  <option value='休日出勤'>休日出勤</option>
                  <option value='遅刻'>遅刻</option>
                  <option value='早退'>早退</option>
                  <option value='有給休暇'>有給休暇</option>
                  <option value='特別休暇'>特別休暇</option>
                  <option value='その他'>その他</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-icon-split" data-dismiss="modal">
            <span class="icon text-white-50">
              <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">閉める</span>
          </button>
          <button type="submit" name="add-time" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-check"></i>
            </span>
            <span class="text">保存</span>
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- /.container-fluid -->
<div class="container-fluid">

  <!-- Start Row -->
  <div class="row">
    <div class = "col-xl-2 col-lg-3 col-md-4">
      <div class="card shadow mb-4">
        <div class="card-header py-2">
          <h6 class="m-0 font-weight-bold text-primary">
            <button type="button" class="btn btn-primary  btn-block" data-toggle="modal" data-target="#addadminprofile">
              <span class="icon text-white-50">
                <i class="far fa-calendar-plus"></i>
              </span>
              <span class="text ">時間登録</span>
            </button>
          </h6>
        </div>
        <div class="card-body">
          <div class="">
            <table class="table table-bordered"width="100%" cellspacing="0">
              <col width="10">
              <col width="200">
                <tr style ="text-align: center;">
                  <th colspan="2">就業時間</th>
                </tr>
                <tr>
                  <th >平日</th>
                  <td>9 : 00 ~ 17 : 45</td>
                </tr>
                <tr style ="">
                  <th rowspan ="3"><p>休憩時間</p></th>
                  <td>12:00 ~ 13:00 ・ 60分 </td>
                </tr>
                <tr>
                  <td>17:45 ~ 18:15 ・ 30分 </td>
                </tr>
                <tr>
                  <td>&nbsp &nbsp&nbsp&nbsp:&nbsp &nbsp &nbsp&nbsp~&nbsp &nbsp &nbsp&nbsp:&nbsp &nbsp&nbsp </td>
                </tr>
                <tr style ="text-align: center;">
                  <th colspan="2">所定休日</th>
                </tr>
                <tr style ="text-align: center;">
                  <td colspan= "2">土曜日・日曜日・祝祭日</td>
                </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class = "col-xl-10 col-lg-9 col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h3 class="m-0 font-weight-bold text-primary">時間管理　
          </h3>
        </div>
        <div class="card-body">
          <?php
            if(isset( $_SESSION['success']) &&  $_SESSION['success'] != ''){
              echo '<h2 class ="text-success">'. $_SESSION['success'].'</h2>';
              unset( $_SESSION['success']);
            }  
            if(isset( $_SESSION['status']) &&  $_SESSION['status'] != ''){
              echo '<h2 class ="text-danger">'. $_SESSION['status'].'</h2>';
              unset( $_SESSION['status']);
            } 
            ?>
            <div class="table-responsive">
              <?php 
                $idUser = $_SESSION['UserID'];
                $query = "SELECT * FROM daysdb WHERE ID_User = '$idUser' ORDER BY ID DESC";
                $query_run = mysqli_query($con, $query);
              ?>
              <table class="table table-bordered" id="dataTable"  width="100%" cellspacing="0">
              <!-- id="dataTable" -->
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
                          "勤怠",
                          "編集",
                          "削除");
                            for($x = 0; $x <= 12;$x++){
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
                  if(mysqli_num_rows($query_run)>0){
                    while($row = mysqli_fetch_assoc($query_run)){
                      ?>
                        <tr>
                          <td><?php echo $row['pickDays']; ?> </td>
                          <td>
                            <?php
                              $days = array("日","月","火","水","木","金","土");
                              $japanday = $days[$row['dayofweek']];
                              echo $japanday;
                            ?> 
                          </td>
                          <td><?php echo $row['diligence1']; ?> </td>
                          <td><?php echo $row['timeStart']; ?></td>
                          <td><?php echo $row['timeEnd']; ?></td>
                          <td>
                            <?php
                              showTime($row['breakTime']);
                            ?>
                          </td>
                          <td><?php showTime($row['workTime']); ?></td>
                          <td><?php showTime($row['overTime']); ?></td>
                          <td><?php showTime($row['overTime2']); ?></td>
                        
                          <td><?php echo $row['comments']; ?></td>
                          <td><?php echo $row['diligence']; ?></td>
                          <td>
                              <form action="timesheet_edit.php" method="POST">
                                  <input type="hidden" name="edit_id" value="<?php echo $row['ID'];?>">
                                  <button  type="submit" name="edit_btn" class="btn btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                      <i class="fas fa-info-circle"></i>
                                    </span>
                                  </button>
                              </form>
                          </td>
                          <td>
                              <form action="includes/process.inc.php" method="post">
                                <input type="hidden" name="delete_id" value="<?php echo $row['ID'];?>">
                                <button type="submit" name="delete_btn" class="btn btn-danger btn-icon-split">
                                  <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                  </span>  
                                </button>
                              </form>
                          </td>
                        </tr>
                  <?php
                    }
                  }
                  else{
                    echo "<tr>No record Found</tr>";
                  }  
                ?>
              
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.end Row -->
</div>
<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>