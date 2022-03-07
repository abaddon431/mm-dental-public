<?php
//PLEASE DO NOT TOUCH THIS FILE
    spl_autoload_register('my_autoloader');

    function my_autoloader($className)
    {
        $root="../classes/";
        $ext=".class.php";
        $fullPath=$root . $className . $ext;

        if(!file_exists($fullPath)){
            return false;
        }
        include_once $fullPath;
    }
?>