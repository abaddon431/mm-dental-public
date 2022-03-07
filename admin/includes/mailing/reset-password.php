<?php
if(isset($_POST['createpassword']))
{

    include_once '../../classes/autoloader.php';
    $selector=$_POST['selector'];
    $validator=$_POST['validator'];
    $password=$_POST['password'];

    $current_date=date("U");

    $check_token=new DBOpController();
    
    echo $check_token->check_token($selector,$validator,$current_date,$password);
    echo '<script>setTimeout(\'location.href="../login.php";\',5000);</script>';
    // header("location:../login.php");
    
}
else
{
    header("location:../login.php");
}
?>