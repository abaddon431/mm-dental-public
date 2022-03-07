<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $patient_treatment_rm=new DBOpController();
        echo $patient_treatment_rm->patient_treatment_rm($_POST['id']);
    }
    else
    {
        header('location: ../admin/login.php');
    }
?>