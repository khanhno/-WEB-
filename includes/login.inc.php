<?php
    require_once('dbh.inc.php');
    if(isset($_POST['btn-login']))
    {
        $UName = $_POST['Username'];
        $Pass = $_POST['Password'];
    }
        
    if(empty($UName)|| empty($Pass))
    {

        // echo 'Please fill in the blanks';
        header("Location: ../index.php?error=emptyfields");
        
    }
    else
    {
        $query = "select * from users where UName='$UName'";
        $result = mysqli_query($con,$query);
        

        if($row = mysqli_fetch_assoc($result))
        {
            $db_password = $row['Password'];
            if (md5($Pass)== $db_password)
            {
                session_start();
                $_SESSION['Usertype'] = $row['Usertype'];
                $_SESSION['UserID'] = $row['ID'];
                $_SESSION['Username'] = $row['UName'];
                header("Location: ../index.php?loginsucess");
            }
            else
            {
                header("Location: ../index.php?error=wrongpass");
            }
        }
        else
        {
            header("Location: ../index.php?error=no-user");
        }
    }



?>