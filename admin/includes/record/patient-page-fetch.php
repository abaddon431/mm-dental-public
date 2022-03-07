<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once '../../classes/autoloader.php';
    $pagefetch=new DBOpView();
    $limit=5;
    $page=1;
    $text="";
    if(isset($_POST['limit']))
    {
        $limit=$_POST['limit'];
    }
    if(isset($_POST['page']))
    {
        $page=$_POST['page'];
    }
    if(isset($_POST['input']))
    {
        $text=$_POST['input'];
    }
    echo $pagefetch->patient_page_fetch($text,$limit,$page);
?>
