<?php
    include_once("/var/www/html/functions.php");
    $dblink=sessions_db_connect("ValadezSessions"); 

    // login info 
    $username="";
    $passwd=""; 
    $login="username=$username&password=$passwd";

    // use curl to get a session id
    $ch=curl_init('https://----.com/api/create_session');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $login);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/x-www-form-urlencoded', 
        'content-length: ' . strlen($login))
    );

    $time_start = microtime(true);
    $result = curl_exec($ch);
    $time_end = microtime(true);
    $exec_time = ($time_end - $time_start)/60;
    curl_close($ch);
    $cinfo=json_decode($result,true);

    // check if session was created
    if($cinfo[0] == "Status: OK" && $cinfo[1] == "MSG: Session Created"){
        $sid = $cinfo[2];
        echo "Session Created Successfully!\r\n";
        echo "Session ID: $sid\r\n";
        // upload session id to database
        $sql = "INSERT INTO `Sessions` (`session_id`,`status`) VALUES ('$sid','open')";
        $dblink->query($sql) or
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
        // if error is "previous session found" close the previous session
        if ($cinfo[1] == "MSG: Previous Session Found") {
            echo "closing old session...\r\n";
            include("closesession.php");
        }
    }
?>