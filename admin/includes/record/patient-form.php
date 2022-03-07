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
            <div class="pForm mx-auto p-4" id="pForm">
                <div class="pFormHead">
                    <p class="text-uppercase small fw-bold" id="pFormTitle"></p>
                </div>
                <form class="patientForm" id="patientForm" method="post">
                    <input type="hidden" name="patient_add_id" id="patient_add_id"/>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="name_front">Name</span>
                        </div>
                        <input type="text" class="form-control" name="firstname" placeholder="Firstname" id="firstname" required>
                        <input type="text" class="form-control" name="lastname" placeholder="Lastname" id="lastname" required>
                    </div>
                    </br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="address_front">Address</span>
                        </div>
                        <input type="text" class="form-control" name="address" id="address">
                    </div>
                    
                    </br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="birthday_front">Birthdate</span>
                        </div>
                        <input type="date" class="form-control" name="birthdate" id="birthdate">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id="gender_front">Gender</span>
                        </div>
                        <select class="form-select" name="patient_gender" id="patient_gender" aria-label="Gender">
                            <option selected>Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other</option>
                        </select>
                    </div>

                    </br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="civil_front">Civil Status</span>
                        </div>
                        <select class="form-select" name="civil_status" id="civil_status" aria-label="Civil Status">
                            <option selected>Select Civil Status</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                            <option value="widowed">Widowed</option>
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="occupation_front">Occupation</span>
                        </div>
                        <input type="text" class="form-control" id="occupation" name="occupation">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="religion_front">Religion</span>
                        </div>
                        <input type="text" class="form-control" id="religion" name="religion">
                    </div>

                                    
                    </br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="civil_front">Contact no.</span>
                        </div>
                        <input type="text" class="form-control" id="contactno" name="contactno">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="occupation_front">Email</span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email">
                        
                    </div>


                    </br>
                    <div class="input-group">
                        <label for="notesarea" class="p-2 fw-bold"> Notes: </label>
                        <textarea class="form-control" id="notesarea" name="notesarea" rows="2"></textarea>
                        
                        <label for="allergies" class="p-2 fw-bold"> Allergies: </label>
                        <textarea class="form-control" id="allergies" name="allergies" rows="2"></textarea>
                    </div>
                    <div class="mb-3 mx-auto p-4">
                        <input type="submit" class="btn btn-primary" name="pSave" id="pSave">
                        <button class="btn" name="pCancel" id="back-patientTbl">Cancel</button>
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