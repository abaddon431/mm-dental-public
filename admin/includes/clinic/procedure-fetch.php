<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include_once '../../classes/autoloader.php';
    $procedure_fetch_obj= new DBOpController();
    $id=$_POST['this_id'];
    $procedure_fetch=$procedure_fetch_obj->procedure_fetch($id);
    echo $procedure_fetch;
?>