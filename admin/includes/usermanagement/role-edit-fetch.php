<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    if(isset($_POST['id']))
    {
        if($_SESSION['user_manage_view']==1)
        {
            $id=$_POST['id'];
            include_once '../../classes/autoloader.php';
            $rolelist_fetch_obj=new DBOpView();
            $rolelist_fetch=$rolelist_fetch_obj->fetch_role($id);
            echo $rolelist_fetch;
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
    }
?>
