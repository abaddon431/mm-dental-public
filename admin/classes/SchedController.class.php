<?php

    class SchedController extends SchedModel
    {
        //for schedule calendar
        public function insert_event($title,$start,$end,$id)
        {
            $this->insertEvent($title,$start,$end,$id);
            $str= json_encode("Event has been added to your schedule.");
            echo trim($str,'"');
        }
        public function insert_new($fname,$lname,$contact,$start,$end)
        {
            $data=$this->insertNew($fname,$lname,$contact,$start,$end);
            return $data;
        }
        
        public function check_overlap($start,$hours,$minutes,$set_span)
        {
            $code=$this->checkOverlap($start,$hours,$minutes,$set_span);
            return $code;
        }
        public function update_overlap($id,$calendar,$hour,$minute,$endcalendar,$endhour,$endminute,$set_span)
        {
            $code=$this->updateOverlap($id,$calendar,$hour,$minute,$endcalendar,$endhour,$endminute,$set_span);
            return $code;
        }
        public function delete_event($id)
        {
            $this->deleteEvent($id);
            $str= json_encode("Event Removed");
            echo trim($str,'"');
        }
        public function update_event(EventParams $event_params)
        {
            $this->updateEvent($event_params);
            $str= json_encode("Schedule Updated");
            echo trim($str,'"');
        }
        //for handling requests
        public function request_insert($name,$email,$date)
        {
            $this->requestInsert($name,$email,$date);
            $str= json_encode("Your appointment request has been sent!");
            echo trim($str,'"');
        }
        public function request_delete($id)
        {
            return $this->requestDelete($id);
        }
        public function request_accept(EventParams $event_params)
        {
            $this->requestAccept($event_params);
            $str=json_encode("Appointment added to the schedule!");
            echo trim($str,'"');
        }

        public function accept_existing($req_id,$id,$name,$start,$end)
        {
            echo $this->acceptExisting($req_id,$id,$name,$start,$end);
        }
        public function accept_new($req_id,$fname,$lname,$start,$end,$contact)
        {
            echo $this->acceptNew($req_id,$fname,$lname,$start,$end,$contact);
        }
        //
        
        private function send_sms($number,$message,$apicode,$passwd)
        {
            $url = 'https://www.itexmo.com/php_api/api.php';
            $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
            $param = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($itexmo),
                ),
            );
            $context  = stream_context_create($param);
            return file_get_contents($url, false, $context);
        }
        public function send_sms_proper($number,$message,$apicode,$passwd)
        {
            $result=$this->send_sms($number,$message,$apicode,$passwd);
            if ($result == "")
            {
                echo "iTexMo: No response from server!!!
                Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
                Please CONTACT US for help. ";	
            }
            else if ($result == 0)
            {
                echo " \r\n Patient has been notified";
            }
            else
            {	
                $message="\r\nPatient cannot be notified: ";
                switch($result)
                {
                    case 1:
                        $message.="Invalid Number";
                        break;
                    case 2:
                        $message.="Number prefix is not supported.";
                        break;
                    case 3:
                        $message.="Invalid ApiCode";
                        break;
                    case 4:
                        $message.="Maximum Message per day reached. This will be reset every 12MN.";
                        break;
                    case 5:
                        $message.="Maximum allowed characters for message reached.";
                        break;
                    case 6:
                        $message.="System OFFLINE.";
                        break;
                    case 7:
                        $message.="Expired ApiCode.";
                        break;
                    case 8:
                        $message.="iTexMo Error. Please try again later.";
                        break;
                    case 9:
                        $message.="Expired ApiCode.";
                        break;
                    case 10:
                        $message.="Recipient's number is blocked due to FLOODING, message was ignored.";
                        break;
                    case 11:
                        $message.="Recipient's number is blocked temporarily due to HARD sending (after 3 retries of sending and message still failed to send) and the message was ignored. Try again after an hour.";
                        break;
                    case 16:
                        $message.="Authentication error. Contact support at support@itexmo.com";
                        break;
                    case 17:
                        $message.="Telco Error. Contact Support support@itexmo.com";
                        break;
                    case 18:
                        $message.="Message Filtering Enabled. Contact Support support@itexmo.com";
                        break;
                    case 19:
                        $message.="Account suspended. Contact Support support@itexmo.com";
                        break;
                    default:
                        break;
                }
                echo $message;
            }
        }

        public function count_appointment()
        {
            echo $this->countAppointment();
        }
        public function count_today($date)
        {
            echo $this->countToday($date);
        }
        public function count_patients()
        {
            echo $this->countPatients();
        }
    }

?>