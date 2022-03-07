<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $patient_schedule=new DBOpView();
        // echo $_POST['id'];
        echo $patient_schedule->fetch_patient_schedule($_POST['id']);
        
    }
    else
    {
        header('location: ../admin/login.php');
    }
?>