<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once '../../classes/autoloader.php';
    $total_patient_obj=new SchedController();
    $total_patient=$total_patient_obj->count_patients();
    echo $total_patient;
?>  