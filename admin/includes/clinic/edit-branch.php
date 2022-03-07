<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['clinic_proc_edit'])&&$_SESSION['clinic_proc_edit']==1)
    {
        if(isset($_POST['this_id'])&&isset($_POST['branch_name']))
        {
            include_once '../../classes/autoloader.php';

            $id=$_POST['this_id'];
            $branch=$_POST['branch_name'];
            $branchEdit_obj=new DBOpController();
            $branchEdit=$branchEdit_obj->edit_clinic_branch($id,$branch);
            echo $branchEdit;
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
