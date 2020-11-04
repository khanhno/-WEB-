<?php
include('includes/security.inc.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"> Edit time </h6>
  </div>
    
  <div class="card-body">
  <?php
    if(isset( $_SESSION['status']) &&  $_SESSION['status'] != ''){
      echo '<h2>'. $_SESSION['status'].'</h2>';
      unset( $_SESSION['status']);
    } 
  ?>
 <?php
    require_once('includes/dbh.inc.php');
    if(isset($_POST['edit_btn'])){
        $id = $_POST['edit_id'];
        $query  = "SELECT * FROM daysdb WHERE ID = '$id'";
        $query_run = mysqli_query($con,$query);

        foreach($query_run as $row){

   ?>
        
        <form action="includes/process.inc.php" method = "POST">
          <input type="hidden" name = "edit_id" value = "<?php echo $row['ID'] ?>" >
          <input type="hidden" name = "edit_date" value = "<?php echo $row['pickDays'] ?>" >
          <div class="form-group">
            <label><b>始業時刻</b></label>
                <label for="starttime_hour"></label>
                <input type="text" name = "edit_starttime_hour" id = "edit_starttime_hour" size = "2" maxlength = "2" value="">
                :
                <label for="starttime_minute"></label>
                <input type="text" name = "edit_starttime_minute" id = "edit_starttime_minute" size = "2" maxlength= "2">
                <label for=""> 00:00 ~ 23:59</label>  
          </div>
          <div class="form-group">
          <label><b>終業時刻</b></label>
                <label for="endtime_hour"></label>
                <input type="text" name = "edit_endtime_hour" id = "edit_endtime_hour" size = "2" maxlength = "2">
                :
                <label for="starttime_minute"></label>
                <input type="text" name = "edit_endtime_minute" id = "edit_endtime_minute" size = "2" maxlength= "2">
                <label for=""> 00:00 ~ 23:59</label>
                </br>
                <label for=""></label>
                </br>
                <label for=""> <b>注意 1:</b> 始業時刻は終業時刻よりも長くする必要があります。</label>  
                </br>          
                <label for=""> <b>注意 2:</b> 始業時刻と終業時刻を同じにすることはできません。</label>      
          </div>
          <div class="form-group">
                <label><b>区分</b></label>
                <select class="form-control" name="edit_diligence1">
                  <option value='平日'>平日</option>
                  <option value='休日'>休日</option>
                </select>
            </div>
            <div class="form-group">
                <label><b>事務内容</b></label>
                <label for="details"></label>
                <textarea class="form-control" name="edit_comments" id="details" cols="40" rows="4"><?php echo $row['comments'] ?></textarea>
            </div>
            <div class="form-group">
                <label><b>勤怠</b></label>
                <select class="form-control" name="edit_diligence">
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
            <button type="button" onclick="history.back()" class="btn btn-secondary btn-icon-split" data-dismiss="modal">
            <span class="icon text-white-50">
              <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">閉める</span>
          </button>
          <button type="submit" name="updatebtn" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-check"></i>
            </span>
            <span class="text">アップデート</span>
          </button>
        </form>
    <?php
    }
}
else{
    echo "fack offf";
}
    ?>
  </div>
  </div>
</div>

</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>