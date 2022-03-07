<?php
    if(!empty($_GET['useremail']))
    {
        include_once '../../classes/autoloader.php';
        $email_check=new DBOpController();
        $email=$_GET['useremail'];
        echo $email_check->email_check($email);
    }
?>