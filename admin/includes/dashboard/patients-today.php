<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    date_default_timezone_set('Asia/Singapore');
    $month=date("m");
    $day=date("d");
    $year=date("Y");
    $maxDate=$year.'-'.$month.'-'.$day;

    include_once '../../classes/autoloader.php';
    $patient_today_obj=new SchedController();
    $patient_today=$patient_today_obj->count_today($maxDate);
    echo $patient_today;
?>  