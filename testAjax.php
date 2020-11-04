<?php
include('includes/security.inc.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Admin Profile </h6>
  </div>

  <div class="card-body">

    <div class="table-responsive">
      
      <div>
          <h2 id="messagedisplay1"></h2>
      </div>
      <form action="" id="vedformid" method="post">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            <th> Username </th>
            <th>Email </th>
            <th>button</th>
          </tr>
        </thead>
        <tbody>   
          <tr>
            <td> 1 </td>
            <td><input type="text" class ="form-control" name ="username" id="username"></td>
            <td> <input type="text" class ="form-control" name ="message" id ="email"></td>
            <td> <input type="submit" class ="form-control" name ="insertbtn" id ="insertbtn" value = "ADD DATA"></td>
          </tr>      
        </tbody>
      </table>
      </form>  
      <form action="" id="vedformid" method="post">
      <input type="submit" class ="form-control" name ="displaybtn" id ="displaybtn" value = "Display Data">
 
      <b id="messagedisplay2"></b>
     
      <div id="displaydata"></div>
      </form>  
    </div>
  </div>
</div>

</div>

<!-- /.container-fluid -->

<?php
include ('ajax.js');
include('includes/footer.php');
?>