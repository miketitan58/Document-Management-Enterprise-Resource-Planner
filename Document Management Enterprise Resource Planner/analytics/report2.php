<?php
    include_once("/var/www/html/functions.php");
    $dblink=db_connect("DocStorage"); 
    
    echo '<h1 class="page-head-line">Report 2 (100 points)</h1>';
    echo '<h2 class="page-head-line">====================</h2>';

    $max_size = 0;

    // get total size of all documents recieved
    $sql = "SELECT `file_data` FROM Files";
    $result=$dblink->query($sql) or
	    die("Something went wrong with $sql<br>".$dblink->error);
    while ($data=$result->fetch_array(MYSQLI_ASSOC)){
        $file_size = strlen($data['file_data']);
        $max_size += intval($file_size);
    }
    //echo '<p><b>Total size of all documents</b>: ' .$max_size. ' Bytes</p>';
    echo '<h2 class="page-head-line">--------------------</h2>';

    // get the average size of all documents across all loans
    $loan_array = array();
    $sql = "SELECT `file_name` FROM `Files`";
    $result=$dblink->query($sql) or
	    die("Something went wrong with $sql<br>".$dblink->error);
    while ($data=$result->fetch_array(MYSQLI_ASSOC)){
        $tmp = explode("-", $data['file_name']);
        $loan_array[]=$tmp[0];
    }
    // get unique loan numbers
    $loan_unique=array_unique($loan_array);
    foreach($loan_unique as $key=>$value){
        $total_size = 0;
        $file_count = 0;
        $sql = "SELECT `file_data` FROM `Files` WHERE `file_name` like '%$value%'";
        $result=$dblink->query($sql) or
	        die("Something went wrong with $sql<br>".$dblink->error);
        while ($data=$result->fetch_array(MYSQLI_ASSOC)){
            $file_size = strlen($data['file_data']);
            $total_size += intval($file_size);
            $file_count += 1;
        }
        $avg_size = intdiv($total_size, $file_count);
        echo '<p>Loan Number: <i><b>' .$value. '</b></i>, Average File Size: <b>' .$avg_size. '</b> Bytes</p>';
    }

    echo '<h2 class="page-head-line">====================</h2>';
    echo '<a href="../index.php"><p>Go Home</p></a>';
?>