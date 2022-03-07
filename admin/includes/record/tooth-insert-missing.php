<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['pid']) && isset($_POST['tid']))
    {
        $insertMissing=new DBOpController();
        $pid=$_POST['pid'];
        $tid=$_POST['tid'];
        $m=$_POST['mid'];
        $insertMissing->insert_missing_tooth($pid,$tid,$m);
    }
    else
    header('location: ../../admin/login.php');
?>