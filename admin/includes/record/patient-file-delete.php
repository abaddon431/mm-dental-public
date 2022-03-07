<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if(isset($_POST['id']))
    {
        include_once '../../classes/autoloader.php';
        $delete=new DBOpController();
        $data=$delete->delete_file($_POST['id']);
        $url=$data[0]['url'];
        $code=$data[1]['code'];

        if($code==0)
        {
            echo "Failed to delete the file in the database";
        }
        else
        {
            $new_url="../../".$url;
            unlink($new_url);
            echo "Image deleted!";
        }
    }
?>