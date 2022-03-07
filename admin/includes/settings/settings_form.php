<?php
    if(file_exists('../../settings.json'))
    {
        $get_settings=file_get_contents('../../settings.json');
        $settings=json_decode($get_settings,true);
        $apicode=$settings['sms']['apicode'];
        $apipasswd=$settings['sms']['password'];
        
    }
    echo'
<div class="settings">
    <form class="smsapi" method="POST">
        <label class="form-label fw-bold text-uppercase text-center">API Code</label>
        <input class="form-control" id="apicode" name="apicode" type="text" placeholder="API Code" value="'.$apicode.'" required/>
        <label class="form-label fw-bold text-uppercase text-center">API Password</label>
        <input class="form-control" id="apipasswd" name="apipasswd" type="text" placeholder="API Password" value="'.$apipasswd.'" required/>
        <div class="modal-footer">
            <button type="submit" class="btn custom-modal-btn" name="save">Save</button>
        </div>
    </form>
</div>';