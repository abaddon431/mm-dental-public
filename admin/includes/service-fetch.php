<?php
    include_once '../classes/autoload.php';
    $serviceObj=new DBOpView();
    $service_fetch=$serviceObj->service_fetch();
    echo $service_fetch;
?>
