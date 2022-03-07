<?php
    if(!empty($_GET['usernameadd']))
    {
        include_once '../../classes/autoloader.php';
        $username_check=new DBOpController();
        $username=$_GET['usernameadd'];
        echo $username_check->username_check($username);
    }
?>