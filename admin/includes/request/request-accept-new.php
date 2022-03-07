<?php
    include_once '../../classes/autoloader.php';
    session_start();
    if($_SESSION['app_req_edit']==1)
    {
        if(isset($_POST['req_id']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['start_event']) && isset($_POST['end_event']))
        {
            $request_accept=new SchedController();
            $start=$_POST['start_event'];
            $initial=new DateTime($start);
            $calendar=$initial->format("Y-m-d");
            $hour=$initial->format("H");
            $minute=$initial->format("i");
            $set_span=3;
            
            $is_overlapped=$request_accept->check_overlap($calendar,$hour,$minute,$set_span);
            
            if((int)$is_overlapped!=0)
            {
                echo "There is a conflict on the desired time";
            }
            else
            {
                echo $request_accept->accept_new($_POST['req_id'],$_POST['fname'],$_POST['lname'],$_POST['start_event'],$_POST['end_event'],$_POST['contact']);
                if(isset($_POST['notify']))
                {
                    $get_settings=file_get_contents('../../settings.json');
                    $settings=json_decode($get_settings,true);
                    $acode=$settings['sms']['apicode'];
                    $apass=$settings['sms']['password'];
                    $apicode=$acode;
                    $passwd=$apass;
                    $contact=$_POST['contact'];
                    $date=date("F j, g:i a",strtotime($_POST['start_event']));
                    $message="Good day ".$_POST['fname']." ".$_POST['lname'].", Your appointment has been accepted and is scheduled on ".$date."\r\n - A message by Mary Mediatrix Dental Clinic Canlubang. \n This is an automated message, do not reply";
                    $request_accept->send_sms_proper($contact,$message,$apicode,$passwd);
                }
            }
        }else
        header('location: ../../admin/login.php');   
    }
    else
    {
        echo "You do not have access to this feature ";
    }
?>