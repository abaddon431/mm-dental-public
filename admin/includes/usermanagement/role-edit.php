<?php
    session_start();
    if($_SESSION['user_manage_edit']==1)
    {
        if(isset($_POST['uid'])&&isset($_POST['role_desc'])==true)
        {
            
            include_once '../../classes/autoloader.php';
            $role_update_obj=new DBOpController();

            $uid=$_POST['uid'];
            $role_desc=$_POST['role_desc'];
            $clinic_prof_view=$_POST['clinic_prof_view'];
            $clinic_prof_edit=$_POST['clinic_prof_edit'];
            $clinic_med_view=$_POST['clinic_med_view'];
            $clinic_med_edit=$_POST['clinic_med_edit'];
            $clinic_proc_view=$_POST['clinic_proc_view'];
            $clinic_proc_edit=$_POST['clinic_proc_edit'];
            $patient_rec_view=$_POST['patient_rec_view'];
            $patient_rec_edit=$_POST['patient_rec_edit'];
            $sched_cal_view=$_POST['sched_cal_view'];
            $sched_cal_edit=$_POST['sched_cal_edit'];
            $app_req_view=$_POST['app_req_view'];
            $app_req_edit=$_POST['app_req_edit'];
            $user_manage_view=$_POST['user_manage_view'];
            $user_manage_edit=$_POST['user_manage_edit'];
            $settings_view=$_POST['settings_view'];
            $settings_edit=$_POST['settings_edit'];

            $role_update=$role_update_obj->role_update($uid,$role_desc,$clinic_prof_view,$clinic_prof_edit,$clinic_med_view,$clinic_med_edit,$clinic_proc_view,$clinic_proc_edit,$patient_rec_view,$patient_rec_edit,$sched_cal_view,$sched_cal_edit,$app_req_view,$app_req_edit,$user_manage_view,$user_manage_edit,$settings_view,$settings_edit);
            echo $role_update;
        }
        else
        {
            echo "post not found";
        }
    }
    else
    {
        echo '
        <div class="container-fluid">
            <div class="row">
                <div class="text-uppercase fw-bold">
                    You do not have access to this feature 
                </div>
            </div>
        </div>';
    }
    
?>
