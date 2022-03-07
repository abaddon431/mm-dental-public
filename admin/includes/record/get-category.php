<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']) && isset($_POST['category']))
    {
        if($_POST['id']!=="")
        {
            $getCategory=new DBOpView();
            $data=$getCategory->get_category_patho($_POST['id'],$_POST['category']);
            if($data!==0)
            {
                echo $data;
            }
        }
    }
    else
    header('location: ../admin/login.php');
    
?>
