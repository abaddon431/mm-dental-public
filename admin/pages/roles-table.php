<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if($_SESSION['user_manage_view']==1)
    {
        include_once '../classes/autoload.php';
        $rolelist_table_obj=new DBOpView();
        $rolelist_table=$rolelist_table_obj->roleListTable();
        echo $rolelist_table;
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
