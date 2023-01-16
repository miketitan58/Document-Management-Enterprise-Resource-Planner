<?php
    // run all scripts to start a session, grab the necessary files. and close the session
    echo "STARTING SESSION...\r\n\r\n";
    include_once('startsession.php');
    echo "GETTING FILE NAMES...\r\n\r\n";
    include_once('queryfiles.php');
    echo "GRABBING FILE NAMES...\r\n\r\n";
    include_once('fetchfiles.php');
    echo "CLOSING SESSION...\r\n\r\n";
    include_once('closesession.php');
    echo "MOVING FILES TO DATABASE...\r\n\r\n";
    include_once('movetodb.php');
    echo "DONE\r\n";
?>