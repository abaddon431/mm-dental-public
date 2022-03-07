<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['user_manage_edit'])&&$_SESSION['user_manage_edit']==1)
    {
        if(isset($_POST['username'])&&isset($_POST['password']))
        {
            $username=$_POST['username'];
            $password=$_POST['password'];
            $role=$_POST['user_role'];
            $email=$_POST['email'];
            $passhash=password_hash($password,PASSWORD_BCRYPT);
            include_once '../../classes/autoloader.php';
            $userAdd_obj=new DBOpController();
            $userAdd=$userAdd_obj->user_add($username,$passhash,$role,$email);
            echo $userAdd;
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
