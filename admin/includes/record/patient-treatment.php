<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $patient_treatment=new DBOpView();
        echo $patient_treatment->patient_treatment($_POST['id']);
    }
    else
    {
        header('location: ../admin/login.php');
    }
?>