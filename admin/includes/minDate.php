<?php
    //getting the server date according to server timezone to set minimum date on date picker;
    date_default_timezone_set('Asia/Singapore');
    $month=date("m");
    $day=date("d");
    $year=date("Y");
    $maxDate=$year.'-'.$month.'-'.$day;
    echo json_encode($maxDate);
?>