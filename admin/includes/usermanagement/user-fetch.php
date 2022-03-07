<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include_once '../../classes/autoloader.php';
    $user_fetch_obj= new DBOpController();
    $user_fetch=$user_fetch_obj->user_fetch($_POST['this_id']);
    echo $user_fetch;
?>