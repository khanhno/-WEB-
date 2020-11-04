<?php
 session_start();
require_once('dbh.inc.php');
if(isset($_POST['add-time'])){
    $id = $_SESSION['UserID'];
    $starttime = $_POST['starttime_hour'].":".$_POST['starttime_minute'];
    $endtime = $_POST['endtime_hour'].":".$_POST['endtime_minute'];
    $pickDate = $_POST['pickDate'];   
    $dayofweek = date('w', strtotime($pickDate));
    $comments  = $_POST['comments'];
    $diligence1  = $_POST['diligence1'];
    $diligence  = $_POST['diligence'];

    $sql_u = "SELECT * FROM daysdb WHERE pickDays = '$pickDate' AND ID_User = '$id' ";
    $res_u = mysqli_query($con,$sql_u) or die(mysqli_error($con));
    if(mysqli_num_rows($res_u) > 0){
               
        //echo "That is the same date";
        $_SESSION['status'] = "現在の日付はすでにデータに含まれています。";
        header("Location: ../timesheet.php?Error=The-day-has-been-added");
        exit();
    }
    if(preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $starttime)){
           
    }else{
        $_SESSION['status'] ="時間は一致していません。";
        header('Location: ../timesheet.php?Error=the-time-has-not-match');
        exit();
    }

    if(preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $endtime)){
    }
    else{
        $_SESSION['status'] ="時間は一致していません。";
        header('Location: ../timesheet.php?Error=the-time-has-not-match');
        exit();
    }
    if (strtotime( $endtime) < strtotime( $starttime)){
        $_SESSION['status'] ="始業時刻は終業時刻よりも長くする必要があります。";
        header('Location: ../timesheet.php?Error=the-time-is-wrong');
        exit();
    }
    echo '<a href="../timesheet.php">back home</a>';
    echo "</br>";
    echo 'Start time: '.$starttime;
    echo "</br>";
    echo 'End Time: '.$endtime;
    echo "</br>";
    $days = array("日","月","火","水","木","金","土");
    $japanday = $days[$dayofweek];
    $allworktime = strtotime( $endtime)-strtotime( $starttime);
    function checkWorkingTime1($a){
        $result = false;
        if ($a >= strtotime("12:00") && $a <=strtotime("13:00") ){
            $result = true;
        }
        return $result;
    }
    function checkWorkingTime2($a){
        $result = false;
        if ($a >= strtotime("17:45") && $a <= strtotime("18:15") ){
            $result = true;
        }
        return $result;
    }
    function calculateTime(){

    }
    if($diligence1 =='平日'){
        function caculateTime($n){
            $hour = floor($n/3600);
            $minutes = floor(($n/60)%60);
            return "$hour:$minutes";
        }if(strtotime( $starttime) == strtotime( $endtime)){
            $_SESSION['status'] ="開始時間と終了時間を 00:00 にすることはできません。";
            header('Location: ../timesheet.php?Error=time-is-wrong');
            exit();
        }
        else if (checkWorkingTime1(strtotime( $endtime)) === true){
            $breakTime = strtotime( $endtime)-strtotime("12:00");
            $workTime = $allworktime - $breakTime;

            echo "thang leo nay lam toi 12h00";echo "</br>";
            // echo caculateTime($allworktime);echo "</br>";
            // echo caculateTime($breakTime);echo "</br>";
            // echo caculateTime($workTime);echo "</br>";
            
        }
        else if(checkWorkingTime1(strtotime( $starttime)) === true){

            $breakTime = strtotime("13:00")-strtotime($starttime);
            $workTime = $allworktime - $breakTime;

            echo "thang leo nay bat dau lam tu 13h00";echo "</br>";

            if(strtotime( $endtime) < strtotime("17:45")){

                echo "thang leo ve truoc 17h45"; echo "</br>";

                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }else if (checkWorkingTime2(strtotime( $endtime)) === true){

                echo "thang leo nay lam toi gio kyukei";echo "</br>";

                $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                $workTime = $allworktime - $breakTime;
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }
            else{
                echo "thang leo nay lam qua gio ";echo "</br>";

                $breakTime = 1800; 
                $workTime = 17100;
                $overTime = $allworktime - $breakTime - $workTime;

                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                // echo caculateTime($overTime);echo "</br>";
            }
            
        }else if (checkWorkingTime2(strtotime( $starttime)) === true){

            echo "thang leo nay bat dau lam tu truoc 18h15";echo "</br>";
            $breakTime = strtotime("18:15")-  strtotime( $starttime);
            $workTime = $allworktime - $breakTime;
             
            // echo caculateTime($allworktime);echo "</br>";
            // echo caculateTime($breakTime);echo "</br>";
            // echo caculateTime($workTime);echo "</br>";

        } else if(strtotime( $starttime) > strtotime("18:15")){
            echo "thang leo nay lam sau 18h15";echo "</br>";
            $breakTime = 0;
            $workTime = $allworktime;
            echo caculateTime($breakTime);echo "</br>";
             echo caculateTime($workTime);echo "</br>";
        }
        else{
            $breakTime = 3600;
            $workTime = strtotime( $endtime) -  $breakTime - strtotime( $starttime);

            echo "thang leo nay lam trong khoang thoi gian dung";echo "</br>";
            if (checkWorkingTime2(strtotime( $endtime)) === true){

                echo "thang leo nay lam toi gio kyukei";echo "</br>";

                $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                $workTime = $allworktime - $breakTime;
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }else if(strtotime( $endtime) < strtotime("17:45")){

                echo "thang leo ve truoc 17h45"; echo "</br>";

                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }
            else{
                echo "thang leo nay lam qua gio ";echo "</br>";

                $breakTime = 5400; 
                $workTime = 17100 + (strtotime("12:00")-strtotime($starttime)) ;
                $overTime = $allworktime - $breakTime - $workTime;
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                // echo caculateTime($overTime);echo "</br>";
            }
        }  
    }
    else{
        if($dayofweek == 0){

            echo "day la ngay cn le di lam ";echo "</br>";
            function caculateTime($n){
                $hour = floor($n/3600);
                $minutes = floor(($n/60)%60);
                return "$hour:$minutes";
            }
            if (checkWorkingTime1(strtotime( $endtime)) === true){
                $breakTime = strtotime( $endtime)-strtotime("12:00");
                $overTime2 = $allworktime - $breakTime;
    
                echo "thang leo nay lam toi 12h00";echo "</br>";
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                
            }
            else if(checkWorkingTime1(strtotime( $starttime)) === true){
    
                $breakTime = strtotime("13:00")-strtotime($starttime);
                $overTime2 = $allworktime - $breakTime;
    
                echo "thang leo nay bat dau lam tu 13h00";echo "</br>";
    
                if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
                }else if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime2 = $allworktime - $breakTime;
    
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 1800; 
                    $workTime = 17100;
                    $overTime2 = $allworktime - $breakTime + $workTime;
    
                }
                
            }
            else if (checkWorkingTime2(strtotime( $starttime)) === true){

                echo "thang leo nay bat dau lam tu truoc 18h15";echo "</br>";
                $breakTime = strtotime("18:15")-  strtotime( $starttime);
                $overTime2 = $allworktime - $breakTime;
                
                
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
    
            }
            else if(strtotime( $starttime) > strtotime("18:15")){
                echo "thang leo nay lam sau 18h15";echo "</br>";
                $breakTime = 0;
                $overTime2 = $allworktime;
                echo caculateTime($breakTime);echo "</br>";
                 echo caculateTime($overTime2);echo "</br>";
            } 
            else{
                $breakTime = 3600;
                $overTime2 = strtotime( $endtime) -  $breakTime - strtotime( $starttime);
    
                echo "thang leo nay lam trong khoang thoi gian dung";echo "</br>";
                if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime2 = $allworktime - $breakTime;
                 
                }else if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
               
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 5400; 
                    $workTime = 17100 + (strtotime("12:00")-strtotime($starttime)) ;
                    $overTime2 = $allworktime - $breakTime + $workTime;
                
                }
            }  
          
        }
        else{
            echo "day la ngay le tuw thuw 2 towi thu 7";echo "</br>";
            function caculateTime($n){
                $hour = floor($n/3600);
                $minutes = floor(($n/60)%60);
                return "$hour:$minutes";
            }
            if (checkWorkingTime1(strtotime( $endtime)) === true){
                $breakTime = strtotime( $endtime)-strtotime("12:00");
                $overTime = $allworktime - $breakTime;
    
                echo "thang leo nay lam toi 12h00";echo "</br>";
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                
            }
            else if(checkWorkingTime1(strtotime( $starttime)) === true){
    
                $breakTime = strtotime("13:00")-strtotime($starttime);
                $overTime = $allworktime - $breakTime;
    
                echo "thang leo nay bat dau lam tu 13h00";echo "</br>";
    
                if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
                }else if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime = $allworktime - $breakTime;
    
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 1800; 
                    $workTime = 17100;
                    $overTime = $allworktime - $breakTime + $workTime;
    
                }
                
            }
            else if (checkWorkingTime2(strtotime( $starttime)) === true){

                echo "thang leo nay bat dau lam tu truoc 18h15";echo "</br>";
                $breakTime = strtotime("18:15")-  strtotime( $starttime);
                $overTime= $allworktime - $breakTime;
                
                
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
    
            }
            else if(strtotime( $starttime) > strtotime("18:15")){
                echo "thang leo nay lam sau 18h15";echo "</br>";
                $breakTime = 0;
                $overTime = $allworktime;
                // echo caculateTime($breakTime);echo "</br>";
                //  echo caculateTime($overTime);echo "</br>";
            }
            
            else{
                $breakTime = 3600;
                $overTime = strtotime( $endtime) -  $breakTime - strtotime( $starttime);
    
                echo "thang leo nay lam trong khoang thoi gian dung";echo "</br>";
                if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime = $allworktime - $breakTime;
                 
                }else if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
               
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 5400; 
                    $workTime = 17100 + (strtotime("12:00")-strtotime($starttime)) ;
                    $overTime = $allworktime - $breakTime + $workTime;
                
                }
            }  
        }

    }
     

    $query = "INSERT INTO daysdb (ID_User,pickDays,dayofweek,diligence1,timeStart,timeEnd,breakTime,workTime,overTime,overTime2,comments,diligence) VALUES ('$id','$pickDate','$dayofweek','$diligence1','$starttime','$endtime','$breakTime','$workTime','$overTime','$overTime2','$comments','$diligence')";
    $query_run = mysqli_query($con,$query);

    if($query_run){
        $_SESSION['success'] ="就業時間が追加されました。";
        header('Location: ../timesheet.php?Success=timesheet-has-been-added');
        exit();
    }
    else{
        $_SESSION['status'] ="就業時間は追加されていません。";
        header('Location: ../timesheet.php?Error=timesheet-has-not-been-added');
        exit();
    }

 
}
if(isset($_POST['updatebtn'])){
    $pickDate = $_POST['edit_date'];
    $id = $_POST['edit_id'];
    $starttime = $_POST['edit_starttime_hour'].":".$_POST['edit_starttime_minute'];
    $endtime = $_POST['edit_endtime_hour'].":".$_POST['edit_endtime_minute'];
    $comments  = $_POST['edit_comments'];
    $diligence1  = $_POST['edit_diligence1'];
    $diligence  = $_POST['edit_diligence'];
    if(preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $starttime)){
           
    }else{
        $_SESSION['status'] ="時間は一致していません。";
        header('Location: ../timesheet.php?Error=the-time-has-not-match');
        exit();
    }

    if(preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $endtime)){
    }
    else{
        $_SESSION['status'] ="時間は一致していません。";
        header('Location: ../timesheet.php?Error=the-time-has-not-match');
        exit();
    }
    if (strtotime( $endtime) < strtotime( $starttime)){
        $_SESSION['status'] ="始業時刻は終業時刻よりも長くする必要があります。";
        header('Location: ../timesheet.php?Error=the-time-is-wrong');
        exit();
    }
    $days = array("日","月","火","水","木","金","土");
    $japanday = $days[$dayofweek];
    $allworktime = strtotime( $endtime)-strtotime( $starttime);
    function checkWorkingTime1($a){
        $result = false;
        if ($a >= strtotime("12:00") && $a <=strtotime("13:00") ){
            $result = true;
        }
        return $result;
    }
    function checkWorkingTime2($a){
        $result = false;
        if ($a >= strtotime("17:45") && $a <= strtotime("18:15") ){
            $result = true;
        }
        return $result;
    }
    function calculateTime(){

    }
    if($diligence1 =='平日'){
        function caculateTime($n){
            $hour = floor($n/3600);
            $minutes = floor(($n/60)%60);
            return "$hour:$minutes";
        }if(strtotime( $starttime) == strtotime( $endtime)){
            $_SESSION['status'] ="開始時間と終了時間を 00:00 にすることはできません。";
            header('Location: ../timesheet.php?Error=time-is-wrong');
            exit();
        }
        else if (checkWorkingTime1(strtotime( $endtime)) === true){
            $breakTime = strtotime( $endtime)-strtotime("12:00");
            $workTime = $allworktime - $breakTime;

            echo "thang leo nay lam toi 12h00";echo "</br>";
            // echo caculateTime($allworktime);echo "</br>";
            // echo caculateTime($breakTime);echo "</br>";
            // echo caculateTime($workTime);echo "</br>";
            
        }
        else if(checkWorkingTime1(strtotime( $starttime)) === true){

            $breakTime = strtotime("13:00")-strtotime($starttime);
            $workTime = $allworktime - $breakTime;

            echo "thang leo nay bat dau lam tu 13h00";echo "</br>";

            if(strtotime( $endtime) < strtotime("17:45")){

                echo "thang leo ve truoc 17h45"; echo "</br>";

                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }else if (checkWorkingTime2(strtotime( $endtime)) === true){

                echo "thang leo nay lam toi gio kyukei";echo "</br>";

                $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                $workTime = $allworktime - $breakTime;
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }
            else{
                echo "thang leo nay lam qua gio ";echo "</br>";

                $breakTime = 1800; 
                $workTime = 17100;
                $overTime = $allworktime - $breakTime - $workTime;

                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                // echo caculateTime($overTime);echo "</br>";
            }
            
        }else if (checkWorkingTime2(strtotime( $starttime)) === true){

            echo "thang leo nay bat dau lam tu truoc 18h15";echo "</br>";
            $breakTime = strtotime("18:15")-  strtotime( $starttime);
            $workTime = $allworktime - $breakTime;
             
            // echo caculateTime($allworktime);echo "</br>";
            // echo caculateTime($breakTime);echo "</br>";
            // echo caculateTime($workTime);echo "</br>";

        } else if(strtotime( $starttime) > strtotime("18:15")){
            echo "thang leo nay lam sau 18h15";echo "</br>";
            $breakTime = 0;
            $workTime = $allworktime;
            echo caculateTime($breakTime);echo "</br>";
             echo caculateTime($workTime);echo "</br>";
        }
        else{
            $breakTime = 3600;
            $workTime = strtotime( $endtime) -  $breakTime - strtotime( $starttime);

            echo "thang leo nay lam trong khoang thoi gian dung";echo "</br>";
            if (checkWorkingTime2(strtotime( $endtime)) === true){

                echo "thang leo nay lam toi gio kyukei";echo "</br>";

                $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                $workTime = $allworktime - $breakTime;
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }else if(strtotime( $endtime) < strtotime("17:45")){

                echo "thang leo ve truoc 17h45"; echo "</br>";

                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
            }
            else{
                echo "thang leo nay lam qua gio ";echo "</br>";

                $breakTime = 5400; 
                $workTime = 17100 + (strtotime("12:00")-strtotime($starttime)) ;
                $overTime = $allworktime - $breakTime - $workTime;
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                // echo caculateTime($overTime);echo "</br>";
            }
        }  
    }
    else{
        if($dayofweek == 0){

            echo "day la ngay cn le di lam ";echo "</br>";
            function caculateTime($n){
                $hour = floor($n/3600);
                $minutes = floor(($n/60)%60);
                return "$hour:$minutes";
            }
            if (checkWorkingTime1(strtotime( $endtime)) === true){
                $breakTime = strtotime( $endtime)-strtotime("12:00");
                $overTime2 = $allworktime - $breakTime;
    
                echo "thang leo nay lam toi 12h00";echo "</br>";
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                
            }
            else if(checkWorkingTime1(strtotime( $starttime)) === true){
    
                $breakTime = strtotime("13:00")-strtotime($starttime);
                $overTime2 = $allworktime - $breakTime;
    
                echo "thang leo nay bat dau lam tu 13h00";echo "</br>";
    
                if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
                }else if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime2 = $allworktime - $breakTime;
    
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 1800; 
                    $workTime = 17100;
                    $overTime2 = $allworktime - $breakTime + $workTime;
    
                }
                
            }
            else if (checkWorkingTime2(strtotime( $starttime)) === true){

                echo "thang leo nay bat dau lam tu truoc 18h15";echo "</br>";
                $breakTime = strtotime("18:15")-  strtotime( $starttime);
                $overTime2 = $allworktime - $breakTime;
                
                
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
    
            }
            else if(strtotime( $starttime) > strtotime("18:15")){
                echo "thang leo nay lam sau 18h15";echo "</br>";
                $breakTime = 0;
                $overTime2 = $allworktime;
                echo caculateTime($breakTime);echo "</br>";
                 echo caculateTime($overTime2);echo "</br>";
            } 
            else{
                $breakTime = 3600;
                $overTime2 = strtotime( $endtime) -  $breakTime - strtotime( $starttime);
    
                echo "thang leo nay lam trong khoang thoi gian dung";echo "</br>";
                if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime2 = $allworktime - $breakTime;
                 
                }else if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
               
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 5400; 
                    $workTime = 17100 + (strtotime("12:00")-strtotime($starttime)) ;
                    $overTime2 = $allworktime - $breakTime + $workTime;
                
                }
            }  
          
        }
        else{
            echo "day la ngay le tuw thuw 2 towi thu 7";echo "</br>";
            function caculateTime($n){
                $hour = floor($n/3600);
                $minutes = floor(($n/60)%60);
                return "$hour:$minutes";
            }
            if (checkWorkingTime1(strtotime( $endtime)) === true){
                $breakTime = strtotime( $endtime)-strtotime("12:00");
                $overTime = $allworktime - $breakTime;
    
                echo "thang leo nay lam toi 12h00";echo "</br>";
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
                
            }
            else if(checkWorkingTime1(strtotime( $starttime)) === true){
    
                $breakTime = strtotime("13:00")-strtotime($starttime);
                $overTime = $allworktime - $breakTime;
    
                echo "thang leo nay bat dau lam tu 13h00";echo "</br>";
    
                if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
                }else if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime = $allworktime - $breakTime;
    
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 1800; 
                    $workTime = 17100;
                    $overTime = $allworktime - $breakTime + $workTime;
    
                }
                
            }
            else if (checkWorkingTime2(strtotime( $starttime)) === true){

                echo "thang leo nay bat dau lam tu truoc 18h15";echo "</br>";
                $breakTime = strtotime("18:15")-  strtotime( $starttime);
                $overTime= $allworktime - $breakTime;
                
                
                // echo caculateTime($allworktime);echo "</br>";
                // echo caculateTime($breakTime);echo "</br>";
                // echo caculateTime($workTime);echo "</br>";
    
            }
            else if(strtotime( $starttime) > strtotime("18:15")){
                echo "thang leo nay lam sau 18h15";echo "</br>";
                $breakTime = 0;
                $overTime = $allworktime;
                // echo caculateTime($breakTime);echo "</br>";
                //  echo caculateTime($overTime);echo "</br>";
            }
            
            else{
                $breakTime = 3600;
                $overTime = strtotime( $endtime) -  $breakTime - strtotime( $starttime);
    
                echo "thang leo nay lam trong khoang thoi gian dung";echo "</br>";
                if (checkWorkingTime2(strtotime( $endtime)) === true){
    
                    echo "thang leo nay lam toi gio kyukei";echo "</br>";
    
                    $breakTime += (strtotime( $endtime)-strtotime("17:45"));
                    $overTime = $allworktime - $breakTime;
                 
                }else if(strtotime( $endtime) < strtotime("17:45")){
    
                    echo "thang leo ve truoc 17h45"; echo "</br>";
    
               
                }
                else{
                    echo "thang leo nay lam qua gio ";echo "</br>";
    
                    $breakTime = 5400; 
                    $workTime = 17100 + (strtotime("12:00")-strtotime($starttime)) ;
                    $overTime = $allworktime - $breakTime + $workTime;
                
                }
            }  
        }

    }
    $query = "UPDATE daysdb SET timeStart ='$starttime',timeEnd ='$endtime',breakTime = '$breakTime',workTime = '$workTime',overTime = '$overTime',comments = '$comments' WHERE ID ='$id'";
    $query_run = mysqli_query($con,$query);

    if($query_run){
        $_SESSION['success'] = $pickDate." のデータが更新されました";
        header('Location: ../timesheet.php?Success=timesheet-has-been-updated');
        exit();
    }
    else{
        $_SESSION['status'] ="";
        header('Location: ../timesheet.php?Error=timesheet-has-not-been-updated');
        exit();
    }

}

if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    $query = "DELETE  FROM daysdb WHERE ID = '$id'";
    $query_run = mysqli_query($con,$query);

    if($query_run){
            
        $_SESSION['success'] = "データが削除されました";
        header("Location: ../timesheet.php?Success=database-has-been-deleted");
        exit();
    }
    else{
       
        $_SESSION['status'] = "データは削除されていません";
        header("Location: ../timesheet.php?Error=database-has-not-been-deleted");
        exit();
    }
}


?>

