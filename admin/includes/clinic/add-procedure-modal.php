<div id="clinic_proc_modal" class="modal fade">  
        <div class="modal-dialog">  
            <div class="modal-content custom-modal">
                  <div class="modal-body" id="clinic_proc_form"> 
                        <div class="cpForm" id="cpForm">
                            <div class="clinicProcHead">
                                <p class="text-uppercase small fw-bold" id="clinicProcTitle">Add Procedure</p>
                            </div>
                            <form class="clinicProcForm" id="clinicProcForm" method="post">
                                <input type="hidden" name="user_id" id="user_id"/>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="procname" placeholder="Procedure" id="procname" required> 
                                </div>
                                <div class="clinic-branch-group-add input-group flex-md-wrap">
                                    <span class="input-group-text fw-bold" id="clinic-branch-text">Branch</span>

                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn custom-modal-btn" id="clinicProcAdd" value="Save" />  
                                    <button type="button" class="btn custom-modal-btn" id="clinicProcClose" data-bs-dismiss="modal">Close</button> 
                                </div>
                            </form>
                        </div>
                  </div>
            </div>
        </div> 
  </div>

  