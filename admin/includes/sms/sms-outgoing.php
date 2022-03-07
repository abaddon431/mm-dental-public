<?php
    function pendingSMS($code)
    {
        $endpoint='https://www.itexmo.com/php_api/display_outgoing.php';
        $url=$endpoint.'?apicode='.$code.'&sortby=asc';
        return file_get_contents($url);
    }
        
    $get_settings=file_get_contents('../../settings.json');
    $settings=json_decode($get_settings,true);
    $apicode=$settings['sms']['apicode'];
    $data=pendingSMS($apicode);
    echo $data;