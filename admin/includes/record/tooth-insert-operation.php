<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['pid'])&&isset($_POST['tid'])&&isset($_POST['opc'])&&isset($_POST['opd'])&&isset($_POST['add']) && isset($_POST['status']))
    {
        $insert=new DBOpController();
        if(!is_numeric($_POST['tid']))
        {
            $teeth_id=0;
        }
        else
        {
            $teeth_id=$_POST['tid'];
        }

        if($_POST['isgroup']==1)
        {
            $isgroup=1;
            $teeth_group=$_POST['tid'];
        }
        else
        {
            $isgroup=0;
            $teeth_group=0;
        }
        $insert->insert_operated_tooth($_POST['pid'],$teeth_id,$_POST['opc'],$_POST['opd'],$_POST['add'],$_POST['status'],$_POST['date'],$_POST['note'],$isgroup,$teeth_group);
    }
    else
    {
        header('location: ../../admin/login.php');
    }
?>