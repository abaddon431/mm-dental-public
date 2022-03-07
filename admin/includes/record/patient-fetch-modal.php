
 <!--options modal-->

<div id="options_modal" class="modal fade" tabindex="-1"> 
      <div class="modal-dialog">  
           <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-bold small text-uppercase ModalLabel">Dental Procedures</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" id="options_form">
                    <div class="d-flex justify-content-around flex-wrap">
                        <input type="hidden" class="is-group" id="is-group"/>
                        <button class="op-btn" id="missing-click">
                            <i class="bi bi-plus-circle"></i>
                            <span class="small text-uppercase">Missing</span>
                        </button>
                        <button class="op-btn" id="patho-click">
                            <i class="bi bi-plus-circle"></i>
                            <span class="small text-uppercase">Pathology</span>
                        </button>
                        <button class="op-btn" id="resto-click">
                            <i class="bi bi-plus-circle"></i>
                            <span class="small text-uppercase">Restoration</span>
                        </button>
                        <button class="op-btn" id="other-click">
                            <i class="bi bi-plus-circle"></i>
                            <span class="small text-uppercase">Other Procedures</span>
                        </button>
                    </div>
                </div>
           </div> 
      </div>
 </div>
<!--missing modal-->
<div id="missing_modal" class="modal fade" tabindex="-1">  
      <div class="modal-dialog modal-sm">  
           <div class="modal-content custom-modal">
                <div class="modal-body" id="missing-form">
                <h5 class="modal-title fw-bold small text-uppercase ModalLabel">Are you sure you want to tag this tooth as Missing?</h5>
                     <form method="post" id="missing_form" name="missing_form">
                        <input type="hidden" class="patient-id"/>
                        <input type="hidden" class="tooth-id"/>
                        <div class="modal-footer">
                            <input type="button" class="btn" data-bs-dismiss="modal" value="No"/> 
                            <input type="submit" class="btn op-btn" id="tooth-missing-btn" value="Yes" />
                        </div>
                    </form>
                </div>
           </div>  
      </div>
 </div>
 <div id="change_missing_modal" class="modal fade" tabindex="-1">  
      <div class="modal-dialog modal-sm">  
           <div class="modal-content custom-modal">
                <div class="modal-body" id="change-missing-form">
                <h5 class="modal-title fw-bold small text-uppercase ModalLabel">Restore this teeth?</h5>
                     <form method="post" id="change_missing_form" name="missing_form">
                        <input type="hidden" class="patient-id"/>
                        <input type="hidden" class="tooth-id"/>
                        <div class="modal-footer">
                            <input type="button" class="btn" data-bs-dismiss="modal" value="No"/> 
                            <input type="submit" class="btn btn-primary" id="tooth-missing-btn" value="Yes" />
                        </div>
                    </form>
                </div>
           </div>  
      </div>
 </div>
 <!--pathology modal-->
 <div id="patho_modal" class="modal fade" tabindex="-1">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-bold small text-uppercase ModalLabel" id="patho_modal_label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" id="patho-form">
                     <form method="post" id="patho_form" name="patho_form">
                        <input type="hidden" class="patient-id"/>
                        <input type="hidden" class="tooth-id"/>
                        
                        <label for="patho-group" class="form-label fw-bold small text-uppercase">Operation</label>
                        <div class="patho-group input-group flex-md-wrap">
                            <span class="input-group-text fw-bold" id="patho-tooth-id-text"></span>
                            <!--generate dynamic selections-->
                        </div>
                        <label for="patho-date" class="form-label fw-bold small text-uppercase my-2">Date</label>
                        <input type="date" class="form-control" name="patho-date" id="patho-date" required/></br>
                        
                        <label for="patho-note" class="form-label fw-bold small text-uppercase my-2">Note</label>
                        <textarea class="form-control" name="patho-note" id="patho-note" rows="3" maxlength="255"></textarea>
                        
                        <label for="options" class="form-label fw-bold small text-uppercase my-2">Options</label>
                        <div class="options text-center" id="options">
                                <input type="radio" id="patho-monitor" name="patho-option" value="1"/>
                                <label for="patho-monitor" class="monitor-label text-uppercase">Monitor</label>

                                <input type="radio" id="patho-treat" name="patho-option" value="2"/>
                                <label for="patho-treat" class="treat-label text-uppercase">Treat</label>
                                
                                <input type="radio" id="patho-save" name="patho-option" value="3" checked/>
                                <label for="patho-save" class="save-label text-uppercase">Save</label>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="submit" class="btn op-btn" id="patho-add-btn">Add</button>
                            <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
           </div>  
      </div>
 </div>

 <div id="resto_modal" class="modal fade" tabindex="-1">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-bold small text-uppercase ModalLabel" id="resto_modal_label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" id="resto-form">
                     <form method="post" id="resto_form" name="resto_form">
                        <input type="hidden" class="patient-id"/>
                        <input type="hidden" class="tooth-id"/>
                        <div class="resto-group input-group">
                            <span class="input-group-text" id="resto-tooth-id-text"></span>
                            <!--generate dynamic selections-->
                        </div>
                        <label for="resto-date" class="form-label fw-bold small text-uppercase my-2">Date</label>
                        <input type="date" class="form-control" name="resto-date" id="resto-date" required/></br>
                        
                        <label for="resto-note" class="form-label fw-bold small text-uppercase my-2">Note</label>
                        <textarea class="form-control" name="resto-note" id="resto-note" rows="3" maxlength="255"></textarea>
                        
                        <label for="options" class="form-label fw-bold small text-uppercase my-2">Options</label>
                        <div class="options  text-center" id="options">
                                <input type="radio" id="resto-monitor" name="resto-option" value="1"/>
                                <label for="resto-monitor" class="monitor-label text-uppercase">Monitor</label>

                                <input type="radio" id="resto-treat" name="resto-option" value="2"/>
                                <label for="resto-treat" class="treat-label text-uppercase">Treat</label>
                                
                                <input type="radio" id="resto-save" name="resto-option" value="3" checked/>
                                <label for="resto-save" class="save-label text-uppercase">Save</label>
                        </div>
                        <br>

                        <div class="modal-footer">
                            <input type="submit" class="btn op-btn" id="resto-add-btn" value="Save" />
                            <input type="button" class="btn" data-bs-dismiss="modal" value="Close"/> 
                        </div>
                    </form>
                </div>
           </div>  
      </div>
 </div>

 <div id="other_modal" class="modal fade" tabindex="-1">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title fw-bold small text-uppercase ModalLabel" id="other_modal_label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" id="other-form">
                     <form method="post" id="other_form" name="other_form">
                        <input type="hidden" class="patient-id"/>
                        <input type="hidden" class="tooth-id"/>
                        <div class="other-group input-group">
                            <span class="input-group-text" id="other-tooth-id-text"></span>
                            <!--generate dynamic selections-->
                        </div>
                        <label for="other-date" class="form-label fw-bold small text-uppercase my-2">Date</label>
                        <input type="date" class="form-control" name="other-date" id="other-date" required/></br>
                        
                        <label for="other-note" class="form-label fw-bold small text-uppercase my-2">Note</label>
                        <textarea class="form-control" name="other-note" id="other-note" rows="3" maxlength="255"></textarea>
                        
                        <label for="options" class="form-label fw-bold small text-uppercase my-2">Options</label>
                        <div class="options  text-center" id="options">
                                <input type="radio" id="other-monitor" name="other-option" value="1"/>
                                <label for="other-monitor" class="monitor-label text-uppercase">Monitor</label>

                                <input type="radio" id="other-treat" name="other-option" value="2"/>
                                <label for="other-treat" class="treat-label text-uppercase">Treat</label>
                                
                                <input type="radio" id="other-save" name="other-option" value="3" checked/>
                                <label for="other-save" class="save-label text-uppercase">Save</label>
                        </div>
                        <br>

                        <div class="modal-footer">
                            <input type="submit" class="btn op-btn" id="other-add-btn" value="Save" />
                            <input type="button" class="btn" data-bs-dismiss="modal" value="Close"/> 
                        </div>
                    </form>
                </div>
           </div>  
      </div>
 </div>

 