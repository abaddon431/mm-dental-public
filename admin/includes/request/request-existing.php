<?php
    include_once '../../classes/autoloader.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $fetchpatients=new DBOpView();
    $data=$fetchpatients->fetch_existing_patients();
    $view='
    <form method="post" id="rinsert_form" name="rinsert_form">
        <input type="hidden" name="rentry_id" id="rentry_id" /> 
        <input type="hidden" name="reqpatient_type" id="reqpatient_type" value="1"/>

        <label for="req-existing-datalist" class="form-label fw-bold small text-uppercase">Patient Name</label>
        <input class="form-control" list="reqexistingOptions" id="req-existing-datalist" name="req-existing-datalist" required placeholder="Type to search...">
        <datalist id="reqexistingOptions">'.$data.'</datalist>
    
        <label for="date" class="form-label fw-bold small text-uppercase">Date</label>
        <input type="date" class="form-control" name="rdate" id="rdate" required/></br>
        
        <label for="rnumber" class="form-label fw-bold small text-uppercase">Contact No.</label>
        <input name="rnumber" class="form-control" id="rnumber"
            oninput="this.value = this.value.slice(0, this.maxLength);"
            type = "number"
            maxlength = "11"
            placeholder="09xx xxx xxxx"
        /></br>
        
        <label for="rtime" class="form-label fw-bold small text-uppercase">Start Time</label>
        <input type="time" class="form-control" name="rtime" id="rtime" required/></br>

        <br>
        <input type="checkbox"  class="form-check-input" name="rnotify" id="rnotify" value="yes"/>
        <label for="rnotify" class="form-check-label text-lead text-uppercase">Notify patient</label>
        <div class="modal-footer">
            <input type="submit" class="btn custom-modal-btn" id="rinsert" value="Save" />  
            <button type="button" class="btn custom-modal-btn" id="rclose-btn" data-bs-dismiss="modal">Close</button> 
        </div>
    </form>';
echo $view;

?>