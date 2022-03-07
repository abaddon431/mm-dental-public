<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['clinic_proc_view'])&&$_SESSION['clinic_proc_view']==1)
    {
        include_once '../classes/autoload.php';
        $clinic_proc_table_obj=new DBOpView();
        $clinic_proc_table=$clinic_proc_table_obj->clinic_branch_table();
        echo $clinic_proc_table;
        include_once '../includes/clinic/add-branch-modal.php';
        include_once '../includes/clinic/edit-branch-modal.php';
    }
    else
    {
        echo '
                <br>
                <div class="container-fluid">
                    <div class="row">
                        <div class="text-uppercase fw-bold">
                            You do not have access to this feature 
                        </div>
                    </div>
                </div>';
    }
?>
