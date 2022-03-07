<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include_once '../../classes/autoloader.php';
    $rolelist_fetch_obj= new DBOpView();
    $isadd=$_POST['isadd'];
    $rolelist_fetch=$rolelist_fetch_obj->init_roles($isadd);
    echo $rolelist_fetch;
?>