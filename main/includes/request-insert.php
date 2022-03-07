<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once '../classes/autoload.php';
    if(isset($_POST['fname'])&& isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['date']))
    {
        $request_insert=new SchedController();
        $request_insert->request_insert($_POST['fname'],$_POST['lname'],$_POST['email'],$_POST['date']);
    }
    else
    header('location: ../index.php');

?>