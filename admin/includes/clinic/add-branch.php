<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['clinic_proc_edit'])&&$_SESSION['clinic_proc_edit']==1)
    {
        if(isset($_POST['branch_name']))
        {
            include_once '../../classes/autoloader.php';

            $branch=$_POST['branch_name'];
            $branchAdd_obj=new DBOpController();
            $branchAdd=$branchAdd_obj->add_clinic_branch($branch);
            echo $branchAdd;
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
