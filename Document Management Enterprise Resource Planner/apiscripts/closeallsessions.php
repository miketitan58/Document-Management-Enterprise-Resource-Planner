<?php
    include_once("/var/www/html/functions.php");
    $dblink=db_connect("ValadezSessions"); 
 
    // login info 
    $username="";
    $passwd=""; 
    $login="username=$username&password=$passwd";

    $data = "sid=$sid&uid=$username";
    $ch=curl_init('https://----.com/api/clear_session');
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

    // check to see if session closed successfully
    if($cinfo[0] == "Status: OK"){
        echo "Session Closed Successfully!\r\n";
        echo "Session id: $sid\r\n";
        echo "Close Session execution time: $exec_time\r\n";
        // set status to closed
        $sql = "UPDATE `Sessions` SET `status` = 'closed' WHERE `session_id` = '$sid'"; 
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
    }
    else{
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

    // get session id
    $sql = "SELECT `session_id` FROM `Sessions` WHERE `status` = 'open'";
    $result=$dblink->query($sql) or
        die("Something went wrong with $sql<br>".$dblink->error);
    while ($data=$result->fetch_array(MYSQLI_ASSOC)){
        // close any session that is still open 
        
    }
?>