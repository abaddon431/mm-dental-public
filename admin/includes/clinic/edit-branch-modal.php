<div id="branch_edit_modal" class="modal fade">  
        <div class="modal-dialog">  
            <div class="modal-content custom-modal">
                  <div class="modal-body" id="branch_edit_form"> 
                        <div class="beForm" id="beForm">
                            <div class="branchEditHead">
                                <p class="text-uppercase small fw-bold" id="branchEditTitle">Edit Branch</p>
                            </div>
                            <form class="branchEditForm" id="branchEditForm" method="post">
                                <input type="hidden" name="branchuser_id" id="branchuser_id"/>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="editbranchname" placeholder="Branch Name" id="editbranchname" required>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn custom-modal-btn" id="branchEditSave" value="Save" />  
                                    <button type="button" class="btn custom-modal-btn" id="branchEditClose" data-bs-dismiss="modal">Close</button> 
                                </div>
                            </form>
                        </div>
                  </div>
            </div>
        </div> 
  </div>

  