<?php
    // explode fuction will split a stirng into an array
    include_once("/var/www/html/functions.php");
    $dblink=sessions_db_connect("ValadezSessions"); 
    
    $username="";

    // get current session id
    $sql = "SELECT `session_id` FROM `Sessions` WHERE `auto_id` = (SELECT MAX(`auto_id`) FROM `Sessions`) AND `status` = 'open'";
    $result=$dblink->query($sql) or
        die("Something went wrong with $sql<br>".$dblink->error);
    $data=$result->fetch_array(MYSQLI_ASSOC);
    $sid=$data['session_id'];

    // get file names from database
    $sql = "SELECT `file_name` FROM `Files` WHERE `status` = 'not_used'";
    $result=$dblink->query($sql) or
        die("Something went wrong with $sql<br>".$dblink->error);
    while ($data=$result->fetch_array(MYSQLI_ASSOC)){
        $file_name = $data['file_name'];
        $tmp = explode("/", $file_name);
        $file = $tmp[4];
        echo "File: $file\r\n";

        // use curl to fetch each file 
        $request = "sid=$sid&uid=$username&fid=$file";

        $ch=curl_init('https://----.com/api/request_file');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded', 
            'content-length: ' . strlen($request))
        );

        $time_start = microtime(true);
        $fetch_result = curl_exec($ch);
        $time_end = microtime(true);
        $exec_time = ($time_end - $time_start)/60;
        $content = $fetch_result;
        curl_close($ch);

        // write to file system
        $fp=fopen("/var/www/html/receive/$file","wb");
        fwrite($fp,$content);
        fclose($fp);
        echo "$file written to file system \r\n\r\n";
    }
?>