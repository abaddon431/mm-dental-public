<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once '../../classes/autoloader.php';
    $pagefetch=new SchedView();
    $text="";
    if(isset($_POST['input']))
    {
        $text=$_POST['input'];
    }
    
    echo $pagefetch->request_table_search($text);
?>
