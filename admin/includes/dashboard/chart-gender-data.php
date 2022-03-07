<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once '../../classes/autoloader.php';
    $patient_count_obj=new DBOpController();
    $data=$patient_count=$patient_count_obj->gender_count();
    echo json_encode($data)
    // echo "nice";
?>
