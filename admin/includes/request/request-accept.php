<?php
    include_once '../../classes/autoloader.php';
    session_start();
    if($_SESSION['app_req_edit']==1)
    {
        if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['start_event']) && isset($_POST['end_event']))
        {
            $request_accept=new SchedController();
            $req_param=new EventParams();
            $req_param->id_event=$_POST['id'];
            $req_param->title_event=$_POST['name'];
            $req_param->start_event=$_POST['start_event'];
            $req_param->end_event=$_POST['end_event'];
            $request_accept->request_accept($req_param);
    
            if(isset($_POST['notify']))
            {
                $get_settings=file_get_contents('../../settings.json');
                $settings=json_decode($get_settings,true);
                $acode=$settings['sms']['apicode'];
                $apass=$settings['sms']['password'];
                $apicode=$acode;
                $passwd=$apass;
                $contact=$_POST['contactno'];
                $date=date("F j, g:i a",strtotime($_POST['start_event']));
                $message=$req_param->title_event.", Your appointment is scheduled on ".$date."\r\nA message by test";
                $request_accept->send_sms_proper($contact,$message,$apicode,$passwd);
            }
        }
        else
        header('location: ../../admin/login.php');
    }
    else
    {
        echo '
            <div class="container-fluid">
                <div class="row">
                    <div class="text-uppercase fw-bold">
                        You do not have access to this feature 
                    </div>
                </div>
            </div>';
    }
   
?>