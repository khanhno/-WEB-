<?php
include('includes/security.inc.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ユーザー登録</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="includes/signup.inc.php" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> ユーザー名 </label>
                <input type="text" name="Username" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>メール</label>
                <input type="Email" name="Email" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="Password" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>パスワード確認</label>
                <input type="password" name="Cpass" class="form-control" placeholder="">
            </div>
            <div class = "form-group">
                <label for=""> ユーザータイプ</label>
                <select class="form-control" name="usertype">
                  <option value='admin'>アドミン</option>
                  <option value='user'>ユーザー</option>
                  </select>
            </div>
            <!-- <input type="hidden" name = "usertype" value = "admin"> -->
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-icon-split" data-dismiss="modal">
              <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
              </span>
              <span class="text">閉める</span>
            </button>
            <button type="submit" name="btn-save" class="btn btn-primary btn-icon-split">
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


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h3 class="m-0 font-weight-bold text-primary">全体ユーサー 
     <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addadminprofile">
      <span class="icon text-white-50">
        <i class="fas fa-user-plus"></i>
      </span>
      <span class="text">ユーザー登録</span>
     </button>
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
        require_once('includes/dbh.inc.php');
        $query = "SELECT * FROM users ORDER BY Usertype ";
        $query_run = mysqli_query($con, $query);

    ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
          <?php
            $array = array(
              "ユーザー名",
              "メール",
              "ユーザータイプ",
              "パスワード",
              "編集",
              "削除"
            );
            for($x = 0 ; $x < 6 ; $x++){
              echo '<th>'.$array[$x].'</th>';
            }
          ?>
          </tr>
        </thead>
        <tbody>
        <?php
          if (mysqli_num_rows($query_run) > 0 ){
              while($row = mysqli_fetch_assoc($query_run)){
        ?>
          <tr>
            <td> <?php echo $row['UName']; ?></td>
            <td> <?php echo $row['Email']; ?></td>
            <td> <?php echo $row['Usertype']; ?></td>
            <td> <?php echo $row['Password']; ?></td>
            <td>
                <form action="register_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['ID'];?>">
                    <button  type="submit" name="edit_btn" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-info-circle"></i>
                    </span>
                    <span class="text">編集</span></button>
                </form>
            </td>

            <td>
                <form action="includes/signup.inc.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['ID'];?>">
                  <button type="submit" name="delete_btn" class="btn btn-danger btn-icon-split"> <span class="icon text-white-50">
                      <i class="fas fa-trash"></i>
                    </span>
                    <span class="text">削除</span></button>
                </form>
            </td>
          </tr>
          <?php
                
              }

          }else{
              echo "No Record Found";
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
include('includes/scripts.php');
include('includes/footer.php');
?>