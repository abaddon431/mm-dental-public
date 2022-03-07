<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['clinic_proc_edit'])&&$_SESSION['clinic_proc_edit']==1)
    {
        if(isset($_POST['proc_id'])&&isset($_POST['branch_id'])&&isset($_POST['proc_name']))
        {
            include_once '../../classes/autoloader.php';

            $procedure_id=$_POST['proc_id'];
            $branch=$_POST['branch_id'];
            $procedure_name=$_POST['proc_name'];
            $procEdit_obj=new DBOpController();
            $procEdit=$procEdit_obj->edit_clinic_proc($procedure_id,$procedure_name,$branch);
            echo $procEdit;
        }
    }
    else
    {
        echo '
        <div class="container-fluid">
            <div class="row">
                <div class="text-uppercase fw-bold">
                    You do not have access to this feature
                </div>
            </div>
        </div>';
    }
?>
