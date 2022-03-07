<?php
    include_once '../../classes/autoloader.php';
    session_start();
    if($_SESSION['sched_cal_edit']==1)
    {
        if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']))
        {
            $update = new SchedController();
            $e_params=new EventParams();
            $e_params->title_event=$_POST['title'];
            $e_params->id_event=$_POST['id'];
            $e_params->start_event=$_POST['start'];
            $e_params->end_event=$_POST['end'];
            $id=$_POST['id'];
            $start=$e_params->start_event;

            $initial=new DateTime($start);
            $end=new DateTime($_POST['end']);

            $calendar=$initial->format("Y-m-d");
            $hour=$initial->format("H");
            $minute=$initial->format("i");

            $endcalendar=$end->format("Y-m-d");
            $endhour=$end->format("H");
            $endminute=$end->format("i");
            $set_span=3;
            
            $is_overlapped=$update->update_overlap($id,$calendar,$hour,$minute,$endcalendar,$endhour,$endminute,$set_span);
            
            if((int)$is_overlapped!=0)
            {
                echo "There is a conflict on the desired time";
            }
            else
            {
                $update->update_event($e_params);
            }
            
        }else
        header('location: ../../admin/login.php');
    }
    else
    {
        echo "You do not have access to this feature ";
    }
?>

