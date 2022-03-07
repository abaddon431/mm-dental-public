<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if($_SESSION['user_manage_view']==1)
    {
        include_once '../classes/autoload.php';
        $userlist_table_obj=new DBOpView();
        $userlist_table=$userlist_table_obj->userListTable();
        echo $userlist_table;
        include_once '../includes/usermanagement/user-modal.php';
        include_once '../includes/usermanagement/user-add-modal.php';
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