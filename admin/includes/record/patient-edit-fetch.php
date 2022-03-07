<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $request_fetch= new DBOpView();
        $request_fetch->patient_edit_fetch($_POST['id']);
    }
    else
    header('location: ../admin/login.php');
?>