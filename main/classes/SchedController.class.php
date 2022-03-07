<?php

    class SchedController extends SchedModel
    {
        public function request_insert($fname,$lname,$email,$date)
        {
            echo $this->requestInsert($fname,$lname,$email,$date);
        }
    }

?>