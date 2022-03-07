<?php
    include_once '../classes/autoload.php';
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $op= new DBOpController();
        $op->login($_POST['username'],$_POST['password']);
    }else
    header('location: ../login.php');
?>