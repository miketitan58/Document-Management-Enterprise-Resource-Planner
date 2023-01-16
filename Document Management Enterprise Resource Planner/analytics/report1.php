<?php
    include_once("/var/www/html/functions.php");
    $dblink=db_connect("DocStorage"); 

    echo '<h1 class="page-head-line">Report 1 (100 points)</h1>';
    echo '<h2 class="page-head-line">====================</h2>';
    echo '<p><b>All Unique Loan Numbers:</b></p>';

    // get number of unique records
    $loan_array = array();
    $sql = "SELECT `file_name` FROM `Files`";
    $result=$dblink->query($sql) or
	    die("Something went wrong with $sql<br>".$dblink->error);
    while ($data=$result->fetch_array(MYSQLI_ASSOC)){
        $tmp = explode("-", $data['file_name']);
        $loan_array[]=$tmp[0];
    }
    $loan_unique=array_unique($loan_array);
    foreach($loan_unique as $key=>$value){
        echo '<p><b>' .$value. '</b></p>';
    }

    echo '<h2 class="page-head-line">====================</h2>';
    echo '<a href="../index.php"><p>Go Home</p></a>';
?>