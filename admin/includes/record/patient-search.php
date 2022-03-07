<?php
    include_once '../../classes/autoloader.php';
    
    $pTableObj=new DBOpView();
    if(!isset($_POST['input']))
    {
        $patient_table=$pTableObj->patient_table('');
    }
    else
    {
        $patient_table=$pTableObj->patient_table($_POST['input']);
    }
    echo $patient_table;
?>