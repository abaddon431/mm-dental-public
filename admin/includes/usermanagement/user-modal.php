<div id="user_role_modal" class="modal fade">  
        <div class="modal-dialog">  
            <div class="modal-content custom-modal">
                  <div class="modal-body" id="user_role_form"> 
                        <div class="urForm" id="urForm">
                            <div class="userRoleFormHead">
                                <p class="text-uppercase small fw-bold" id="userRoleFormTitle">Role Edit</p>
                            </div>
                            <form class="userRoleForm" id="userRoleForm" method="post">
                                <input type="hidden" name="user_id" id="user_id"/>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="username" placeholder="User Name" id="username" disabled>
                                </div>
                                <div class="user-role-group input-group flex-md-wrap">
                                    <span class="input-group-text fw-bold" id="user-role-id-text">Role</span>
                                   
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn custom-modal-btn" id="userRoleUpdate" value="Save" />  
                                    <button type="button" class="btn custom-modal-btn" id="userRoleModalClose" data-bs-dismiss="modal">Close</button> 
                                </div>
                            </form>
                        </div>
                  </div>
            </div>
        </div> 
  </div>

  