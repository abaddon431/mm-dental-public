<?php

    class DBOpModel extends DBConfig
    {
        //////////// major overhaul to-do
        protected function tryLogin($username)
        {
            $conn=$this->dbConnect();
            $sql= "SELECT accounts.id, accounts.username, accounts.password,accounts.role,roles_tbl.role_desc,roles_tbl.clinic_prof_view,roles_tbl.clinic_prof_edit,roles_tbl.clinic_med_view,roles_tbl.clinic_med_edit,roles_tbl.clinic_proc_view,roles_tbl.clinic_proc_edit,roles_tbl.patient_rec_view,roles_tbl.patient_rec_edit,roles_tbl.sched_cal_view,roles_tbl.sched_cal_edit,roles_tbl.app_req_view,roles_tbl.app_req_edit,roles_tbl.user_manage_view,roles_tbl.user_manage_edit,roles_tbl.settings_view,roles_tbl.settings_edit FROM accounts LEFT JOIN roles_tbl on accounts.role=roles_tbl.id WHERE username=?";
            $stmt=$conn->prepare($sql);
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $result=$stmt->get_result();
            $row= $result->fetch_assoc();

            if($result->num_rows>0)
            {
                $conn->close();
                return $row;
            }
            else
            {
                $conn->close();
                return 0;
            }
        }
        ///////////
        protected function patientAdd(PatientParams $p,$id,$method)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            if($method==="add")
            {
                $sql = "INSERT INTO patients_tbl (fname,lname,address,birthdate,age,sex,civil_status,occupation,religion,contactno,email,notes,allergies) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssissssssss',$p->pFName,$p->pLName,$p->address,$p->birthdate,$p->pAge,$p->pSex,$p->civilstat,$p->occupation,$p->religion,$p->pContact,$p->pEmail,$p->notes,$p->allergies);
                if($stmt->execute())
                {
                    echo "Patient Added";
                }
                $conn->close();
            }
            else if($method==="save")
            {
                date_default_timezone_set('Asia/Singapore');
                $date=new DateTime();
                $edited=$date->format("Y-m-d H:i:s");
                $sql = "UPDATE patients_tbl SET fname=?, lname=?, address=?, birthdate=?, age=?, sex=?,civil_status=?, occupation=?, religion=?,contactno=?, email=?, notes=?, allergies=?, date_edited=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssisssssssssi',$p->pFName,$p->pLName,$p->address,$p->birthdate,$p->pAge,$p->pSex,$p->civilstat,$p->occupation,$p->religion,$p->pContact,$p->pEmail,$p->notes,$p->allergies,$edited,$id);
                if($stmt->execute())
                {
                    echo "Changes Saved";
                }
                $conn->close();
            }
            
        }
        protected function patientDelete($id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            $delete="UPDATE patients_tbl set status=5 WHERE id=?";
            $stmt=$conn->prepare($delete);
            $stmt->bind_param('i',$id);
            if($stmt->execute())
            {
                echo "Patient tagged as Inactive";
                $conn->close();
            }
            else
            {
                echo "Operation was not successful";
                $conn->close();
            }
        }
        protected function patientEditFetch($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $query = "SELECT * FROM patients_tbl WHERE id = $id";  
                $result = mysqli_query($conn, $query);  
                $row = mysqli_fetch_array($result);
                $conn->close();
                return $row;
            }
        }
        protected function patientFetch($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                
                $sql = "SELECT * FROM patients_tbl WHERE id=$id;"; 
                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'id'=> $row['id'],
                        'fname'=> $row['fname'],
                        'lname'=> $row['lname'],
                        'address'=>$row['address'],
                        'birthdate'=>$row['birthdate'],
                        'age'=>$row['age'],
                        'sex'=>$row['sex'],
                        'civil_status'=>$row['civil_status'],
                        'occupation'=>$row['occupation'],
                        'religion'=>$row['religion'],
                        'contactno'=>$row['contactno'],
                        'email'=>$row['email'],
                        'notes'=>$row['notes'],
                        'date_added'=>$row['date_added'],
                        'allergies'=>$row['allergies']
                    );
                }
                $conn->close();
                return $data;
            }
        }
        protected function patientTableFetch($text)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT count(1) FROM patients_tbl WHERE status=4");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                if($total==0)
                {
                    return $total;
                }
                else
                {
                    $data=array();
                    if($text!='')
                    {
                        $sql=mysqli_query($conn,"SELECT * FROM patients_tbl WHERE status=4 AND (fname LIKE '%".$text."%' OR lname LIKE '%".$text."%')");
                    }
                    else{
                        $sql=mysqli_query($conn,"SELECT * FROM patients_tbl WHERE status=4");
                    }
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        $data[]=array(
                            'id'=>$row['id'],
                            'fname'=>$row['fname'],
                            'lname'=>$row['lname'],
                            'contactno'=>$row['contactno'],
                            'email'=>$row['email'],
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }
        protected function checkSchedule($pid)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT COUNT(1) FROM patients_schedule JOIN events ON patients_schedule.event_id=events.id WHERE events.status=11 and patients_schedule.patient_id=$pid");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                return $total;
            }
        }
        protected function patientPageFetch($text,$limit,$page)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT count(1) FROM patients_tbl WHERE status=4 AND (fname LIKE '%".$text."%' OR lname LIKE '%".$text."%')");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                if($total==0)
                {
                    return $total;
                }
                else
                {
                    
                    $offset=$limit*($page-1);
                    $data=array();
                    $sql="SELECT id,fname,lname,contactno,email,date_edited FROM patients_tbl WHERE status=4 AND ";
                    $sql.="(fname LIKE '%".$text."%' OR lname LIKE '%".$text."%') ";
                    $sql.="LIMIT $limit OFFSET $offset ";
                    $result=$conn->query($sql);
                    $data[]=array("total"=>$total,"current_page"=>$page);
                    while($row=$result->fetch_assoc())
                    {
                        $data[]=array(
                            "id"=>$row['id'],
                            'fname'=>$row['fname'],
                            'lname'=>$row['lname'],
                            'contactno'=>$row['contactno'],
                            'email'=>$row['email'],
                            'date_edited'=>$row['date_edited']
                        );
                    }
                    return $data;
                }
            }
        }
        protected function serviceFetch()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT count(1) FROM services_tbl");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                if($total==0){
                    $conn->close();
                    return $total;
                }
                else
                {
                    $data=array();
                    $sql=mysqli_query($conn,"SELECT id,description,code FROM services_tbl");
                    while($row=mysqli_fetch_assoc($sql)){
                        $data[]=array(
                            'id'=> $row['id'],
                            'description'=> $row['description'],
                            'code'=> $row['code'],
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }
        protected function patientNavChart($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                
                $count_rows=mysqli_query($conn,"SELECT teeth_id,missing,operated FROM precords_tbl WHERE patient_id=$id AND status=3");
                if($count_rows->num_rows===0)
                {
                    return 0;
                }
                else{
                    $data=array();
                    $sql=mysqli_query($conn,"SELECT teeth_id,missing,operated,is_group,teeth_group FROM precords_tbl WHERE patient_id=$id AND active=1 AND status=3 ORDER BY id DESC;");
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        $data[]=array(
                            "teeth_id"=>$row['teeth_id'],
                            "missing"=>$row['missing'],
                            "operated"=>$row['operated'],
                            "is_group"=>$row['is_group'],
                            'teeth_group'=>$row['teeth_group']
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }

        //db operations on getting selects
        protected function initSelectPatho($method_id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                if($method_id==3)
                {
                    $sql=mysqli_query($conn,"SELECT id,proc_name FROM custom_proctbl;");
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        $data[]=array(
                            "id"=>$row['id'],
                            "procedure_name"=>$row['proc_name']
                        );
                    }
                    $conn->close();
                    return $data;
                }
                else
                {
                    $sql=mysqli_query($conn,"SELECT id,procedure_name,method_id FROM procedure_tbl WHERE method_id=$method_id;");
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        $data[]=array(
                            "id"=>$row['id'],
                            "procedure_name"=>$row['procedure_name'],
                            "method_id"=>$row['method_id']
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }
        protected function getCategoryPatho($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql=mysqli_query($conn,"SELECT id,procedure_id,category_name FROM category_tbl WHERE procedure_id=$id;");
                while($row=mysqli_fetch_assoc($sql))
                {
                    $data[]=array(
                        "id"=>$row['id'],
                        "procedure_id"=>$row['procedure_id'],
                        "category_name"=>$row['category_name']
                    );
                }
                $conn->close();
                return $data;
            }
        }
        protected function getSubPatho($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql=mysqli_query($conn,"SELECT id,sub_name FROM sub_tbl WHERE category_id=$id;");
                while($row=mysqli_fetch_assoc($sql))
                {
                    $data[]=array(
                        "id"=>$row['id'],
                        "sub_name"=>$row['sub_name']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        //precords
        protected function insertMissingTooth($pid,$tid,$m)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $update="UPDATE precords_tbl SET active=0 WHERE patient_id=$pid AND teeth_id=$tid AND operated!=1";
                if(mysqli_query($conn,$update))
                {

                    $missing=$m;
                    if($missing==1)
                    {
                        $operation_desc=$tid.", Missing";
                    }
                    else
                    {
                        $operation_desc=$tid.", Restored"; 
                    }
                    $status=3;
                    $active=1;
                    $sql = "INSERT INTO precords_tbl (patient_id,teeth_id,missing,operation_desc,status,active) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('iiisii',$pid,$tid,$missing,$operation_desc,$status,$active);
                    $stmt->execute();
                }
                $conn->close();
            }
        }
        protected function insertOperatedTooth($pid,$tid,$opc,$opd,$add,$stat,$date,$note,$isgroup,$teeth_group)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                if($add>12)
                {
                    $add_increment="UPDATE custom_proctbl SET total_operated=total_operated+1 WHERE id=$add";
                }
                else
                {
                    $add_increment="UPDATE procedure_tbl SET total_operated=total_operated+1 WHERE id=$add";
                }
                if(mysqli_query($conn,$add_increment))
                {
                    $update="UPDATE precords_tbl SET active=0 WHERE patient_id=$pid AND teeth_id=$tid AND operated=1";
                    if(mysqli_query($conn,$update))
                    {
                        $active=1;
                        $operated=1;
                        $sql = "INSERT INTO precords_tbl (patient_id,teeth_id,operated,operation_code,operation_desc,is_group,teeth_group,note,date_performed,status,active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('iiissssssii',$pid,$tid,$operated,$opc,$opd,$isgroup,$teeth_group,$note,$date,$stat,$active);
                        if($stmt->execute())
                        {
                            echo "Operation added";
                        }
                        else
                        {
                            echo "Failed to add operation";
                        }
                    }
                }
                $conn->close();
            }
        }
        protected function patientHistory($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT count(1) FROM precords_tbl WHERE patient_id=$id");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                if($total==0){
                    $conn->close();
                    return $total;
                }
                else
                {
                    $data=array();
                    $fetch=mysqli_query($conn,"SELECT id,operation_desc,note,date_performed FROM precords_tbl WHERE patient_id=$id AND status=3 ORDER BY id DESC");
                    while($row=mysqli_fetch_assoc($fetch)){
                        $data[]=array(
                            'id'=> $row['id'],
                            'operation_desc'=> $row['operation_desc'],
                            'note'=> $row['note'],
                            'date_performed'=> $row['date_performed']
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        } 
        protected function patientTreatment($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT count(1) FROM precords_tbl WHERE patient_id=$id AND NOT status=3");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                if($total==0){
                    $conn->close();
                    return $total;
                }
                else
                {
                    $data=array();
                    $fetch=mysqli_query($conn,"SELECT id,operation_desc,note,date_performed,status FROM precords_tbl WHERE patient_id=$id AND NOT status=3 ORDER BY id DESC");
                    while($row=mysqli_fetch_assoc($fetch)){
                        $data[]=array(
                            'id'=> $row['id'],
                            'operation_desc'=> $row['operation_desc'],
                            'note'=> $row['note'],
                            'date_performed'=> $row['date_performed'],
                            'status'=>$row['status']
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }
        protected function patientTreatmentAdd($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $update="UPDATE precords_tbl SET status=3 WHERE id=$id";
                if(mysqli_query($conn,$update))
                {
                    echo "Treatment Done";
                }
                else
                {
                    echo "Something went wrong";
                }
                $conn->close();
            }
        }
        protected function patientTreatmentRm($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $update="DELETE FROM precords_tbl WHERE id=$id";
                if(mysqli_query($conn,$update))
                {
                    echo "Record Removed";
                }
                else
                {
                    echo "Something went wrong";
                }
                $conn->close();
            }
        }

        ///////////////// major update
        //// role functions
        protected function getRoleList()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT id, role_desc FROM roles_tbl;"; 
                $result = mysqli_query($conn, $sql);  
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'id'=> $row['id'],
                        'role_desc'=> $row['role_desc']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function fetchRole($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT * FROM roles_tbl WHERE id=$id"; 
                $result = mysqli_query($conn, $sql);  
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'id'=> $row['id'],
                        'role_desc'=> $row['role_desc'],
                        'clinic_prof_view'=>$row['clinic_prof_view'],
                        'clinic_prof_edit'=>$row['clinic_prof_edit'],
                        'clinic_med_view'=>$row['clinic_med_view'],
                        'clinic_med_edit'=>$row['clinic_med_edit'],
                        'clinic_proc_view'=>$row['clinic_proc_view'],
                        'clinic_proc_edit'=>$row['clinic_proc_edit'],
                        'patient_rec_view'=>$row['patient_rec_view'],
                        'patient_rec_edit'=>$row['patient_rec_edit'],
                        'sched_cal_view'=>$row['sched_cal_view'],
                        'sched_cal_edit'=>$row['sched_cal_edit'],
                        'app_req_view'=>$row['app_req_view'],
                        'app_req_edit'=>$row['app_req_edit'],
                        'user_manage_view'=>$row['user_manage_view'],
                        'user_manage_edit'=>$row['user_manage_edit'],
                        'settings_view'=>$row['settings_view'],
                        'settings_edit'=>$row['settings_edit']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function roleUpdate($uid,$role_desc,$clinic_prof_view,$clinic_prof_edit,$clinic_med_view,$clinic_med_edit,$clinic_proc_view,$clinic_proc_edit,$patient_rec_view,$patient_rec_edit,$sched_cal_view,$sched_cal_edit,$app_req_view,$app_req_edit,$user_manage_view,$user_manage_edit,$settings_view,$settings_edit)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $sql = "UPDATE roles_tbl SET role_desc=?, clinic_prof_view=?, clinic_prof_edit=?, clinic_med_view=?, clinic_med_edit=?, clinic_proc_view=?, clinic_proc_edit=?, patient_rec_view=?, patient_rec_edit=?, sched_cal_view=?, sched_cal_edit=?, app_req_view=?, app_req_edit=?, user_manage_view=?, user_manage_edit=?, settings_view=?, settings_edit=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('siiiiiiiiiiiiiiiii',$role_desc,$clinic_prof_view,$clinic_prof_edit,$clinic_med_view,$clinic_med_edit,$clinic_proc_view,$clinic_proc_edit,$patient_rec_view,$patient_rec_edit,$sched_cal_view,$sched_cal_edit,$app_req_view,$app_req_edit,$user_manage_view,$user_manage_edit,$settings_view,$settings_edit,$uid);
                if($stmt->execute())
                {
                    echo "Changes Saved";
                }
                $conn->close();
            }
        }

        protected function getUserList()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT accounts.id,accounts.username,roles_tbl.role_desc,accounts.role,accounts.email FROM accounts LEFT JOIN roles_tbl ON accounts.role=roles_tbl.id;"; 
                $result = mysqli_query($conn, $sql);  
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'id'=> $row['id'],
                        'username'=> $row['username'],
                        'role_desc'=>$row['role_desc'],
                        'role'=>$row['role'],
                        'email'=>$row['email']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function initRoles()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql=mysqli_query($conn,"SELECT id,role_desc FROM roles_tbl");
                while($row=mysqli_fetch_assoc($sql))
                {
                    $data[]=array(
                        "id"=>$row['id'],
                        "role_desc"=>$row['role_desc']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function userFetch($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT username FROM accounts WHERE id=$id"; 
                $result = mysqli_query($conn, $sql);  
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'username'=> $row['username']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function userRoleUpdate($uid,$rid)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "UPDATE accounts SET role=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii',$rid,$uid);
                if($stmt->execute())
                {
                    echo "Changes Saved";
                }
                $conn->close();
            }
        }

        protected function userRemove($uid)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "DELETE FROM accounts WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i',$uid);
                if($stmt->execute())
                {
                    echo "User Removed!";
                }
                $conn->close();
            }
        }

        protected function userAdd($username,$password,$role,$email)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "INSERT INTO accounts (username,email,password,role) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssi',$username,$email,$password,$role);
                if($stmt->execute())
                {
                    echo "User Added!!";
                }
                else
                {
                    echo "Adding user failed!";
                }
                $conn->close();
            }
        }
        /////////////// clnic
        
        protected function clinicProcTable()
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $query = "SELECT custom_proctbl.id, custom_proctbl.proc_name,custom_branchtbl.branch_name FROM custom_proctbl LEFT JOIN custom_branchtbl ON custom_proctbl.branch_id = custom_branchtbl.id;";  
                $result = mysqli_query($conn, $query);
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'id'=> $row['id'],
                        'proc_name'=>$row['proc_name'],
                        'branch_name'=>$row['branch_name']
                    );
                }
                if(sizeof($data)>0)
                {
                    $conn->close();
                    return $data;
                }
                else
                {
                    $conn->close();
                    return 0;
                }
            }
        }

        protected function clinicBranchTable()
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $query = "SELECT * FROM custom_branchtbl";  
                $result = mysqli_query($conn, $query);
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'id'=> $row['id'],
                        'branch_name'=>$row['branch_name']
                    );
                }
                if(sizeof($data)>0)
                {
                    $conn->close();
                    return $data;
                }
                else
                {
                    $conn->close();
                    return 0;
                }
            }
        }

        protected function addClinicProc($proc_name,$branch_id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "INSERT INTO custom_proctbl (proc_name,branch_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si',$proc_name,$branch_id);
                if($stmt->execute())
                {
                    echo "Procedure Added";
                }
                else
                {
                    echo "Adding procedure failed!";
                }
                $conn->close();
            }
        }

        protected function removeClinicProc($proc_id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "DELETE FROM custom_proctbl WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i',$proc_id);
                if($stmt->execute())
                {
                    echo "Procedure Removed!";
                }
                $conn->close();
            } 
        }

        protected function editClinicProc($procedure_id,$procedure_name,$branch)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "UPDATE custom_proctbl SET proc_name=?, branch_id=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sii',$procedure_name,$branch,$procedure_id);
                if($stmt->execute())
                {
                    echo "Changes Saved";
                }
                $conn->close();
            }
        }
        protected function procedureFetch($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT proc_name FROM custom_proctbl WHERE id=$id"; 
                $result = mysqli_query($conn, $sql);  
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'proc_name'=> $row['proc_name']
                    );
                }
                $conn->close();
                return $data;
            }
        }
        ///// branches
        protected function addClinicBranch($branch_name)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "INSERT INTO custom_branchtbl (branch_name) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s',$branch_name);
                if($stmt->execute())
                {
                    echo "Branch Added";
                }
                else
                {
                    echo "Adding branch failed!";
                }
                $conn->close();
            }
        }

        protected function removeClinicBranch($branch_id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "DELETE FROM custom_branchtbl WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i',$branch_id);
                if($stmt->execute())
                {
                    echo "Branch Removed!";
                }
                $conn->close();
            } 
        }
        protected function initBranches()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql=mysqli_query($conn,"SELECT id,branch_name FROM custom_branchtbl");
                while($row=mysqli_fetch_assoc($sql))
                {
                    $data[]=array(
                        "id"=>$row['id'],
                        "branch_name"=>$row['branch_name']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function branchFetch($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT branch_name FROM custom_branchtbl WHERE id=$id"; 
                $result = mysqli_query($conn, $sql);  
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'branch_name'=> $row['branch_name']
                    );
                }
                $conn->close();
                return $data;
            }
        }
        protected function editClinicBranch($id,$branch)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "UPDATE custom_branchtbl SET branch_name=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si',$branch,$id);
                if($stmt->execute())
                {
                    echo "Changes Saved";
                }
                $conn->close();
            }
        }

        ///////////// dashboard data charts functions

        protected function numberofPatients($year)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT MONTH(date_added) month,COUNT(*) count FROM patients_tbl WHERE YEAR(date_added)='$year' AND status=4 GROUP BY MONTH(date_added)";
                $result = mysqli_query($conn, $sql);  
                
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'month'=> $row['month'],
                        'count'=> $row['count']
                    );
                }
                $conn->close();
                return $data;
            }
        }
        protected function operatedNumber()
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT procedure_name,total_operated FROM procedure_tbl ORDER BY total_operated DESC LIMIT 5";
                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'procname'=> $row['procedure_name'],
                        'total'=> $row['total_operated']
                    );
                }
                $sql = "SELECT proc_name,total_operated FROM custom_proctbl ORDER BY total_operated DESC LIMIT 5";
                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'procname'=> $row['proc_name'],
                        'total'=> $row['total_operated']
                    );
                }

                
                $conn->close();
                return $data;
            }
        }

        protected function reportMonthly($month,$year)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "SELECT pt.id,CONCAT(pt.fname,' ',pt.lname)as patient_name,pr.operation_desc,pr.date_performed FROM precords_tbl as pr LEFT JOIN patients_tbl as pt ON pr.patient_id=pt.id WHERE pt.status=4 AND MONTH(pr.date_performed)=$month AND YEAR(pr.date_performed)=$year ORDER BY pr.patient_id;";
                // $sql="SELECT pt.id,CONCAT(pt.fname,' ',pt.lname)as patient_name,pr.operation_desc,pr.date_performed FROM precords_tbl as pr LEFT JOIN patients_tbl as pt ON pr.patient_id=pt.id;";
                $result = mysqli_query($conn, $sql);
                if($result->num_rows===0)
                {
                    return 0;
                }
                else
                {
                    while($row=mysqli_fetch_assoc($result)){
                        $data[]=array(
                            'id'=> $row['id'],
                            'patient_name'=> $row['patient_name'],
                            'operation_desc'=> $row['operation_desc'],
                            'date_performed'=> $row['date_performed']
                        );
                    }
                }
                $conn->close();
                return $data;
            }
        }

        protected function reportMonthlyAppointment($month,$year)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "SELECT * FROM ap_requests WHERE MONTH(date_recieved)=$month AND YEAR(date_recieved)=$year ORDER BY id;";
                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result)){
                    $data[]=array(
                        'id'=> $row['id'],
                        'name'=> $row['fname'].' '.$row['lname'],
                        'start'=> $row['start'],
                        'email'=> $row['email'],
                        'date_recieved'=> $row['date_recieved'],
                        'status'=>$row['status']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function fetchExistingPatients()
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql = "SELECT id, CONCAT(fname,' ',lname) as name FROM patients_tbl WHERE status=4";
                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result))
                {
                    $data[]=array(
                        'id'=>$row['id'],
                        'name'=>$row['name']
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function fetchPatientSchedule($pid)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT COUNT(1) FROM patients_schedule ps INNER JOIN events et ON ps.event_id=et.id WHERE patient_id=$pid AND NOT status=10");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                if($total==0){
                    $conn->close();
                    return $total;
                }
                else
                {
                    $data=array();
                    $fetch=mysqli_query($conn,"SELECT ps.id as sched_id, ps.patient_id,ps.event_id,et.title,et.start_event,et.status FROM patients_schedule ps INNER JOIN events et ON ps.event_id=et.id WHERE patient_id=$pid AND NOT status=10 ORDER BY et.start_event");
                    while($row=mysqli_fetch_assoc($fetch)){
                        $data[]=array(
                            'sched_id'=> $row['sched_id'],
                            'patient_id'=> $row['patient_id'],
                            'event_id'=> $row['event_id'],
                            'title'=> $row['title'],
                            'start_event'=>$row['start_event'],
                            'status'=>$row['status']
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }

        protected function scheduleDone($id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $query="SELECT * FROM patients_schedule WHERE id=$id";
                $result=mysqli_query($conn,$query);
                $row = mysqli_fetch_array($result);

                $delete="UPDATE events set status=13 WHERE id=?";
                
                $stmt=$conn->prepare($delete);
                $event_id=$row[2];
                $stmt->bind_param('i',$event_id);
                if($stmt->execute())
                {
                    echo "Schedule tagged as done!";
                    $conn->close();
                }
                else
                {
                    echo "Operation was not successful";
                    $conn->close();
                }
            }
        }
        protected function scheduleFailed($id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $query="SELECT * FROM patients_schedule WHERE id=$id";
                $result=mysqli_query($conn,$query);
                $row = mysqli_fetch_array($result);

                $delete="UPDATE events set status=12 WHERE id=?";
                
                $stmt=$conn->prepare($delete);
                $event_id=$row[2];
                $stmt->bind_param('i',$event_id);
                if($stmt->execute())
                {
                    echo "Schedule tagged as no show";
                    $conn->close();
                }
                else
                {
                    echo "Operation was not successful";
                    $conn->close();
                }
            }
        }
        protected function scheduleRemove($id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $query="SELECT * FROM patients_schedule WHERE id=$id";
                $result=mysqli_query($conn,$query);
                $row = mysqli_fetch_array($result);

                $delete="UPDATE events set status=10 WHERE id=?";
                
                $stmt=$conn->prepare($delete);
                $event_id=$row[2];
                $stmt->bind_param('i',$event_id);
                if($stmt->execute())
                {
                    echo "Schedule removed";
                    $conn->close();
                }
                else
                {
                    echo "Operation was not successful";
                    $conn->close();
                }
            }
        }

        ////////////password reset////////////////
        protected function createToken($email,$selector,$token,$expires)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                //// delete token
                $sql="DELETE FROM pwd_reset WHERE resetEmail=?";
                $stmt=$conn->prepare($sql);
                $stmt->bind_param("s",$email);
                $stmt->execute();
                //// insert new token
                $insert="INSERT INTO pwd_reset (resetEmail,resetSelector,resetToken,resetExpires) VALUES (?,?,?,?);";
                $stmt=$conn->prepare($insert);
                $stmt->bind_param("ssss",$email,$selector,$token,$expires);
                if(!$stmt->execute())
                {
                    return "there was a problem";
                }
                $conn->close();
            }
        }
        protected function checkToken($selector,$validator,$current_date,$password)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                
                $sql="SELECT * FROM pwd_reset WHERE resetSelector='$selector' AND resetExpires>='$current_date'";
                $result = mysqli_query($conn, $sql);
                if(!$row=mysqli_fetch_assoc($result))
                {
                    return "Your password reset link may be expired";
                }
                else
                {
                    $tokenbin=hex2bin($validator);
                    $tokenCheck=password_verify($tokenbin,$row['resetToken']);
                    if($tokenCheck===false)
                    {
                        return "invalid token!";
                    }
                    else if($tokenCheck===true)
                    {
                        $tokenEmail=$row['resetEmail'];
                        $sql="SELECT * FROM accounts WHERE email='$tokenEmail'";
                        $result = mysqli_query($conn, $sql);
                        if(!$row=mysqli_fetch_assoc($result))
                        {
                            return "Cannot find your account!";
                        }
                        else
                        {
                            $hashpwd=password_hash($password,PASSWORD_BCRYPT);
                            $sql="UPDATE accounts SET password='$hashpwd' WHERE email='$tokenEmail'";
                            if(!mysqli_query($conn,$sql))
                            {
                                return "there was a problem in changing your password";
                            }
                            else
                            {
                                $sql="DELETE FROM pwd_reset WHERE resetEmail='$tokenEmail'";
                                $conn->close();
                                if(!mysqli_query($conn,$sql))
                                {
                                    
                                }
                                return "Password successfully changed! we are now redirecting you to login page...";
                            }
                        }
                    }
                }

            }
        }

        protected function emailCheck($email)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql="SELECT email FROM accounts WHERE email='$email' LIMIT 1";
                $count_rows=mysqli_query($conn,$sql);
                if($count_rows->num_rows!==0)
                {
                    $conn->close();
                    return 'false';
                }
                else
                {
                    $conn->close();
                    return 'true';
                }
                
            }
        }

        protected function usernameCheck($username)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql="SELECT username FROM accounts WHERE username='$username' LIMIT 1";
                $count_rows=mysqli_query($conn,$sql);
                if($count_rows->num_rows!==0)
                {
                    $conn->close();
                    return 'false';
                }
                else
                {
                    $conn->close();
                    return 'true';
                }
            }
        }

        protected function checkFiles($id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql="SELECT COUNT(1) FROM images_tbl WHERE patient_id=$id;";
                $result=mysqli_query($conn,$sql);
                $rows=mysqli_fetch_array($result);
                $conn->close();
                return $rows[0];
            }
        }

        protected function fetchFiles($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql="SELECT * FROM images_tbl WHERE patient_id=$id;";
                $result=mysqli_query($conn,$sql);
                while($rows=mysqli_fetch_assoc($result))
                {
                    $data[]=array(
                        'image_id'=>$rows['id'],
                        'patient_id'=>$rows['patient_id'],
                        'url'=>$rows['url'],
                        'title'=>$rows['title'],
                        'type'=>$rows['type']  
                    );
                }
                $conn->close();
                return $data;
            }
        }

        protected function uploadFile($pid,$url,$title,$type)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $sql = "INSERT INTO images_tbl (patient_id,url,title,type) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('isss',$pid,$url,$title,$type);
                if($stmt->execute())
                {
                    return 1;
                }
                $conn->close();
            }
        }
        protected function deleteFile($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql="SELECT url FROM images_tbl WHERE id=$id";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_array($result);
                $message=1;
                $data[]=array("url"=>$row[0]);
                $delete="DELETE FROM images_tbl WHERE id=$id";
                if(mysqli_query($conn,$delete))
                {
                    $message=1;
                }
                else
                {
                    $message=0;
                }
                $data[]=array("code"=>$message);
                $conn->close();
                return $data;
            }
        }

        protected function genderCount()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array();
                $sql="SELECT * FROM patients_tbl WHERE status=4;";
                $result=mysqli_query($conn,$sql);
                $male=0;
                $female=0;
                $other=0;
                while($rows=mysqli_fetch_assoc($result))
                {
                    if($rows['sex']==="M")
                    {
                        $male++;
                    }
                    else if($rows['sex']==="F")
                    {
                        $female++;
                    }
                    else
                    {
                        $other++;
                    }
                }
                array_push($data,$male,$female,$other);
                $conn->close();
                return $data;
            }
        }

        protected function ageRatio()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $data=array(array(),array(),array());
                $sql="SELECT * FROM patients_tbl WHERE status=4;";
                $result=mysqli_query($conn,$sql);
                $g1=0;
                $g2=0;
                $g3=0;
                $g4=0;
                $g5=0;
                $g6=0;

                $m1=0;
                $m2=0;
                $m3=0;
                $m4=0;
                $m5=0;
                $m6=0;

                $f1=0;
                $f2=0;
                $f3=0;
                $f4=0;
                $f5=0;
                $f6=0;
                
                while($rows=mysqli_fetch_assoc($result))
                {
                    if($rows['sex']==="M")
                    {
                        if($rows['age']>=7 && $rows['age'] <=15)
                        {
                            $m1++;
                        }
                        else if($rows['age']>=16 && $rows['age'] <=25)
                        {
                            $m2++;
                        }
                        else if($rows['age']>=26 && $rows['age'] <=35)
                        {
                            $m3++;
                        }
                        else if($rows['age']>=36 && $rows['age'] <=45)
                        {
                            $m4++;
                        }
                        else if($rows['age']>=56 && $rows['age'] <=65)
                        {
                            $m5++;
                        }
                        else if($rows['age']>=65)
                        {
                            $m6++;
                        }
                    }
                    else if($rows['sex']==="F")
                    {
                        if($rows['age']>=7 && $rows['age'] <=15)
                        {
                            $f1++;
                        }
                        else if($rows['age']>=16 && $rows['age'] <=25)
                        {
                            $f2++;
                        }
                        else if($rows['age']>=26 && $rows['age'] <=35)
                        {
                            $f3++;
                        }
                        else if($rows['age']>=36 && $rows['age'] <=45)
                        {
                            $f4++;
                        }
                        else if($rows['age']>=56 && $rows['age'] <=65)
                        {
                            $f5++;
                        }
                        else if($rows['age']>=65)
                        {
                            $f6++;
                        }
                    }
                    else if($rows['sex']==="O")
                    {
                        if($rows['age']>=7 && $rows['age'] <=15)
                        {
                            $g1++;
                        }
                        else if($rows['age']>=16 && $rows['age'] <=25)
                        {
                            $g2++;
                        }
                        else if($rows['age']>=26 && $rows['age'] <=35)
                        {
                            $g3++;
                        }
                        else if($rows['age']>=36 && $rows['age'] <=45)
                        {
                            $g4++;
                        }
                        else if($rows['age']>=56 && $rows['age'] <=55)
                        {
                            $g5++;
                        }
                        else if($rows['age']>=65)
                        {
                            $g6++;
                        }
                    }
                }
                $conn->close();
                array_push($data[0],$m1,$m2,$m3,$m4,$m5,$m6);
                array_push($data[1],$f1,$f2,$f3,$f4,$f5,$f6);
                array_push($data[2],$g1,$g2,$g3,$g4,$g5,$g6);
                return $data;
            }
        }
    }

?>