<?php
    include_once("/var/www/html/functions.php");
    $dblink=db_connect("DocStorage"); 
    
    echo '<h1 class="page-head-line">Report 3 (100 points)</h1>';
    echo '<h2 class="page-head-line">====================</h2>';
    echo '<p><b>Total number of documents for each loan number</b></p>'; 
    // for each loan number, get the total number of documents recieved 
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
        // get total number of files
        $sql = "SELECT count(`file_name`) FROM `Files` WHERE `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
	        die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<p>Loan Number: <i><b>' .$value. '</b></i> has <i><b>' .$data[0]. '</i></b> document(s)</p>';
    }

    echo '<h2 class="page-head-line">--------------------</h2>';

    // get the average number of documents across all loan numbers. 
    $num_loan_numbers = sizeof($loan_unique);
    $sql = "SELECT count(`file_name`) FROM `Files`";
    $result=$dblink->query($sql) or
	    die("Something went wrong with $sql<br>".$dblink->error);
    $data=$result->fetch_array(MYSQLI_NUM);

    $avg_docs = intdiv(intval($data[0]), intval($num_loan_numbers));
    
    echo '<p><b>Average number of documents per Loan Number</b>: ' .$avg_docs. '</p>';
    echo '<h2 class="page-head-line">--------------------</h2>';
    // compare each loan number to the average and state if it is above or below average (100 pts)
    echo '<b>Above/Below Average Anlytics</b>';

    foreach($loan_unique as $key=>$value){
        // get total number of files
        $sql = "SELECT count(`file_name`) FROM `Files` WHERE `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
	        die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        // check if above or below the average

        if($data[0] > $avg_docs)
            echo '<p>Loan Number: <i><b>' .$value. '</b></i> has <b>more</b> documents than the average</p>' ;
        else if($data[0] < $avg_docs)
            echo '<p>Loan Number: <i><b>' .$value. '</b></i> has <b>less</b> documents than the average</p>' ;
        else
            echo '<p>Loan Number: <i><b>' .$value. '</b></i> has the <b>same</b> number of documents as the average</p>';
    }

    echo '<h2 class="page-head-line">====================</h2>';
    echo '<a href="../index.php"><p>Go Home</p></a>';
?>