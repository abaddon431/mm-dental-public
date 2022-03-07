<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include_once '../../classes/autoloader.php';
    $branch_fetch_obj= new DBOpController();
    $id=$_POST['this_id'];
    $branch_fetch=$branch_fetch_obj->branch_fetch($id);
    echo $branch_fetch;
?>