<div id="proc_edit_modal" class="modal fade">  
        <div class="modal-dialog">
            <div class="modal-content custom-modal">
                  <div class="modal-body" id="proc_edit_form"> 
                        <div class="peForm" id="peForm">
                            <div class="procEditHead">
                                <p class="text-uppercase small fw-bold" id="procEditTitle">Edit Proceudre</p>
                            </div>
                            <form class="procEditForm" id="procEditForm" method="post">
                                <input type="hidden" name="proc_user_id" id="proc_user_id"/>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="editprocname" placeholder="Procedure" id="editprocname" required>
                                </div>
                                <div class="clinic-branch-group input-group flex-md-wrap">
                                    <span class="input-group-text fw-bold" id="clinic-branch-text">Branch</span>

                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn custom-modal-btn" id="clinicProcSave" value="Save" />  
                                    <button type="button" class="btn custom-modal-btn" id="clinicEditClose" data-bs-dismiss="modal">Close</button> 
                                </div>
                            </form>
                        </div>
                  </div>
            </div>
        </div> 
  </div>

  