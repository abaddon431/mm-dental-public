<?php
    if(isset($_POST['id']))
    {
        
        include_once '../../classes/autoloader.php';
        $check_files=new DBOpView();
        $id=$_POST['id'];
        $data=$check_files->fetch_files($id);
        echo $data;
    }
    else
    {
        header("location:../../index.php");
    }
?>