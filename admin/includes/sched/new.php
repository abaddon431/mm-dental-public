<?php
    $view='
    <form method="post" id="insert_form" name="insert_form">
        
    <input type="hidden" name="patient_type" id="patient_type" value="2"/>
    <label class="form-label fw-bold text-uppercase text-center">Patient Info</label><br>
    <label for="fname" class="form-label fw-bold small text-uppercase">First Name</label>
    <input type="text" class="form-control" name="fname" id="fname" required placeholder="First Name" /></br>
    
    <label for="lname" class="form-label fw-bold small text-uppercase">Last Name</label>
    <input type="text" class="form-control" name="lname" id="lname" required placeholder="Last Name" /></br>
    
    <label for="contact" class="form-label fw-bold small text-uppercase">Contact No.</label>
    <input name="contact" class="form-control" id="contact"
        oninput="this.value = this.value.slice(0, this.maxLength);"
        type = "number"
        maxlength = "11"
        placeholder="09xx xxx xxxx"
    />
    <hr>
    <label class="form-label fw-bold text-uppercase text-center">Schedule Info</label><br>
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