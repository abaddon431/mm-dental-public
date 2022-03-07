<?php

    class SchedModel extends DBConfig
    {
        protected function requestInsert($fname,$lname,$email,$date)
        {
            $conn=$this->dbConnect();
            if($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
                $query="INSERT INTO ap_requests(fname,lname,start,email)
                VALUES(?,?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ssss',$fname,$lname,$date,$email);
                if($stmt->execute())
                {
                    $conn->close();
                    return "Your appointment request has been sent!";
                }
                else
                {
                    $conn->close();
                    return "There was an error in processing your request :(";
                }
            }
        }
    }
?>