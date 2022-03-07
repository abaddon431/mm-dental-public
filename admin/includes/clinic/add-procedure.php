<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['clinic_proc_edit'])&&$_SESSION['clinic_proc_edit']==1)
    {
        if(isset($_POST['procedure_name'])&&isset($_POST['branch_id']))
        {
            include_once '../../classes/autoloader.php';

            $procedure_name=$_POST['procedure_name'];
            $branch=$_POST['branch_id'];
            $procAdd_obj=new DBOpController();
            $procAdd=$procAdd_obj->add_clinic_proc($procedure_name,$branch);
            echo $procAdd;
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
