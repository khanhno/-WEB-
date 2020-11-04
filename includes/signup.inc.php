<?php
 session_start();
    require_once('dbh.inc.php');
    if(isset($_POST['btn-save']))
    {
        $UserName= mysqli_real_escape_string($con,$_POST['Username']);
        $Email= mysqli_real_escape_string($con,$_POST['Email']);
        $Password= mysqli_real_escape_string($con,$_POST['Password']);
        $CPassword= mysqli_real_escape_string($con,$_POST['Cpass']);
        $Usertype = mysqli_real_escape_string($con,$_POST['usertype']);

        if(empty($UserName)|| empty($Email) || empty($Password) || empty($CPassword))
        {
           
            $_SESSION['status'] = "すべての空白を埋めてください。";
            header("Location: ../register.php?error=emptyfield");
            exit();
        }else
        if ($Password != $CPassword)
        {   
            
            $_SESSION['status'] = "パスワードが一致しません。";
            header("Location: ../register.php?error=password-not-march");
            exit();
        }
        else
        {
            $sql_u = "SELECT * FROM users WHERE UName = '$UserName' ";
            $sql_e = "SELECT * FROM users WHERE Email = '$Email'";
            $res_u = mysqli_query($con,$sql_u) or die(mysqli_error($con));
            $res_e = mysqli_query($con,$sql_e) or die(mysqli_error($con));
            if(mysqli_num_rows($res_u) > 0){
               
                $_SESSION['status'] = "ユーザー名はすでに使用されています。";
                header("Location: ../register.php?error=Username-already-taken");
                exit();
            }else if(mysqli_num_rows($res_e) > 0){
               
                $_SESSION['status'] = "メールはすでに使用されています。";
                header("Location: ../register.php?error=Email-already-taken");
                exit();
            }else{
                $Pass = md5($Password);
                $sql = "insert into users(UName,Email,Password,Usertype) values('$UserName','$Email','$Pass','$Usertype')";
                $result = mysqli_query($con,$sql);
                if($result)
                {
                  
                    $_SESSION['success'] = "管理者プロファイルが追加されました。";
                    header("Location: ../register.php?Success=database-had-record");
                    exit();
                }
                else
                {
                   
                    $_SESSION['status'] = "管理者プロファイルは追加されていません。";
                    header("Location: ../register.php?error=database-not-record");
                    exit();
                }
                    
            }
            
        }
    }


    if(isset($_POST['updatebtn'])){

        $id = $_POST['edit_id'];
        $UserName = $_POST['edit_Username'];
        $Email = $_POST['edit_Email'];
        $Password = $_POST['edit_Password'];
        $Usertype = mysqli_real_escape_string($con,$_POST['update_usertype']);
        $Pass = md5($Password);
        $sql_u = "SELECT * FROM users WHERE UName = '$UserName' AND ID != '$id' ";
        $sql_e = "SELECT * FROM users WHERE Email = '$Email' AND ID != '$id'";
        $res_u = mysqli_query($con,$sql_u) or die(mysqli_error($con));
        $res_e = mysqli_query($con,$sql_e) or die(mysqli_error($con));
        if(mysqli_num_rows($res_u) > 0){
            
            $_SESSION['status'] = "ユーザー名はすでに使用されています。";
            header("Location: ../register.php?errorUpdate=Username-already-taken");
            exit();
        }else if(mysqli_num_rows($res_e) > 0){
               
            $_SESSION['status'] = "メールはすでに使用されています。";
            header("Location: ../register.php?errorUpdate=Email-already-taken");
            exit();
        }else{
            $query = "UPDATE users SET UName = '$UserName', Email='$Email', Password = '$Pass', Usertype = '$Usertype' WHERE ID ='$id' ";
            $query_run = mysqli_query($con,$query);
    
            if($query_run){
                
                $_SESSION['success'] = "データが更新されました";
                header("Location: ../register.php?Success=database-has-been-updated");
                exit();
            }
            else{
               
                $_SESSION['status'] = "データは更新されていません";
                header("Location: ../register.php?Error=database-has-not-been-updated");
                exit();
            }

        }
       
    }
    
    if(isset($_POST['delete_btn'])){
        $id = $_POST['delete_id'];
        $query = "DELETE  FROM users WHERE ID = '$id'";
        $query_run = mysqli_query($con,$query);

        if($query_run){
                
            $_SESSION['success'] = "データが削除されました";
            header("Location: ../register.php?Success=database-has-been-deleted");
            exit();
        }
        else{
           
            $_SESSION['status'] = "データは削除されていません";
            header("Location: ../register.php?Error=database-has-not-been-deleted");
            exit();
        }
    }