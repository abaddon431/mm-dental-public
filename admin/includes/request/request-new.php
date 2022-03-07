<?php
    $view='
    <form method="post" id="insert_form" name="insert_form">
        
    <input type="hidden" name="rentry_id" id="rentry_id" /> 
    <input type="hidden" name="reqpatient_type" id="reqpatient_type" value="2"/>
    <label class="form-label fw-bold text-uppercase text-center">Patient Info</label><br>
    <label for="rfname" class="form-label fw-bold small text-uppercase">First Name</label>
    <input type="text" class="form-control" name="rfname" id="rfname" required placeholder="First Name" /></br>

    <label for="rlname" class="form-label fw-bold small text-uppercase">Last Name</label>
    <input type="text" class="form-control" name="rlname" id="rlname" required placeholder="Last Name" /></br>

    <label for="rnumber" class="form-label fw-bold small text-uppercase">Contact No.</label>
    <input name="rnumber" class="form-control" id="rnumber"
        oninput="this.value = this.value.slice(0, this.maxLength);"
        type = "number"
        maxlength = "11"
        placeholder="09xx xxx xxxx"
    />
    <hr>
    <label class="form-label fw-bold text-uppercase text-center">Schedule Info</label><br>
    <label for="rdate" class="form-label fw-bold small text-uppercase">Date</label>
    <input type="date" class="form-control" name="rdate" id="rdate" required/></br>

    <label for="rtime" class="form-label fw-bold small text-uppercase">Start Time</label>
    <input type="time" class="form-control" name="rtime" id="rtime" required/></br>
    <br>
    <input type="checkbox"  class="form-check-input" name="rnotify" id="rnotify" value="yes"/>
    <label for="rnotify" class="form-check-label text-lead text-uppercase">Notify patient</label>
    <div class="modal-footer">
    <input type="submit" class="btn custom-modal-btn" id="insert" value="Save" />  
    <button type="button" class="btn custom-modal-btn" id="close-btn" data-bs-dismiss="modal">Close</button> 
    </div>
    </form>';

    echo $view;
?>