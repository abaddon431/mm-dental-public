<?php
    include_once '../../classes/autoloader.php';
    session_start();
    if($_SESSION['sched_cal_edit']==1)
    {
        if(isset($_POST['id'])){
            $remove=new DBOpController();
            $data=$remove->schedule_remove($_POST['id']);
            
        }else
        header('location: ../../admin/login.php');
    }
    else
    {
        echo "You do not have access to this feature ";
    }
?>