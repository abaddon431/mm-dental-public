<div id="add_user_modal" class="modal fade">  
        <div class="modal-dialog">  
            <div class="modal-content custom-modal">
                  <div class="modal-body" id="add_user_modal_container"> 
                        <div class="auForm" id="auForm">
                            <div class="addUserHead">
                                <p class="text-uppercase small fw-bold" id="addUserTitle">Create New User</p>
                            </div>
                            <form class="addUserForm" id="addUserForm" method="post">
                                <label for="usernameadd" generated="true" class="error"></label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="usernameadd" placeholder="Username" id="usernameadd" required>
                                </div>
                                
                                <label for="useremail" generated="true" class="error"></label>
                                <div class="mb-3 input-group">
                                    <input type="text" class="form-control" name="useremail" placeholder="Email" id="useremail" required>
                                </div>
                                <label for="passwordadd" generated="true" class="error"></label>
                                <div class="mb-3 input-group">
                                    <input type="password" class="form-control" name="passwordadd" placeholder="Password" id="passwordadd" required>
                                    <span class="input-group-text fw-bold pass_eye_toggle" id="pass_eye_toggle"><i class="bi bi-eye"></i></span>
                                </div>
                                

                                <label for="confirmpasswordadd" generated="true" class="error"></label>
                                <div class="mb-3 input-group">
                                    <input type="password" class="form-control" name="confirmpasswordadd" placeholder="Confirm Password" id="confirmpasswordadd" required>
                                </div>
                                <label for="user-role-select" generated="true" class="error"></label>
                                <div class="user-role-group-add input-group flex-md-wrap">
                                    <span class="input-group-text fw-bold" id="user-role-id-text-add">Role</span>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn custom-modal-btn" id="addUserModalSave" value="Save" />  
                                    <button type="button" class="btn custom-modal-btn" id="addUserModalClose" data-bs-dismiss="modal">Close</button> 
                                </div>
                            </form>
                        </div>
                  </div>
            </div>
        </div> 
  </div>

  