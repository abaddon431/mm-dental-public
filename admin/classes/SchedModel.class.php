<?php

    class SchedModel extends DBConfig
    {
        //schedule calendar
        protected function loadEvents()
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
                return 0;
            }
            $data=array();
            $sql = "SELECT * FROM events WHERE status=11 ORDER BY id";
            $result=(mysqli_query($conn,$sql));

            while($row=mysqli_fetch_assoc($result)){
                $data[]=array(
                    'id'=> $row['id'],
                    'title'=> $row['title'],
                    'start'=> $row['start_event'],
                    'end'=> $row['end_event']
                );
            }
            $conn->close();
            return $data;
        }
        protected function insertEvent($title,$start,$end,$id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else if(isset($title))
            {
                $query = "INSERT INTO events (title, start_event, end_event) 
                VALUES (?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('sss',$title,$start,$end);
                $stmt->execute();
                $last_id=$conn->insert_id;
                
                $query2="INSERT INTO patients_schedule (patient_id,event_id) VALUES ($id,$last_id)";
                $stmt2 = $conn->prepare($query2);
                $stmt2->execute();
                $conn->close();
            }
        }

        protected function insertNew($fname,$lname,$contact,$start,$end)
        {
            $conn=$this->dbConnect();
            $title=$fname." ".$lname;
            if ($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else if(isset($title))
            {
                $query="INSERT INTO `patients_tbl`(fname,lname,contactno) VALUES (?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('sss',$fname,$lname,$contact);
                if($stmt->execute())
                {
                    $patient_id=$conn->insert_id;
                    $query="INSERT INTO events (title, start_event, end_event) 
                    VALUES (?,?,?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('sss',$title,$start,$end);
                    if($stmt->execute())
                    {
                        $event_id=$conn->insert_id;
                        $query2="INSERT INTO patients_schedule (patient_id,event_id) VALUES ($patient_id,$event_id)";
                        $stmt2 = $conn->prepare($query2);
                        if($stmt2->execute())
                        {
                            return "Successfully Added new patient and Created a new schedule";
                        }
                        else
                        {  
                           return "There was a problem in adding schedule into patient records"; 
                        }
                    }
                    else
                    {
                        return "There was a problem adding a new event into the calender";
                    }
                }
                else
                {
                    return "There was a problem in adding patient into the records";
                }
                $conn->close();
            }
        }

        protected function checkOverlap($start,$hours,$minutes,$set_span)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $query = "SELECT start_event FROM events WHERE start_event LIKE '$start%' AND status=11;";
                if($result=mysqli_query($conn,$query))
                {
                    $data="";
                    $overlap=0;
                    $row_count=mysqli_num_rows($result);
                    if($row_count>0)
                    {
                        
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $initial=new DateTime($row['start_event']);
                            $init_hours=$initial->format("H");
                            $init_min=$initial->format("i");
                            $d1=abs($init_hours-$hours)+abs(($init_min-$minutes)/60);
                            $d2=abs($init_hours-$hours)-abs(($minutes-$init_min)/60);
                            if($hours==$init_hours)
                            {
                                $overlap+=1;
                            }
                            else
                            {
                                if($init_min>$minutes)
                                {
                                    if($d2<$set_span)
                                    {
                                        $overlap+=1;
                                    }
                                }
                                else
                                {
                                    if($d1<$set_span)
                                    {
                                        $overlap+=1;
                                    }
                                }
                            }
                            $data.=$init_hours.":".$init_min." - ".$hours.":".$minutes." | ".$d2;
                        }
                        $data.=$overlap;
                    }
                }
                return $overlap;
            }
        }
        protected function updateOverlap($id,$start,$hours,$minutes,$endcalendar,$endhour,$endminute,$set_span)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $query = "SELECT start_event,end_event FROM events WHERE start_event LIKE '$start%' AND status=11 AND NOT id=$id;";
                if($result=mysqli_query($conn,$query))
                {
                    $data="";
                    $overlap=0;
                    $row_count=mysqli_num_rows($result);
                    if($row_count>0)
                    {
                        
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $initial=new DateTime($row['start_event']);
                            $init_hours=$initial->format("H");
                            $init_min=$initial->format("i");

                            $binitial=new DateTime($row['end_event']);
                            $binit_hours=$binitial->format("H");
                            $binit_min=$binitial->format("i");

                            $d1=abs($init_hours-$hours)+abs(($init_min-$minutes)/60);
                            $d2=abs($init_hours-$hours)-abs(($minutes-$init_min)/60);


                            $endtotal=abs($endhour)+abs($endminute/60);
                            $starttotal=abs($init_hours)+abs($init_min/60);

                            $bstarttotal=abs($hours)+abs($minutes/60);
                            $bendtotal=abs($binit_hours)+abs($binit_min/60);

                            if($hours==$init_hours)
                            {
                                $overlap+=1;
                            }
                            else
                            {
                                if($init_min>$minutes)
                                {
                                    if($d2<$set_span)
                                    {
                                        $overlap+=1;
                                    }
                                }
                                else
                                {
                                    if($d1<$set_span)
                                    {
                                        $overlap+=1;
                                    }
                                }
                            }
                            $data.=$init_hours.":".$init_min." - ".$hours.":".$minutes." | ".$d2;
                        }
                        $data.=$overlap;
                    }
                }
                return $overlap;
            }
        }
        protected function deleteEvent($id)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else if(isset($id))
            {
                $query = "UPDATE events SET status=10 WHERE id=$id";
                $statement = $conn->prepare($query);
                $statement->execute();
                $conn->close();
            }
        }
        protected function updateEvent(EventParams $event_params)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error) 
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else if(isset($event_params->id_event))
            {
                $query = "UPDATE events 
                SET title='$event_params->title_event', start_event='$event_params->start_event', end_event='$event_params->end_event' 
                WHERE id=$event_params->id_event";
                $statement = $conn->prepare($query);
                $statement->execute();
                $conn->close();
            }
        }





        
        //handling appointment requests

        protected function requestInsert($name,$email,$date)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $query="INSERT INTO ap_requests(name,start,email)
                VALUES(?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('sss',$name,$date,$email);
                $stmt->execute();
                $conn->close();
            }
        }
        protected function requestFetch($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $query = "SELECT * FROM ap_requests WHERE id = $id";  
                $result = mysqli_query($conn, $query);  
                $row = mysqli_fetch_array($result);
                $conn->close();
                return $row;
            }
        }
        protected function requestDelete($id)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }
            else{
                $sql="SELECT CONCAT(fname,' ',lname) as fullname, email FROM ap_requests WHERE id=$id";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_array($result);

                $sql="UPDATE ap_requests SET status=8 WHERE id=$id";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $conn->close();
                return $row;
            }
        }
        protected function requestAccept(EventParams $event_params)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $remove_request="UPDATE ap_requests SET status=7 WHERE id=$event_params->id_event";
                $remove_stmt=$conn->prepare($remove_request);
                $remove_stmt->execute();

                $insert = "INSERT INTO events(title, start_event, end_event)
                VALUES ('$event_params->title_event','$event_params->start_event','$event_params->end_event')";
                $insert_stmt=$conn->prepare($insert);
                $insert_stmt->execute();
                $conn->close();
            }
        }
        protected function acceptExisting($req_id,$id,$name,$start,$end)
        {
            $conn=$this->dbConnect();
            if ($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else if(isset($name))
            {
                $remove_request="UPDATE ap_requests SET status=7 WHERE id=$req_id";
                $remove_stmt=$conn->prepare($remove_request);
                if($remove_stmt->execute())
                {
                    $query = "INSERT INTO events (title, start_event, end_event) 
                    VALUES (?,?,?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('sss',$name,$start,$end);
                    if($stmt->execute())
                    {
                        $last_id=$conn->insert_id;
                        $query2="INSERT INTO patients_schedule (patient_id,event_id) VALUES ($id,$last_id)";
                        $stmt2 = $conn->prepare($query2);
                        if($stmt2->execute())
                        {
                            return "Appointment successfully booked!";
                        }
                        else
                        {
                            return "Failed to add appointment";
                        }
                    }
                    else
                    {
                        return "cannot add appointment to the calendar";
                    }
                }
                else
                {
                    return "There was a problem inserting the schedule";
                }
                $conn->close();
            }
        }
        protected function acceptNew($req_id,$fname,$lname,$start,$end,$contact)
        {
            $conn=$this->dbConnect();
            $title=$fname." ".$lname;
            if ($conn->connect_error)
            {
                die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }
            else
            {
                $remove_request="UPDATE ap_requests SET status=7 WHERE id=$req_id";
                $remove_stmt=$conn->prepare($remove_request);
                if($remove_stmt->execute())
                {
                    $query="INSERT INTO `patients_tbl`(fname,lname,contactno) VALUES (?,?,?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('sss',$fname,$lname,$contact);
                    if($stmt->execute())
                    {
                        $patient_id=$conn->insert_id;
                        $query="INSERT INTO events (title, start_event, end_event) 
                        VALUES (?,?,?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('sss',$title,$start,$end);
                        if($stmt->execute())
                        {
                            $event_id=$conn->insert_id;
                            $query2="INSERT INTO patients_schedule (patient_id,event_id) VALUES ($patient_id,$event_id)";
                            $stmt2 = $conn->prepare($query2);
                            if($stmt2->execute())
                            {
                                return "Successfully Added new patient and Created a new schedule";
                            }
                            else
                            {  
                            return "There was a problem in adding schedule into patient records"; 
                            }
                        }
                        else
                        {
                            return "There was a problem adding a new event into the calender";
                        }
                    }
                    else
                    {
                        return "There was a problem in adding patient into the records";
                    }
                }
                else
                {
                    return "There was a problem in removing the appointment request";
                }
                $conn->close();
            }
        }
        protected function requestTableFetch()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT count(1) FROM ap_requests WHERE status=6");
                $rows=mysqli_fetch_array($count_rows);
                $total=$rows[0];
                if($total==0)
                {
                    $conn->close();
                    return $total;
                }
                else
                {
                    $data=array();
                    $sql=mysqli_query($conn,"SELECT id,CONCAT(fname,' ',lname) as name,start,email FROM ap_requests WHERE status=6");
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        $data[]=array(
                            'id'=>$row['id'],
                            'name'=>$row['name'],
                            'start'=>$row['start'],
                            'email'=>$row['email'],
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }
        
        protected function requestTableSearch($text)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $count_rows=mysqli_query($conn,"SELECT count(1) FROM ap_requests WHERE status=6");
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
                        $sql=mysqli_query($conn,"SELECT id,CONCAT(fname,' ',lname) as name,start,email FROM ap_requests WHERE status=6 AND (lname LIKE '%".$text."%' OR fname LIKE '%".$text."%')");
                    }
                    else{
                        $sql=mysqli_query($conn,"SELECT id,CONCAT(fname,' ',lname) as name,start,email FROM ap_requests WHERE status=6");
                    }
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        $data[]=array(
                            'id'=>$row['id'],
                            'name'=>$row['name'],
                            'start'=>$row['start'],
                            'email'=>$row['email'],
                        );
                    }
                    $conn->close();
                    return $data;
                }
            }
        }
        protected function countAppointment()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $query = "SELECT COUNT(1) FROM ap_requests WHERE status=6";  
                $result = mysqli_query($conn, $query);  
                $row = mysqli_fetch_array($result);
                $conn->close();
                return $row[0];
            }
        }

        protected function countToday($date)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $query = "SELECT COUNT(1) FROM events WHERE start_event LIKE '$date%' AND status=11";  
                $result = mysqli_query($conn, $query);  
                $row = mysqli_fetch_array($result);
                $conn->close();
                return $row[0];
            }
        }
        protected function countPatients()
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $query = "SELECT COUNT(1) FROM patients_tbl WHERE status=4";  
                $result = mysqli_query($conn, $query);  
                $row = mysqli_fetch_array($result);
                $conn->close();
                return $row[0];
            }
        }

    }
?>