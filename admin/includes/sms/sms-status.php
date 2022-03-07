<?php
function itexmo($apicode){
    // $endpoint = 'https://www.itexmo.com/php_api/serverstatus.php';
    $endpoint = 'https://www.itexmo.com/php_api/apicode_info.php';
    // $endpoint = 'https://www.itexmo.com/php_api/display_messages.php';
    $url = $endpoint.'?apicode='.$apicode;
    return file_get_contents($url);
}
$get_settings=file_get_contents('../../settings.json');
$settings=json_decode($get_settings,true);
$apicode=$settings['sms']['apicode'];
$data=itexmo($apicode);
echo $data;
