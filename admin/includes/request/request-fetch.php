<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $request_fetch= new SchedView();
        $request_fetch->request_fetch($_POST['id']);
    }
    else
    header('location: ../../admin/login.php');
?>