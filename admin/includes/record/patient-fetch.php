<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $fetch= new DBOpView();
        echo $fetch->patient_fetch($_POST['id']);
        include 'patient-fetch-modal.php';
    }
    else
        header('location: ../../admin/login.php');
?>