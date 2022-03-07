<?php 
    class DBOpController extends DBOpModel
    {
        public function login($username,$password)
        {
            $row=$this->tryLogin($username);
            if($row!=0)
            {
                if(password_verify($password,$row['password']))
                {
                    session_start();
                    session_regenerate_id();
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $row["id"];
                    $_SESSION['role']=$row["role"];
                    $_SESSION['role_desc']=$row["role_desc"];

                    $_SESSION['clinic_prof_view']=$row["clinic_prof_view"];
                    $_SESSION['clinic_prof_edit']=$row["clinic_prof_edit"];

                    $_SESSION['clinic_med_view']=$row["clinic_med_view"];
                    $_SESSION['clinic_med_edit']=$row["clinic_med_edit"];

                    $_SESSION['clinic_proc_view']=$row["clinic_proc_view"];
                    $_SESSION['clinic_proc_edit']=$row["clinic_proc_edit"];

                    $_SESSION['patient_rec_view']=$row["patient_rec_view"];
                    $_SESSION['patient_rec_edit']=$row["patient_rec_edit"];

                    $_SESSION['sched_cal_view']=$row["sched_cal_view"];
                    $_SESSION['sched_cal_edit']=$row["sched_cal_edit"];

                    $_SESSION['app_req_view']=$row["app_req_view"];
                    $_SESSION['app_req_edit']=$row["app_req_edit"];

                    $_SESSION['user_manage_view']=$row["user_manage_view"];
                    $_SESSION['user_manage_edit']=$row["user_manage_edit"];

                    $_SESSION['settings_view']=$row["settings_view"];
                    $_SESSION['settings_edit']=$row["settings_edit"];

                    $message="Welcome ".$row["username"]."!";
                    // $message="Welcome ".$_SESSION['role_desc']."!";
                    echo json_encode($message);
                    session_write_close();
                }
                else
                {
                    $message="Wrong credentials";
                    echo json_encode($message);
                }
            }
            else
            {
                $message="Account not found!";
                echo json_encode($message);
            }
        }
        public function patient_add(PatientParams $p,$id,$method)
        {
            $this->patientAdd($p,$id,$method);
        }
        public function patient_delete($id)
        {
            $this->patientDelete($id);
        }
        //precords
        public function insert_missing_tooth($pid,$tid,$m)
        {
            $this->insertMissingTooth($pid,$tid,$m);
        }
        public function insert_operated_tooth($pid,$tid,$opc,$opd,$add,$stat,$date,$note,$isgroup,$teeth_group)
        {
            $this->insertOperatedTooth($pid,$tid,$opc,$opd,$add,$stat,$date,$note,$isgroup,$teeth_group);
        }
        public function patient_treatment_add($id)
        {
            $this->patientTreatmentAdd($id);
        }
        public function patient_treatment_rm($id)
        {
            $this->patientTreatmentRm($id);
        }

        ////////////////major update
        public function role_update($uid,$role_desc,$clinic_prof_view,$clinic_prof_edit,$clinic_med_view,$clinic_med_edit,$clinic_proc_view,$clinic_proc_edit,$patient_rec_view,$patient_rec_edit,$sched_cal_view,$sched_cal_edit,$app_req_view,$app_req_edit,$user_manage_view,$user_manage_edit,$settings_view,$settings_edit)
        {
            $this->roleUpdate($uid,$role_desc,$clinic_prof_view,$clinic_prof_edit,$clinic_med_view,$clinic_med_edit,$clinic_proc_view,$clinic_proc_edit,$patient_rec_view,$patient_rec_edit,$sched_cal_view,$sched_cal_edit,$app_req_view,$app_req_edit,$user_manage_view,$user_manage_edit,$settings_view,$settings_edit);
        }
        public function user_fetch($id)
        {
            $data=$this->userFetch($id);
            return $data[0]['username'];
        }
        public function user_role_update($uid,$rid)
        {
            $this->userRoleUpdate($uid,$rid);
        }
        public function user_remove($id)
        {
            $this->userRemove($id);
        }
        public function user_add($username,$password,$role,$email)
        {
            $this->userAdd($username,$password,$role,$email);
        }
        ///////////// clinic procedures

        public function add_clinic_proc($proc_name,$branch_id)
        {
            $this->addClinicProc($proc_name,$branch_id);
        }

        public function remove_clinic_proc($proc_id)
        {
            $this->removeClinicProc($proc_id);
        }
        public function edit_clinic_proc($procedure_id,$procedure_name,$branch)
        {
            $this->editClinicProc($procedure_id,$procedure_name,$branch);
        }
        public function add_clinic_branch($branch_name)
        {
            $this->addClinicBranch($branch_name);
        }
        public function procedure_fetch($id)
        {
            $data=$this->procedureFetch($id);
            return $data[0]['proc_name'];
        }
        ///////////// clinic branches
        public function remove_clinic_branch($id)
        {
            $this->removeClinicBranch($id);
        }
        public function branch_fetch($id)
        {
            $data=$this->branchFetch($id);
            return $data[0]['branch_name'];
        }
        public function edit_clinic_branch($id,$branch)
        {
            $this->editClinicBranch($id,$branch);
        }
        public function patient_number($year)
        {
            $stack=array();
            $labels=array("January","February","March","April","May","June","July","August","September","October","November","December");
            $data=$this->numberofPatients($year);
            $data_size=sizeof($data);
            $count=0;
            for($i=1;$i<=12;$i++)
            {
                for($j=0;$j<$data_size;$j++)
                { 
                    if($data[$j]['month']==$i)
                    {
                        $count=$data[$j]['count'];
                        break;
                    }
                    else
                    {
                        $count=0;
                    }
                }
                $stack[]=array(
                    'month'=>$labels[$i-1],
                    'count'=>$count
                );
                $count=0;
            }
            return ($stack);
        }

        public function operated_number()
        {

            $data=$this->operatedNumber();
            $total = array_column($data, 'total');
            array_multisort($total, SORT_DESC, $data);
            return ($data);
        }

        public function report_month($month,$year)
        {
            $data=$this->reportMonthly($month,$year);
            return $data;
        }

        public function report_month_appointment($month,$year)
        {
            $data=$this->reportMonthlyAppointment($month,$year);
            return $data;
        }
        
        public function schedule_done($id)
        {
            echo $this->scheduleDone($id);
        }
        public function schedule_failed($id)
        {
            echo $this->scheduleFailed($id);
        }
        public function schedule_remove($id)
        {
            echo $this->scheduleRemove($id);
        }
        public function create_token($email,$selector,$token,$expires)
        {
            return $this->createToken($email,$selector,$token,$expires);
        }
        public function check_token($selector,$validator,$current_date,$password)
        {
            return $this->checkToken($selector,$validator,$current_date,$password);
        }
        public function email_check($email)
        {
            return $this->emailCheck($email);
        }
        public function username_check($username)
        {
            return $this->usernameCheck($username);
        }
        public function upload_file($pid,$url,$title,$type)
        {
            $code=$this->uploadFile($pid,$url,$title,$type);
            if($code!=1)
            {
                return "There was a problem in uploading your file";
            }
            else
            {
                return "File was uploaded successfully";
            }
        }
        public function delete_file($id)
        {
            $data=$this->deleteFile($id);
            return $data;
        }
        public function patient_fetch($id)
        {
            return $this->patientFetch($id);
        }

        //////// analytics and demographics


        public function gender_count()
        {
            return $this->genderCount();
        }

        public function age_ratio()
        {
            return $this->ageRatio();
        }
    }

?>