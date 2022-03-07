<?php

    session_start();
    if(isset($_SESSION['id']))
    {
        if($_SESSION['patient_rec_edit']==1)
        {
            echo'
            <button class="btn" id="back-patientTbl">
                <span><i class="bi bi-arrow-90deg-left"></i></span>
             </button>
            <div class="pForm" id="pForm">
                <div class="pFormHead">
                    <p class="text-uppercase small fw-bold" id="pFormTitle"></p>
                </div>
                <form class="patientForm" id="patientForm" method="post">
                    <input type="hidden" name="patient_add_id" id="patient_add_id"/>
                    <div class="mb-3">
                        <label for="firstname" class="form-label small fw-bold text-uppercase">First Name</label>
                        <input type="text" class="form-control"name="firstname" placeholder="First Name" id="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label small fw-bold text-uppercase">Last Name</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name" id="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label small fw-bold text-uppercase">Age</label>
                        <input type="text" class="form-control" name="age" placeholder="Age" id="age" required>
                    </div>
                    <div class="mb-3">
                        <label for="sex" class="form-label small fw-bold text-uppercase">Sex</label>
                        <input type="text" class="form-control " name="sex" placeholder="Sex" id="sex" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactno" class="form-label small fw-bold text-uppercase">Contact No.</label>
                        <input type="number" class="form-control" name="contactno" placeholder="Contact No." id="contactno">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-uppercase">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email Address" id="email">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" name="pSave" id="pSave">
                    </div>
                </form>
            </div>';
        }
        else
        {
            echo '
                <br>
                <div class="container-fluid">
                    <div class="row">
                        <div class="text-uppercase fw-bold">
                            You do not have access to this feature 
                        </div>
                    </div>
                </div>';
        }
    }

?>