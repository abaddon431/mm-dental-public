<?php
    include_once '../../classes/autoloader.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $fetchpatients=new DBOpView();
    $data=$fetchpatients->fetch_existing_patients();
    $view='
    <form method="post" id="insert_form" name="insert_form">
        <label for="name" class="form-label fw-bold small text-uppercase">Patient Name</label>
        <input type="hidden" name="patient_type" id="patient_type" value="1"/>
        <input class="form-control" list="existingOptions" id="existing-datalist" name="existing-datalist" required placeholder="Type to search...">
        <datalist id="existingOptions">'.$data.'</datalist>
    <!--<input type="text" class="form-control" name="name" id="name" required placeholder="Patient Name" /></br>-->
    
    <label for="date" class="form-label fw-bold small text-uppercase">Date</label>
    <input type="date" class="form-control" name="date" id="date" required/></br>
    <input type="hidden" name="end_date" id="end_date"/>
    
    <label for="time" class="form-label fw-bold small text-uppercase">Start Time</label>
    <input type="time" class="form-control" name="time" id="time" required/></br>
    
    <!-- <label for="time" class="form-label fw-bold small text-uppercase">Treatment Type</label> -->
    
    <div class="modal-footer">
    <input type="submit" class="btn custom-modal-btn" id="insert" value="Save" />  
    <button type="button" class="btn custom-modal-btn" id="close-btn" data-bs-dismiss="modal">Close</button> 
    </div>
</form>';
    echo $view;
?>