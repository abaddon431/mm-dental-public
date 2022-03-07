<?php
    // CHANGE THIS -- DB CONFIG of remote database
    $server="SERVER_IP";
    $db="SERVER_DB";
    $user="SERVER_USER";
    $pass="SERVER_PASSWORD";
    $conn=new mysqli($server,$user,$pass,$db);
    if($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
        echo 'Connected to remote MYSQl Successfully!';
        //CHANGE THIS --  CHANGE DIRECTORY ACCORDINGLY
        $command='(XAMPP/DIRECTORY/bin/mysqldump -u '.$user.' -p'.$pass.' --host='.$server.' '.$db.' ap_requests --where="status=6" --no-create-info --compact> DUMP/DIRECTORY/request.sql)';
        
        exec("$command 2>&1", $output, $result);

        $sql="UPDATE ap_requests SET status=9 WHERE status=6";
        $conn->query($sql);
        if($conn->query($sql)===TRUE)
        {
            $conn->close();
            //CHANGE THIS -- DB CONFIG of LOCAL database
            $new_server="localhost";
            $new_user="root";
            $new_passwd="";
            $new_db="testing";
            $conn2=new mysqli($new_server,$new_user,$new_passwd,$new_db);

            $templine = '';
            // Read in entire file
            $file='request.sql';
            $root="DUMP/DIRECTORY/";
            $lines = file($root.$file);
            // Loop through each line
            foreach ($lines as $line)
            {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;
                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    // Perform the query
                    $conn2->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . $conn2->error . '<br /><br />');
                    // Reset temp variable to empty
                    $templine = '';
                }
            }
            if($conn2->affected_rows>=1)
            {
                echo 'Requests updated!';
                $conn2->close();
            }
            else
            {
                $conn2->close();
            }
        }
        else
        {
            echo "Error updating records: ".$conn->error;
            $conn->close();
        }
    }
    
?>