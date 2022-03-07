<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']) && isset($_POST['sub']))
    {
        if($_POST['id']!=="")
        {
            $getSub=new DBOpView();
            $data=$getSub->get_sub_patho($_POST['id'],$_POST['sub']);
            if($data!==0)
            {
                echo $data;
            }
        }
    }
    else
    header('location: ../admin/login.php');
        
?>
