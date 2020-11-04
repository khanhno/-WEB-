<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
  </div>

  <!-- Content Row -->
  <div class="row">
<?php
    if($_SESSION['Usertype'] == "admin"){
     ?>
      <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h4 font-weight-bold text-warning text-uppercase mb-1">総登録管理者</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">

               <h4>管理者: <?phP
                  require_once("includes/dbh.inc.php");
                  $query = "SELECT ID FROM users where Usertype = 'admin' ORDER BY id";
                  $query_run = mysqli_query($con,$query);

                  $row = mysqli_num_rows($query_run);
                  
                  echo $row.'人';      
                  ?>        
              </h4>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h4 font-weight-bold text-success mb-1">全ての登録ユーザー</div>
              <div class="h4 mb-0 text-gray-800">
              ユーザー: <?phP
                  require_once("includes/dbh.inc.php");
                  $query = "SELECT ID FROM users where Usertype = 'user' ORDER BY id";
                  $query_run = mysqli_query($con,$query);

                  $row = mysqli_num_rows($query_run);
                  
                 echo $row.'人';     
                  ?>        
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-friends fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h4 font-weight-bold text-danger mb-1">全従業員の就業日数</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h4 mb-0 text-gray-800">
                  日数 :
                  <?phP
                  require_once("includes/dbh.inc.php");
                  $idUser = $_SESSION['UserID'];
                  $query = "SELECT * FROM daysdb ORDER BY ID";
                  $query_run = mysqli_query($con, $query);
                  $row = mysqli_num_rows($query_run);
                  echo $row;      
                  ?>        
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
      
      <?php
    }
?>

    

    <!-- Earnings (Monthly) Card Example -->
    
    

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h4 font-weight-bold text-info text-uppercase mb-1">総日勤</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h4 text-gray-800">
                  日数 :
                  <?phP
                      require_once("includes/dbh.inc.php");
                      $idUser = $_SESSION['UserID'];
                      $query = "SELECT * FROM daysdb WHERE ID_User = '$idUser' ORDER BY ID";
                      $query_run = mysqli_query($con, $query);
                      $row = mysqli_num_rows($query_run);
                      echo $row;      
                  ?>        
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>