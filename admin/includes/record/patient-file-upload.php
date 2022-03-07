<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if(isset($_POST['submit']))
    {
        include_once '../../classes/autoloader.php';
        $upload=new DBOpController();
        $pid=$_POST['upload_pid'];



        $file=$_FILES['file'];
        $fileName=$_FILES['file']['name'];
        $fileTmpName=$_FILES['file']['tmp_name'];
        $fileSize=$_FILES['file']['size'];
        $fileError=$_FILES['file']['error'];
        $fileType=$_FILES['file']['type'];
        // print_r($file);
        $fileGetExt=explode(".",$fileName);
        $fileExt=strtolower(end($fileGetExt));

        $allowed=array('jpg','jpeg','png');
        $title=$_POST['image-title'];
        $newtitle=strtolower($title);
        $timestamp=date("U");
        if(in_array($fileExt,$allowed))
        {
            if($fileError===0)
            {
                if($fileSize<5000000)
                {
                    $fileNewName=$newtitle.$timestamp.".".$fileExt;
                    $fileDestination='../../images/records/'.$fileNewName;
                    $root="images/records/".$fileNewName;
                    echo $upload->upload_file($pid,$root,$title,$fileExt);
                    move_uploaded_file($fileTmpName,$fileDestination);
                }
                else
                {
                    echo "File is too big!";
                }
            }
            else
            {
                echo "There was an error uploading your file";
            }
        }
        else
        {
            echo "This filetype is not allowed!";
        }
    }