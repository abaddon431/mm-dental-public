<?php
    include_once '../../classes/autoloader.php';
    session_start();
    if(isset($_POST['id']))
    {
        if($_SESSION['patient_rec_edit']==1)
        {
            $delete=new DBOpController();
            $delete->patient_delete($_POST['id']);
        }
        else
        {
            echo "You do not have access to this feature ";
        }
    }
?>