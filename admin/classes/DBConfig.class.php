<?php 
// use this file to configure database connection
    class DBConfig
    {
        
        // CHANGE THIS -- DB CONFIG
        private $server="localhost";
        private $db="testing";
        private $user="root";
        private $pass="";
        
        protected function dbConnect()
        {
            $conn=new mysqli(
                $this->server,
                $this->user,
                $this->pass,
                $this->db);
            return $conn;
        }
    }
?>