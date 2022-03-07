<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $get_settings=file_get_contents('../../settings.json');
    $settings=json_decode($get_settings,true);
    if(isset($_POST['mode']))
    {
        $settings['theme']="dark";
    }
    else
    {
        $settings['theme']="default";
    }
    
    $update_settings=json_encode($settings,JSON_PRETTY_PRINT);
    if(file_put_contents('../../settings.json',$update_settings))
    {
        echo "Theme toggled!";
    }
    else
    {
        echo "There was a problem in changing your theming";
    }