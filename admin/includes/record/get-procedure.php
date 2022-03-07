<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['method']))
    {
        $initSelect=new DBOpView();
        echo $initSelect->init_select_patho($_POST['method']);
    }
?>