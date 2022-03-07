<?php

    class DBOpView extends DBOpModel
    {
        
        ///////////////////////////////////////////////////
        public function patient_table($text)
        {

            $data=$this->patientTableFetch($text);
            $counter=0;
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No patients yet 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                session_start();
                $length=sizeof($data);
                if($length==0)
                {
                    $append='
                    <div class="container d-flex justify-content-center align-items center" >
                        <p class="text-uppercase text-center fw-bold my-5"  id="message"> No patients found 
                    </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
                }
                else
                {
                    // $length=sizeof($data);
                    $counter=0;
                    $append='
                        <table class="table table-borderless" id="patient-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th scope="col" class="text-uppercase small tbl-th">Name</th>
                                    <th scope="col" class="text-uppercase small tbl-th">Contact No.</th>
                                    <th scope="col" class="text-uppercase small tbl-th">Email</th>
                                    <th scope="col" class="text-uppercase small tbl-th">Last Modified</th>
                                    <th></th>
                                    <th</th>
                                </tr>
                            </thead>';
                    while($counter<$length)
                    {
                        $string=new DateTime($data[$counter]['date_edited']);
                        $date=$string->format("F d, Y - g:i a");
                        $append.='<tr>
                                    <td class="first_name small" id="'.$data[$counter]['id'].'">'.$data[$counter]['fname'].' '. $data[$counter]['lname'].'</td>
                                    <td class="small">'.$data[$counter]['contactno'].'</td>
                                    <td class="small">'.$data[$counter]['email'].'</td>
                                    <td class="small">'.$date.' | '.$_SESSION['username'].'</td>
                                    <td></td>
                                    <td>
                                        <a id="'.$data[$counter]["id"].'" class="patient-edit-btn"><i class="bi bi-pencil-fill"></i></a>
                                        <a id="'.$data[$counter]["id"].'" class="patient-remove-btn"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>';
                        $counter++;
                    }
                    $append.='</table>';
                }
                return $append;
            }
        }

        public function patient_page_fetch($text,$limit,$page)
        {
            $data=$this->patientPageFetch($text,$limit,$page);
            
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No patients found 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                
                $length=sizeof($data);
                $total=$data[0]['total'];
                $numOfPage=ceil($total/$limit);
                $current_page=$data[0]['current_page'];
                $five_count=0;
                $append=
                '<div class="input-group mb-3">
                    <label class="input-group-text limit-select-label" for="limit-select">Show</label>
                            <select name="limit-select" class=" limit-select" id="limit-select" required>';
                while($five_count<=15)
                {
                    if($five_count==0)
                    {
                        $append.='
                        <option value="" selected disabled>None</option>';
                    }
                    else if($five_count==$limit)
                    {
                        $append.='
                        <option value="'.$five_count.'" selected>'.$five_count.'</option>';
                    }
                    else
                    {
                        $append.='
                        <option value="'.$five_count.'">'.$five_count.'</option>';
                    }
                    $five_count+=5;
                }
                $append.='</select>
                </div>';
                


                $counter=1;
                $prev_page=$current_page-1;
                $append.='<div class="d-flex justify-content-center">
                            <nav aria-label="page navigation" class="patient-pages">
                                <ul class="pagination patient-pages-ul">';
                if($current_page!=1)
                {
                    $append.=
                    '
                        <li class="page-item">
                            <a class="page-link" href="#" data-value="'.$prev_page.'" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        ';
                }
                else
                {
                    $append.=
                    '
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        ';
                }
                $append.='<li class="page-item active"><p class="page-link">'.$current_page.'/'.$numOfPage.'</p></li>';
                $next_page=$current_page+1;
                if($current_page!=$numOfPage)
                {
                    $append.='<li class="page-item">
                        <a class="page-link" href="#" data-value="'.$next_page.'" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    </ul>';
                }
                else
                {
                    $append.='<li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    </ul>';
                }
                $append.='
                </nav></div>';



                
                $append.='
                        <table class="table table-borderless" id="patient-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th scope="col" class="text-uppercase small tbl-th">Name</th>
                                    <th scope="col" class="text-uppercase small tbl-th">Contact No.</th>
                                    <th scope="col" class="text-uppercase small tbl-th">Email</th>
                                    <th></th>
                                    <th scope="col" class="text-uppercase small tbl-th">Last Modified</th>
                                    
                                    <th</th>
                                </tr>
                            </thead>';
                
                $counter=1;
                while($counter<$length)
                {
                    $isNotif='';
                    $schedCount=$this->checkSchedule($data[$counter]['id']);
                    if($schedCount!=0)
                    {
                        // $isNotif='<i class="bi bi-dot notif-dot"></i>';
                        $isNotif='<span class="notif-dot"></span>';
                    }
                    $string=new DateTime($data[$counter]['date_edited']);
                    $date=$string->format("F d, Y - g:i a");
                    $append.='<tr>
                                <td class="first_name small" id="'.$data[$counter]['id'].'">'.$isNotif.' '.$data[$counter]['fname'].' '. $data[$counter]['lname'].'</td>
                                <td class="small">'.$data[$counter]['contactno'].'</td>
                                <td class="small">'.$data[$counter]['email'].'</td>
                                <td></td>
                                <td class="small">'.$date.'</td>
                                
                                <td>
                                    <a id="'.$data[$counter]["id"].'" class="patient-edit-btn"><i class="bi bi-pencil-fill"></i></a>
                                    <a id="'.$data[$counter]["id"].'" class="patient-remove-btn"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>';
                    $counter++;
                }
                
                $append.='</table>';
                
                return $append;
            }
        }
        public function patient_fetch($id)
        {
            
            $data=$this->patientFetch($id);
            $counter=0;
            $length=sizeof($data);
            $gender;
            if($data[0]['sex']=="M")
            {
                $gender="Male";
            }
            else{
                $gender="Female";
            }
            $string=new DateTime($data[0]['birthdate']);
            $bday=$string->format("F d, Y");

            $append='
                    <button class="btn" id="back-patientTbl">
                        <span><i class="bi bi-arrow-90deg-left"></i></span>
                    </button>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                            <table class="patient-info-table">
                                <tr>
                                    <th>'.$data[0]['fname'].' '.$data[0]['lname'].'</th>
                                    <th></th>
                                </tr>
                                <tr>
                                
                                    <td>Address:  '.$data[0]['address'].'</td>
                                    <td>Gender:  '.$gender.'</td>
                                </tr>
                                <tr>
                                    <td>Birthdate:  '.$bday.'</td>
                                    <td>Age: '.$data[0]['age'].'</td>
                                </tr>
                                <tr>
                                    <td>Civil Status:'.$data[0]['civil_status'].'</td>
                                    <td>Occupation:'.$data[0]['occupation'].'</td>
                                    <td>Religion:'.$data[0]['religion'].'</td>
                                </tr>
                                <tr>
                                    <th>Notes</th>
                                    <th>Allergies</th>
                                </tr>
                                <tr>
                                    <td>'.$data[0]['notes'].'</td>
                                    <td>'.$data[0]['allergies'].'</td>
                                </tr>
                            </table>
                            </div>
                        </div>
                        <div class="row">
                            <nav class="navbar navbar-expand custom-nav-patient">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#patient-nav" aria-controls="patient-nav" aria-expanded="false">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse">
                                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                    <input type="hidden" class="patient-nav-id" id="'.$data[0]['id'].'"/>
                                    <li class="nav-item">
                                        <a class="nav-link patient-nav active" id="patient_schedule">Schedule</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link patient-nav" id="patient_dental">Dental Chart</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link patient-nav" id="patient_treatment">Treatments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link patient-nav" id="patient_history">History</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link patient-nav" id="patient_files">Files</a>
                                    </li>
                                    
                                </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="row">
                            <div class="patient-nav-main">
                            </div>
                        </div>
                    </div>';
            return $append;
        }
        public function patient_edit_fetch($id)
        {
            echo json_encode($this->patientEditFetch($id));
        }
        public function service_fetch()
        {
            $append="";
            $data=$this->serviceFetch();
            $length=sizeof($data);
            $counter=0;
            if($data==0)
            {
                $append='<option>no services yet</option>';
            }
            else
            {
                while($counter<$length)
                {
                    $append.='<option value="'.$data[$counter]['code'].'">'.$data[$counter]['description'].'</option>';
                    $counter++;
                }
            }
            return $append;
        }
        public function patient_nav_chart($id)
        {
            $data=$this->patientNavChart($id);
            if($data!=0)
            {
                $length=sizeof($data);
                $counter=1;
                $table=
                '
                <br>
                <div class="table-responsive text-center">
                    <table class="table" id="dental_chart">';
                while($counter<=4)
                {
                    if($counter==1)
                    {
                        $table.='<thead>';
                        for($i=1;$i<=16;$i++)
                        {
                            $table.='<th>'.$i.'</th>';
                        }
                        $table.='</thead>';
                    }
                    if($counter==2)
                    {
                        $tooltip="";
                        $table.='<tr>';
                        $teeth_group=array(0);
                        for($i=0;$i<$length;$i++)
                        {
                            if($data[$i]['is_group']==1)
                            {
                                $group=explode(',',$data[$i]['teeth_group']);
                                foreach($group as $teeth)
                                {
                                    array_push($teeth_group,$teeth);
                                }
                            }
                        }
                        for($i=1;$i<=16;$i++)
                        {
                            $class="".$i;
                            if(in_array($i,$teeth_group))
                            {
                                $class.=' grouped';
                                $tooltip="Operated In a Group";
                                $table.='<td><i class="dc-teeth dc-teeth-'.$class.'" id="teeth-'.$i.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$tooltip.'"></i></td>';
                            }
                            else
                            {
                                for($j=0;$j<$length;$j++)
                                {
                                    if($i==$data[$j]['teeth_id'])
                                    {
                                        if($data[$j]['missing']==1)
                                        {
                                            $class.=" missing";
                                            $tooltip="Missing Tooth";
                                            break;
                                        }
                                        else if($data[$j]['operated']==1)
                                        {
                                            $class.=" operated";
                                            $tooltip="Operated Tooth";
                                            break;
                                        }
                                    }
                                }
                            $table.='<td><i class="dc-teeth dc-teeth-'.$class.'" id="teeth-'.$i.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$tooltip.'"></i></td>';
                            $tooltip="";
                            }    
                        }
                        $table.='</tr><tr class="group-select-wrapper" id="group-select-one">';
                        $value=1;
                        for($i=0;$i<16;$i++)
                        {
                            $table.='<td><input name="group-select-teeth" class="group-select" type="checkbox" value="'.$value.'"/><span class="checkmark"></span></td>';
                            $value++;
                        }
                        $value=32;
                        $table.='</tr><tr class="group-select-wrapper" id="group-select-two">';
                        for($i=0;$i<16;$i++)
                        {
                            $table.='<td><input name="group-select-teeth" class="group-select" type="checkbox" value="'.$value.'"/><span class="checkmark"></span></td>';
                            $value--;
                        }
                        $table.='</tr>';
                    }
                    if($counter==3)
                    {
                        $table.='<tr>';
                        $teeth_group=array(0);
                        for($i=0;$i<$length;$i++)
                        {
                            if($data[$i]['is_group']==1)
                            {
                                $group=explode(',',$data[$i]['teeth_group']);
                                foreach($group as $teeth)
                                {
                                    array_push($teeth_group,$teeth);
                                }
                            }
                        }
                        for($i=32;$i>=17;$i--)
                        {
                            $class="".$i;
                            if(in_array($i,$teeth_group))
                            {
                                $class.=' grouped';
                                $tooltip="Operated In a Group";
                                $table.='<td><i class="dc-teeth dc-teeth-'.$class.'" id="teeth-'.$i.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$tooltip.'"></i></td>';
                            }
                            else
                            {
                                for($j=0;$j<$length;$j++)
                                {
                                    if($i==$data[$j]['teeth_id'])
                                    {
                                        if($data[$j]['missing']==1)
                                        {
                                            $class.=" missing";
                                            break;
                                        }
                                        else if($data[$j]['operated']==1)
                                        {
                                            $class.=" operated";
                                            break;
                                        }
                                    }
                                }
                                $table.='<td><i class="dc-teeth dc-teeth-'.$class.'" id="teeth-'.$i.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$tooltip.'"></i></td>';
                                $tooltip="";
                            }
                            
                        }
                        $table.='</tr>';
                    }
                    if($counter==4)
                    {
                        $table.='<thead>';
                        for($i=32;$i>=17;$i--)
                        {
                            $table.='<th>'.$i.'</th>';
                        }
                        $table.='</thead>';
                    }
                    $counter++;
                }
                $footer='
                    </div>
                </div>
                ';
                return $table.$footer;
            }
            else
            {
                $counter=1;
                $table=
                '
                <br>
                <div class="table-responsive text-center">
                    <table class="table" id="dental_chart">';
                while($counter<=4)
                {
                    if($counter==1)
                    {
                        $table.='<thead>';
                        for($i=1;$i<=16;$i++)
                        {
                            $table.='<th>'.$i.'</th>';
                        }
                        $table.='</thead>';
                    }
                    if($counter==2)
                    {
                        $table.='<tr>';
                        $class;
                        for($i=1;$i<=16;$i++)
                        {
                            $table.='<td><i class="dc-teeth dc-teeth-'.$i.'" id="teeth-'.$i.'"></i></td>';
                        }
                        $table.='</tr><tr class="group-select-wrapper" id="group-select-one">';
                        $value=1;
                        for($i=0;$i<16;$i++)
                        {
                            $table.='<td><input name="group-select-teeth" class="group-select" type="checkbox" value="'.$value.'"/><span class="checkmark"></span></td>';
                            $value++;
                        }
                        $value=32;
                        $table.='</tr><tr class="group-select-wrapper" id="group-select-two">';
                        for($i=0;$i<16;$i++)
                        {
                            $table.='<td><input name="group-select-teeth" class="group-select" type="checkbox" value="'.$value.'"/><span class="checkmark"></span></td>';
                            $value--;
                        }
                        $table.='</tr>';
                    }
                    if($counter==3)
                    {
                        $table.='<tr>';
                        for($i=32;$i>=17;$i--)
                        {
                            $table.='<td><i class="dc-teeth dc-teeth-'.$i.'" id="teeth-'.$i.'"></i></td>';
                        }
                        $table.='</tr>';
                    }
                    if($counter==4)
                    {
                        $table.='<thead>';
                        for($i=32;$i>=17;$i--)
                        {
                            $table.='<th>'.$i.'</th>';
                        }
                        $table.='</thead>';
                    }
                    $counter++;
                }
                $footer='
                    </div>
                </div>
                ';
                return $table.$footer;
            }
        }

        //pathology selects
        public function init_select_patho($method_id)
        {
            $data=$this->initSelectPatho($method_id);
            $length=sizeof($data);
            $counter=0;
            $method_class;
            if($method_id==1)
            {
                $method_class="patho";
            }
            else if($method_id==2)
            {
                $method_class="resto";
            }
            else if($method_id==3)
            {
                $method_class="other";
            }
            $append='
            <select name="'.$method_class.'-procedure" class="'.$method_class.'-procedure form-select" id="'.$method_class.'-procedure-select" required>
            <option value="" selected disabled>Select Procedure</option>';
            
            while($counter<$length)
            {
                $append.='<option value="'.$data[$counter]['id'].'">'.$data[$counter]['procedure_name'].'</option>';
                $counter++;
            }
            $append.='</select>';
            return $append;
        }
        public function get_category_patho($id,$category)
        {
            $data=$this->getCategoryPatho($id);
            $length=sizeof($data);
            $counter=0;
            $append='';
            $cat_append="";
            if($length!=0)
            {
                if($data[$counter]['procedure_id']==1)
                {
                    $cat_append="patho-tooth-part";
                    $append.=
                    '<div class="dropdown '.$cat_append.'">
                        <button class="btn custom-dd-btn dropdown-toggle" type="button" id="patho-zones-btn" aria-expanded="false">
                            Select Zones
                        </button>
                        <ul class="dropdown-menu" id="patho-zone-dropdown" aria-labelledby="patho-zones-btn ">
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Cervical Buccal" />Cervical Buccal</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Buccal" />Buccal</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Mesial" />Mesial</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Occlusal" />Occlusal</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Distal" />Distal</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Palatal" />Palatal</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Cervical Palatal" />Cervical Palatal</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Buccal Cusp" />Buccal Cusp</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Palatal Cusp" />Palatal Cusp</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Buccal Surface" />Buccal Surface</label></li>
                            <li><label class="form-check-label"><input name="patho-zone" type="checkbox" value="Palatal Surface" />Palatal Surface</label></li>
                        </ul>
                    </div>';
                }
                if($data[$counter]['procedure_id']>=7 && $data[$counter]['procedure_id']<12)
                {
                    $cat_append="resto-tooth-part";
                    $append.=
                    '<div class="dropdown '.$cat_append.'">
                        <button class="btn custom-dd-btn dropdown-toggle" type="button" id="resto-zones-btn" aria-expanded="false">
                            Select Zones
                        </button>
                        <ul class="dropdown-menu" id="patho-zone-dropdown" aria-labelledby="resto-zones-btn">
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Cervical Buccal" />Cervical Buccal</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Buccal" />Buccal</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Mesial" />Mesial</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Occlusal" />Occlusal</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Distal" />Distal</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Palatal" />Palatal</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Cervical Palatal" />Cervical Palatal</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Buccal Cusp" />Buccal Cusp</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Palatal Cusp" />Palatal Cusp</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Buccal Surface" />Buccal Surface</label></li>
                            <li><label class="form-check-label"><input name="resto-zone" type="checkbox" value="Palatal Surface" />Palatal Surface</label></li>
                        </ul>
                    </div>';
                }
                $append.='<select name="'.$category.'" class="'.$category.' form-select" id="category-select" required>
                <option value="" selected disabled>Select an Option</option>';
                while($counter<$length)
                {
                    $append.='<option value="'.$data[$counter]['id'].'">'.$data[$counter]['category_name'].'</option>';
                    $counter++;
                }
                $append.='</select>';
            }
            
            return $append;
        }
        public function get_sub_patho($id,$sub)
        {
            $data=$this->getSubPatho($id);
            $length=sizeof($data);
            $counter=0;
            if($length!=0)
            {
                $append='<select name="'.$sub.'" class="'.$sub.' form-select" id="sub-select" required>
                <option value="" selected disabled>Select an Option</option>';
                while($counter<$length)
                {
                    $append.='<option value="'.$data[$counter]['id'].'">'.$data[$counter]['sub_name'].'</option>';
                    $counter++;
                }
                $append.='</select>';
                return $append;
            }
            else return 0;
        }
        public function patient_history($id)
        {
            $data=$this->patientHistory($id);
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No records yet 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                $counter=0;
                $append='
                    <br>
                    <div class="table-responsive">
                    <table class="table table-borderless" id="patient-history">
                        <caption></caption>';
                while($counter<$length)
                {
                    $note;
                    if($data[$counter]['note']=="")
                    {
                        $note=$data[$counter]['note'];
                    }
                    else
                    {
                        $note="-".$data[$counter]['note'];
                    }
                    $time=strtotime($data[$counter]['date_performed']);
                    $date=date('F j, Y',$time);
                    $append.='<tr>
                                <td class="small">'.$data[$counter]['operation_desc'].$note.'</td>
                                <td class="small"></td>
                                <td></td>
                                <td></td>
                                <td class="small">'.$date.'</td>
                                <td>
                                    <a id="'.$data[$counter]["id"].'" class="patient-history-rm"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>';
                    $counter++;
                }
                $append.='</table></div>';
                return $append;
            }
        }
        public function patient_treatment($id)
        {
            $data=$this->patientTreatment($id);
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No treatments yet 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                $counter=0;
                $append='
                    <br>
                    <div class="table-responsive">
                    <table class="table table-borderless" id="patient-treatment">
                        <caption></caption>';
                while($counter<$length)
                {
                    $note;
                    if($data[$counter]['status']==1)
                    {
                        $class="tr-monitor";
                    }
                    else if($data[$counter]['status']==2)
                    {
                        $class="tr-treat";
                    }
                    if($data[$counter]['note']=="")
                    {
                        $note=$data[$counter]['note'];
                    }
                    else
                    {
                        $note="-".$data[$counter]['note'];
                    }
                    $time=strtotime($data[$counter]['date_performed']);
                    $date=date('F j, Y',$time);
                    $append.='<tr class="'.$class.'">
                                <td class="small">
                                    <a id="'.$data[$counter]["id"].'" class="patient-treatment-add"><i class="bi bi-check-circle-fill check-treatment"></i></a>
                                </td>
                                <td class="small">'.$data[$counter]['operation_desc'].$note.'</td>
                                <td class="small"></td>
                                <td></td>
                                <td class="small">'.$date.'</td>
                                <td class="small">
                                    <a id="'.$data[$counter]["id"].'" class="patient-treatment-rm"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>';
                    $counter++;
                }
                $append.='</table></div>';
                return $append;
            }
        }

        ///////////////////// major update
        public function roleListTable()
        {
            $data=$this->getRoleList();
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No users yet 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                $counter=0;
                $append='
                        <br>
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-8">
                                <h5>
                                    <span><i class="bi bi-bezier"></i></span>
                                    <span>Roles List</span>
                                </h5>
                            </div>
                        </div>
                        <table class="table table-borderless" id="roles-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th></th>
                                    <th scope="col" style="width:80%" class="text-uppercase  tbl-th">Role</th>
                                    <th scope="col" style="width:20%" class="text-uppercase  tbl-th">Action</th>
                                </tr>
                            </thead>';
                while($counter<$length)
                {
                    $append.='<tr>
                                <td></td>
                                <td class=" text-capitalize">'.$data[$counter]['role_desc'].'</td>';
                    if($data[$counter]['role_desc']=="admin")
                    {
                                $append.='
                                <td class=" text-uppercase">
                                    Default
                                </td>
                            </tr>';
                    }
                    else
                    {
                                $append.='
                                <td>
                                    <a id="'.$data[$counter]["id"].'" class="manage-role-edit"><i class="bi bi-pencil-fill"></i></a>
                                </td>
                            </tr>';   
                    }
                    
                    $counter++;
                }
                $append.='</table></div>';
                return $append;
            }
            return $data;
        }

        public function fetch_role($id)
        {
            $data=$this->fetchRole($id);
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No users yet 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $uid=$data[0]['id'];
                $role_desc=$data[0]['role_desc'];

                $clinic_prof_view=$data[0]['clinic_prof_view'];
                $clinic_prof_edit=$data[0]['clinic_prof_edit'];

                $clinic_med_view=$data[0]['clinic_med_view'];
                $clinic_med_edit=$data[0]['clinic_med_edit'];

                $clinic_proc_view=$data[0]['clinic_proc_view'];
                $clinic_proc_edit=$data[0]['clinic_proc_edit'];

                $patient_rec_view=$data[0]['patient_rec_view'];
                $patient_rec_edit=$data[0]['patient_rec_edit'];

                $sched_cal_view=$data[0]['sched_cal_view'];
                $sched_cal_edit=$data[0]['sched_cal_edit'];

                $app_req_view=$data[0]['app_req_view'];
                $app_req_edit=$data[0]['app_req_edit'];

                $user_manage_view=$data[0]['user_manage_view'];
                $user_manage_edit=$data[0]['user_manage_edit'];
                
                $settings_view=$data[0]['settings_view'];
                $settings_edit=$data[0]['settings_edit'];

                
                $append=
                '<div class="user-permissions-container">
                    <form method="post" id="permissions_form" name="permissions_form">
                    <div class="user-permissons">
                        <label for="user-perm-desc">Role Name</label>
                        </br>
                        <input type="text" id="'.$uid.'" value="'.$role_desc.'" class="user-perm-desc" name="user-perm-desc"/>
                    </div>';

                $append.='<p class="text-uppercase mx-1 fw-bold">Permissions</p>';
                $append.='
                        <table class="table" id="permissions-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th scope="col" class="text-uppercase  tbl-th">Component</th>
                                    <th scope="col" colspan="3" class="text-uppercase  tbl-th">Permissions</th>
                                </tr>
                            </thead>
                            <tr>
                                <th></th>
                                <th>View/Edit</th>
                                <th>View</th>
                                <th>None</th>
                            </tr>
                            ';
                $viewEdit='';$view='';$none='';
                if($clinic_prof_edit ==1)
                    $viewEdit='checked';
                else if($clinic_prof_view==1)
                    $view='checked';
                else if($clinic_prof_view==0 &&$clinic_prof_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>Clinic Profile</td>
                    <td><input class="form-check-input" type="radio" name="clinic_profile" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="clinic_profile" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="clinic_profile" value="0"'.$none.'/></td>
                </td>';
                ////////////////
                $viewEdit='';$view='';$none='';
                if($clinic_med_edit ==1)
                    $viewEdit='checked';
                else if($clinic_med_view==1)
                    $view='checked';
                else if($clinic_med_view==0 &&$clinic_med_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>Clinic Medications</td>
                    <td><input class="form-check-input" type="radio" name="clinic_medications" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="clinic_medications" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="clinic_medications" value="0"'.$none.'/></td>
                </td>';
                ////////////////
                $viewEdit='';$view='';$none='';
                if($clinic_proc_edit ==1)
                    $viewEdit='checked';
                else if($clinic_proc_view==1)
                    $view='checked';
                else if($clinic_proc_view==0 &&$clinic_proc_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>Clinic Procedures</td>
                    <td><input class="form-check-input" type="radio" name="clinic_procedures" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="clinic_procedures" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="clinic_procedures" value="0"'.$none.'/></td>
                </td>';

                ////////////////
                $viewEdit='';$view='';$none='';
                if($patient_rec_edit ==1)
                    $viewEdit='checked';
                else if($patient_rec_view==1)
                    $view='checked';
                else if($patient_rec_view==0 &&$patient_rec_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>Patient Records</td>
                    <td><input class="form-check-input" type="radio" name="patient_records" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="patient_records" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="patient_records" value="0"'.$none.'/></td>
                </td>';

                ////////////////
                $viewEdit='';$view='';$none='';
                if($sched_cal_edit ==1)
                    $viewEdit='checked';
                else if($sched_cal_view==1)
                    $view='checked';
                else if($sched_cal_view==0 &&$sched_cal_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>Schedule Calendar</td>
                    <td><input class="form-check-input" type="radio" name="schedule_calendar" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="schedule_calendar" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="schedule_calendar" value="0"'.$none.'/></td>
                </td>';
                ////////////////
                $viewEdit='';$view='';$none='';
                if($app_req_edit ==1)
                    $viewEdit='checked';
                else if($app_req_view==1)
                    $view='checked';
                else if($app_req_view==0 &&$app_req_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>Appointment Requests</td>
                    <td><input class="form-check-input" type="radio" name="appointment_requests" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="appointment_requests" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="appointment_requests" value="0"'.$none.'/></td>
                </td>';
                ////////////////
                $viewEdit='';$view='';$none='';
                if($user_manage_edit ==1)
                    $viewEdit='checked';
                else if($user_manage_view==1)
                    $view='checked';
                else if($user_manage_view==0 &&$user_manage_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>User Management</td>
                    <td><input class="form-check-input" type="radio" name="user_management" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="user_management" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="user_management" value="0"'.$none.'/></td>
                </td>';
                ////////////////
                $viewEdit='';$view='';$none='';
                if($settings_edit ==1)
                    $viewEdit='checked';
                else if($settings_view==1)
                    $view='checked';
                else if($settings_view==0 &&$settings_edit==0)
                    $none='checked';
                $append.=
                '<tr>
                    <td>Settings</td>
                    <td><input class="form-check-input" type="radio" name="settings" value="2"'.$viewEdit.'/></td>
                    <td><input class="form-check-input" type="radio" name="settings" value="1"'.$view.'/></td>
                    <td><input class="form-check-input" type="radio" name="settings" value="0"'.$none.'/></td>
                </td>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input type="submit" class="btn custom-modal-btn" id="permission_save" value="Save"/>
                    <td>
                        <button type="button" class="btn custom-modal-btn" id="permission_cancel"">Cancel</button>
                    </td>
                </tr>
                </table>
                </form>
                </div>';
                
                return $append;
            }
            return $data;
        }

        public function userListTable()
        {
            $data=$this->getUserList();
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No users yet 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                $counter=0;
                $append='
                        <br>
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-8">
                                <h5>
                                    <i class="bi bi-person-lines-fill"></i>
                                    <span>User Accounts</span>
                                </h5>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4">
                                <button class="btn" id="add-user-btn">
                                    <span><i class="bi bi-person-plus-fill"></i></span>
                                    <span class="text-uppercase small ms-1">New User</span>
                                </button>
                            </div>
                        </div>
                        <table class="table table-borderless" id="users-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th></th>
                                    <th scope="col" style="width: 60%" class="text-uppercase tbl-th">Username</th>
                                    <th scope="col" style="width: 20%" class="text-uppercase tbl-th">Email</th>
                                    <th scope="col" style="width: 10%" class="text-uppercase tbl-th">Role</th>
                                    <th scope="col" style="width: 10%" class="text-uppercase tbl-th">Action</th>
                                </tr>
                            </thead>';
                while($counter<$length)
                {
                    $append.='
                            <tr>
                                <td></td>
                                <td class="fw-bold">'.$data[$counter]['username'].'</td>
                                <td class="fw-bold">'.$data[$counter]['email'].'</td>
                                <td class=" text-capitalize">'.$data[$counter]['role_desc'].'</td>
                                <td>
                                    <a id="'.$data[$counter]["id"].'" class="user-role-edit"><i class="bi bi-pencil-fill"></i></a>';
                    if($_SESSION['role']==1)
                    {
                        if($data[$counter]['role']!=1)
                        {
                            $append.='<a id="'.$data[$counter]["id"].'" class="user-remove"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>';
                        }
                    }
                                    
                                
                    $counter++;
                }
                $append.='</table></div>';
                return $append;
            }
            return $data;
        }

        public function init_roles($isadd)
        {
            $data=$this->initRoles();
            $length=sizeof($data);
            $counter=0;
            $add='';
            if($isadd==1)
            {
                $add="-add";
            }
            $append='
            <select name="user-role-select'.$add.'" class="user-role-select'.$add.' form-select text-capitalize" id="user-role-select'.$add.'" required>
            <option value="" selected disabled>Select Role</option>';
            
            while($counter<$length)
            {
                $append.='<option value="'.$data[$counter]['id'].'">'.$data[$counter]['role_desc'].'</option>';
                $counter++;
            }
            $append.='</select>';
            return $append;
        }

        
        //////////////// clinic

        public function clinic_proc_table()
        {
            $data=$this->clinicProcTable();
            if($data==0)
            {
                return '<br>
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <button class="btn" id="add-proc-btn">
                            <span><i class="bi bi-plus-circle-fill"></i></span>
                            <span class="text-uppercase small ms-1">Procedure</span>
                        </button>
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No procedures yet
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                $counter=0;
                $append='
                        <br>
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-4">
                                <button class="btn" id="add-proc-btn">
                                    <span><i class="bi bi-plus-circle-fill"></i></span>
                                    <span class="text-uppercase small ms-1">Procedure</span>
                                </button>
                            </div>
                        </div>
                        <table class="table table-borderless" id="proc-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th></th>
                                    <th scope="col" style="width: 1%" class="text-uppercase tbl-th">#</th>
                                    <th scope="col" style="width:40%" class="text-uppercase tbl-th">Procedure</th>
                                    <th scope="col" style="width:40%" class="text-uppercase tbl-th">Branch</th>
                                    <th scope="col" style="width: 19%" class="text-uppercase tbl-th">Action</th>
                                </tr>
                            </thead>';
                while($counter<$length)
                {
                    $append.='
                            <tr>
                                <td></td>
                                <td class="fw-bold">'.$data[$counter]['id'].'</td>
                                <td class=" text-capitalize">'.$data[$counter]['proc_name'].'</td>
                                <td class=" text-capitalize">'.$data[$counter]['branch_name'].'</td>
                                <td>
                                    <a id="'.$data[$counter]["id"].'" class="proc-edit"><i class="bi bi-pencil-fill"></i></a>
                                    <a id="'.$data[$counter]["id"].'" class="proc-remove"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>';
                    $counter++;
                }
                $append.='</table></div>';
                return $append;
            }
            return $data;
        }

        public function clinic_branch_table()
        {
            $data=$this->clinicBranchTable();
            if($data==0)
            {
                return '<br>
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <button class="btn" id="add-branch-btn">
                            <span><i class="bi bi-plus-circle-fill"></i></span>
                            <span class="text-uppercase small ms-1">Branch</span>
                        </button>
                    </div>
                </div>
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No patients yet 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                $counter=0;
                $append='
                        <br>
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-4">
                                <button class="btn" id="add-branch-btn">
                                    <span><i class="bi bi-plus-circle-fill"></i></span>
                                    <span class="text-uppercase small ms-1">Branch</span>
                                </button>
                            </div>
                        </div>
                        <table class="table" id="branch-table">
                            <caption></caption>
                            <thead class="thead theader">
                                <tr>
                                    <th></th>
                                    <th scope="col" style="width: 1%" class="text-uppercase tbl-th">#</th>
                                    <th scope="col" style="width:80%" class="text-uppercase tbl-th">Branch Name</th>
                                    <th scope="col" style="width: 19%" class="text-uppercase tbl-th">Action</th>
                                </tr>
                            </thead>';
                while($counter<$length)
                {
                    $append.='
                            <tr>
                                <td></td>
                                <td class="fw-bold">'.$data[$counter]['id'].'</td>
                                <td class=" text-capitalize">'.$data[$counter]['branch_name'].'</td>
                                <td>
                                    <a id="'.$data[$counter]["id"].'" class="branch-edit"><i class="bi bi-pencil-fill"></i></a>
                                    <a id="'.$data[$counter]["id"].'" class="branch-remove"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>';
                    $counter++;
                }
                $append.='</table></div>';
                return $append;
            }
            return $data;
        }


        public function init_branches($isadd)
        {
            $data=$this->initBranches();
            $length=sizeof($data);
            $counter=0;
            $add='';
            if($isadd==1)
            {
                $add="-add";
            }
            $append='
            <select name="clinic-branch-select'.$add.'" class="clinic-branch-select'.$add.' form-select text-capitalize" id="clinic-branch-select'.$add.'" required>
            <option value="" selected disabled>Select Branch</option>';
            
            while($counter<$length)
            {
                $append.='<option value="'.$data[$counter]['id'].'">'.$data[$counter]['branch_name'].'</option>';
                $counter++;
            }
            $append.='</select>';
            return $append;
        }

        public function fetch_existing_patients()
        {
            $data=$this->fetchExistingPatients();
            $length=sizeof($data);
            $counter=0;
            $append='';
            while($counter<$length)
            {
                $append.='<option value="'.$data[$counter]['name'].'" id="'.$data[$counter]['id'].'">';
                $counter++;
            }
            return $append;
        }

        public function fetch_patient_schedule($pid)
        {
            $data=$this->fetchPatientSchedule($pid);
            if($data==0)
            {
                return '
                <div class="container d-flex justify-content-center align-items center" >
                    <p class="text-uppercase text-center fw-bold my-5"  id="message"> No Active Schedule 
                </div><div class="text-center"><img src="images/empty-search.png" width="200" height="153"></div>';
            }
            else
            {
                $length=sizeof($data);
                $counter=0;
                $append='
                    <br>
                    <div class="table-responsive">
                    <table class="table table-borderless" id="patient-schedule">
                        <caption></caption>';
                while($counter<$length)
                {
                    $time=strtotime($data[$counter]['start_event']);
                    $date=date('F j, Y',$time);
                    $status="";
                    $class="";
                    switch($data[$counter]['status'])
                    {
                        case 11:
                            $status="Scheduled";
                            $class="sc-sched";
                            $append.='<tr class="'.$class.'">
                            <td class="small">
                                <a id="'.$data[$counter]["sched_id"].'" class="patient-schedule-done"><i class="bi bi-check-circle-fill check-schedule"></i></a>
                                <a id="'.$data[$counter]["sched_id"].'" class="patient-schedule-failed"><i class="bi bi-calendar-x-fill failed-schedule"></i></a>
                            </td>';
                            break;
                        case 12:
                            $status="No Show";
                            $class="sc-noshow";
                            $append.='<tr class="'.$class.'"><td>';
                            break;
                        case 13:
                            $status="Done";
                            $class="sc-done";
                            $append.='<tr class="'.$class.'"><td>';
                            break;
                    }
                    $append.='
                                <td class="small">'.$date.'</td>
                                <td class="small">'.$status.'</td>
                                <td>
                                    <a id="'.$data[$counter]["sched_id"].'" class="patient-schedule-rm"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>';
                    $counter++;
                }
                $append.='</table></div>';
                return $append;
            }
        }

        public function fetch_files($id)
        {
            $check=$this->checkFiles($id);
            $modal='
                <div id="fileUploadModal" class="modal fade">  
                        <div class="modal-dialog">  
                            <div class="modal-content custom-modal">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold small text-uppercase ModalLabel">Select File</h5>
                            </div>
                                <div class="modal-body" id="file-form"> 
                                    <form class="file-form" action="includes/record/patient-file-upload.php" method="post" enctype="multipart/form-data">
                                        <div class="image-wrapper text-center">
                                        <input type="hidden" name="upload_pid" id="upload_pid" class="upload_pid" /> 
                                        <label for="file" class="custom-file-upload-admin">
                                            <img class="item-image-upload" id="item-image-upload" src="images/default-none.png" height="200px" width="200px" >
                                            <input type="file" name="file" id="file" onchange="loadfile(event)" required/> </br>
                                        </label>
                                        </div>
                                        </br>
                                        <input class="form-control" id="image-title" name="image-title" type="text" placeholder="Title" required/>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn custom-modal-btn" name="submit">Upload</button>   
                                            <button type="button" class="btn custom-modal-btn" id="upload-cancel" data-bs-dismiss="modal">Close</button> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> 
                </div>';  
            if($check==0)
            {
                $append=$modal.'<div class="addfile">
                                    <p class="text-center fw-bold text-uppercase fileheader">It looks like this patient doesn\'t have any images yet..</p>
                                    <div class="d-flex justify-content-center">
                                        <img class="item-image" id="item-image" src="images/default-add.png" height="200px" width="200px" >
                                    </div>
                                </div>';
            }
            else
            {
                $data=$this->fetchFiles($id);
                $length=sizeof($data);
                $counter=0;

                $cards_per_row=4;
                $added_cards=0;
                $append=$modal.'<div class="addfile">
                                <p class="text-center fw-bold text-uppercase fileheader">Patient Gallery</p>
                                <div class="d-flex justify-content-center">
                                    <img class="item-image" id="item-image" src="images/default-add.png" height="80px" width="80px" >
                                </div>
                            </div>
                        <hr>
                <div class="row">';

                while($counter<$length){
                //-lg-3 col-md-6 col-sm-12 col-xs-12
                $append.='
                    <div class="col">
                        <div class="card-item text-center">
                        <span class="close"><a class="delete_image" id="'.$data[$counter]["image_id"].'"><i class="bi bi-x-circle-fill"></i></a></span>
                            <div class="image">
                                <a href="'.$data[$counter]['url'].'" target="_blank"><img class="patient-image" src="'.$data[$counter]["url"].'" height="150px" width="150px" /></a>
                            </div>
                            <p class="card-text">'.$data[$counter]["title"].'</p>
                        </div>
                    </div>
                    ';
                    $added_cards++;
                    if($added_cards==$cards_per_row)
                    {
                        $append.= '</div>
                        <div class="row">';
                        $added_cards=0;
                    }
                    $counter++;
                }
                $append.='</div><div class="spacer"></div>';
            }
            $script='<script>function loadfile(event){
                var output=document.getElementById("item-image-upload");
                output.src=URL.createObjectURL(event.target.files[0]);
              };</script>';
            return $append.$script;
        }
    }
?>