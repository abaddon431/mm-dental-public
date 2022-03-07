<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once '../../classes/autoloader.php';

    $count_appoint_obj=new SchedController();
    $count_appoint=$count_appoint_obj->count_appointment();
    echo $count_appoint;

?>
