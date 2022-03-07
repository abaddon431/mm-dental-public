<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $get_settings=file_get_contents('../../settings.json');
    $settings=json_decode($get_settings,true);
    echo $settings['theme'];
    