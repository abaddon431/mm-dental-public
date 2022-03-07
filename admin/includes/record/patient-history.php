<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $patient_history=new DBOpView();
        echo $patient_history->patient_history($_POST['id']);
    }
    else
    {
        header('location: ../admin/login.php');
    }
?>