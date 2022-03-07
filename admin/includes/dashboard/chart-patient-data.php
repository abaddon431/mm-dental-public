<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once '../../classes/autoloader.php';
    date_default_timezone_set('Asia/Singapore');
    $year=date("Y");
    $patient_count_obj=new DBOpController();
    $patient_count=$patient_count_obj->patient_number($year);
    echo json_encode($patient_count)
    // echo "nice";
?>
