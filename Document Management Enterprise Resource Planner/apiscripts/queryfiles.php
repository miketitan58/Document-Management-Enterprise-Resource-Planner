<?php
    // explode fuction will split a stirng into an array
    include_once("/var/www/html/functions.php");
    $dblink=sessions_db_connect("ValadezSessions"); 

    $username="";

    // get session id
    $sql = "SELECT `session_id` FROM `Sessions` WHERE `auto_id` = (SELECT MAX(`auto_id`) FROM `Sessions`) AND `status` = 'open'";
    $result=$dblink->query($sql) or
        die("Something went wrong with $sql<br>".$dblink->error);
    $data=$result->fetch_array(MYSQLI_ASSOC);
    $sid=$data['session_id'];

    echo "Session id: \"$sid\"\r\n";

    $data = "sid=$sid&uid=$username";
    $ch=curl_init('https://----.com/api/query_files');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/x-www-form-urlencoded', 
        'content-length: ' . strlen($data))
    );

    $time_start = microtime(true);
    $result = curl_exec($ch);
    $time_end = microtime(true);
    $exec_time = ($time_end - $time_start)/60;
    curl_close($ch);
    $cinfo=json_decode($result,true);

    if($cinfo[0] == "Status: OK"){
        if($cinfo[2] == "Action: None"){
            echo "No new files to import\r\n";
            echo "Query Files execution time: $exec_time";
        }
        else{
            $tmp = explode(":" , $cinfo[1]);
            $files = explode("," , $tmp[1]);
            echo "Number of files to import: ".count($files)."\r\n";
            echo "Files:\r\n";
            foreach($files as $key=>$value){
                $file_name = trim($value);
                echo $file_name."\r\n";
                // add file name into database
                $sql = "INSERT INTO `Files` (`file_name`,`status`) VALUES ('$file_name','not_used')";
                $dblink->query($sql) or
                    die("Something went wrong with $sql<br>".$dblink->error);
            }
            echo "Query files execution time: $exec_time\r\n";    
        }
    }
    else{ // error
        echo "$cinfo[0]";
        echo "\r\n";
        echo "$cinfo[1]";
        echo "\r\n";
        echo "$cinfo[2]";
        echo "\r\n";
        // send error to database
        $sql = "INSERT INTO `Error_Log` (`error_message`,`action`) VALUES ('$cinfo[1]','$cinfo[2]')";
        $dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
    }
?>