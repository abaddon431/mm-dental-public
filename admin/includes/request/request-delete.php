<?php
    include_once '../../classes/autoloader.php';
    session_start();
    if($_SESSION['app_req_edit']==1)
    {
        if(isset($_POST["id"]))
        {
            $request_delete=new SchedController();
            $data=$request_delete->request_delete($_POST["id"]);
            $name=$data[0];
            $contact=$data[1];
            $get_settings=file_get_contents('../../settings.json');
            $settings=json_decode($get_settings,true);
            $acode=$settings['sms']['apicode'];
            $apass=$settings['sms']['password'];
            $apicode=$acode;
            $passwd=$apass;
            $message="Good day ".$name.", Unfortunately your appointment request has been denied, perhaps we can arrange your appointment on a different Date by requesting a new appoint. Thank you!\r\n - A message by Mary Mediatrix Dental Clinic Canlubang. \n This is an automated message, do not reply";
            $request_delete->send_sms_proper($contact,$message,$apicode,$passwd);
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