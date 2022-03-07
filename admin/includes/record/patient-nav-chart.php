<?php
    include_once '../../classes/autoloader.php';
    if(isset($_POST['id']))
    {
        $table=new DBOpView();
        echo $table->patient_nav_chart($_POST['id']);
        echo '<div class="">
                <button type="button" class="multi-toggle" >Multi Select</button>
                <button type="button" class="group-select-group" id="group-select-done">Proceed</button> 
            </div></br>';
    }

?>