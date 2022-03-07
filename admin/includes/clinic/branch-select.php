<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include_once '../../classes/autoloader.php';
    $clinicbranch_fetch_obj= new DBOpView();
    $isadd=$_POST['isadd'];
    $clinicbranch_fetch=$clinicbranch_fetch_obj->init_branches($isadd);
    echo $clinicbranch_fetch;
?>