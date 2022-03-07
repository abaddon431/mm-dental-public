<?php
    include_once '../../classes/autoloader.php';
    session_start();
    if($_SESSION['sched_cal_edit']==1)
    {
        if(isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']))
        {
            $insert=new SchedController();
            $start=$_POST['start'];
            $initial=new DateTime($start);
            $calendar=$initial->format("Y-m-d");
            $hour=$initial->format("H");
            $minute=$initial->format("i");
            $set_span=3;
            
            $is_overlapped=$insert->check_overlap($calendar,$hour,$minute,$set_span);
            if((int)$is_overlapped!=0)
            {
                echo "There is a conflict on the desired time";
            }
            else
            {
                echo $insert->insert_new($_POST['fname'],$_POST['lname'],$_POST['contact'],$_POST['start'],$_POST['end']);
            }
            
        }else
        header('location: ../../admin/login.php');   
    }
    else
    {
        echo "You do not have access to this feature ";
    }
?>