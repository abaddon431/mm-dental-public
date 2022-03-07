<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['user_manage_edit'])&&$_SESSION['user_manage_edit'])
    {
        include_once '../../classes/autoloader.php';
        $userRoleEdit_obj=new DBOpController();
        $userRoleEdit=$userRoleEdit_obj->user_role_update($_POST['user_id'],$_POST['user_role']);
        echo $userRoleEdit;
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