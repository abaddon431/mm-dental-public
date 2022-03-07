<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['clinic_proc_edit'])&&$_SESSION['clinic_proc_edit'])
    {
        include_once '../../classes/autoloader.php';
        $branchRemove_obj=new DBOpController();
        $branchRemove=$branchRemove_obj->remove_clinic_branch($_POST['this_id']);
        echo $branchRemove;
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