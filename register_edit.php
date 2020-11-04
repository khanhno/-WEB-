<?php
include('includes/security.inc.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"> Edit Admin Profile </h6>
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
        
        $query  = "SELECT * FROM users WHERE ID = '$id'";
        $query_run = mysqli_query($con,$query);

        foreach($query_run as $row){

   ?>
        
        <form action="includes/signup.inc.php" method = "POST">
          <input type="hidden" name = "edit_id" value = "<?php echo $row['ID'] ?>" >
          <div class="form-group">
              <label> ユーザー名</label>
              <input type="text" name="edit_Username" value ="<?php echo $row['UName'] ?>" class="form-control" >
          </div>
          <div class="form-group">
              <label>メール</label>
              <input type="Email" name="edit_Email" value = "<?php echo $row['Email']?>" class="form-control" >
          </div>
          <div class="form-group">
              <label>パスワード</label>
              <input type="text" name="edit_Password" value ="<?php echo $row['Password'] ?>" class="form-control" >
          </div>
          <div class="form-group">
              <label>ユーザータイプ</label>
              <select name="update_usertype" class="form-control">
                <option value="admin">アドミン</option> 
                <option value="user">ユーザー</option>  
              </select>
          </div>
          <a href="register.php" class="btn btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">閉める</span>
                  </a>
          <button  type="submit" name="updatebtn" class="btn btn-success btn-icon-split"> <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">アップデート</span></button>
        </form>
       
    <?php
       
    }
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