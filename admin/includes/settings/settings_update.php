<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if(isset($_POST['save']))
    {
        $get_settings=file_get_contents('../../settings.json');
        $settings=json_decode($get_settings,true);
        $settings['sms']['apicode']=$_POST['apicode'];
        $settings['sms']['password']=$_POST['apipasswd'];
        $update_settings=json_encode($settings,JSON_PRETTY_PRINT);
        if(file_put_contents('../../settings.json',$update_settings))
        {
            echo "Settings Changed!";
        }
        else
        {
            echo "There was a problem in changing your settings";
        }
    }
    