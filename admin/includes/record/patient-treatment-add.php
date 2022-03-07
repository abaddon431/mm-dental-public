<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $patient_treatment_add=new DBOpController();
        echo $patient_treatment_add->patient_treatment_add($_POST['id']);
    }
    else
    {
        header('location: ../admin/login.php');
    }
?>