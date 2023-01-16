<?php
    include_once("/var/www/html/functions.php");
    $dblink=db_connect("DocStorage"); 

    echo '<h1 class="page-head-line">Report 4 (300 points)</h1>';
    echo '<h2 class="page-head-line">====================</h2>';

    // get unique loan numbers
    $loan_array = array();
    $sql = "SELECT `file_name`,`document_type` FROM `Files`";
    $result=$dblink->query($sql) or
	    die("Something went wrong with $sql<br>".$dblink->error);
    while ($data=$result->fetch_array(MYSQLI_ASSOC)){
        $tmp = explode("-", $data['file_name']);
        $loan_array[]=$tmp[0];
    }
    $loan_unique=array_unique($loan_array);

    // A complete loan is one that has at least one of the following documents: 
    // credit, closing, title, financial, personal, internal, legal, other

    // 1. A list of all loan numbers that are missing at least one of these documents and which document(s) is missing
    echo '<p><b>Incomplete Loans:</b></p>';

    foreach($loan_unique as $key=>$value){
        $sql = "SELECT `file_name`,`document_type` FROM `Files` WHERE `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
	        die("Something went wrong with $sql<br>".$dblink->error);
        $full_array = array();
        while($data=$result->fetch_array(MYSQLI_ASSOC)){
            $full_array[] = $data['document_type'];
        }

        $numbers_unique=array_unique($full_array);

        if(sizeof($numbers_unique) != 8){
            echo '<p>Loan Number: <i><b>' .$value. '</b></i> is missing the following documents: ';
            if(!in_array('Credit',$numbers_unique)){
                echo ' <b>Credit</b>';
            }
            if(!in_array('Closing',$numbers_unique)){
                echo ' <b>Closing</b> ';
            }
            if(!in_array('Title',$numbers_unique)){
                echo ' <b>Title</b> ';
            }
            if(!in_array('Financial',$numbers_unique)){
                echo ' <b>Financial</b> ';
            }
            if(!in_array('Personal',$numbers_unique)){
                echo ' <b>Personal</b> ';
            }
            if(!in_array('Internal',$numbers_unique)){
                echo ' <b>Internal</b> ';
            }
            if(!in_array('Legal',$numbers_unique)){
                echo ' <b>Legal</b> ';
            }
            if(!in_array('Other',$numbers_unique)){
                echo ' <b>Other</b> ';
            }
            echo '</p>';
        }
    }
    echo '<h2 class="page-head-line">--------------------</h2>';

    // 2. A list of all loan numbers that have all documents
    echo '<p><b>Complete Loans:</b></p>';

    $complete_count = 0;
    foreach($loan_unique as $key=>$value){
        $sql = "SELECT `file_name`,`document_type` FROM `Files` WHERE `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
	        die("Something went wrong with $sql<br>".$dblink->error);
        $full_array = array();
        while($data=$result->fetch_array(MYSQLI_ASSOC)){
            $full_array[] = $data['document_type'];
        }

        $numbers_unique=array_unique($full_array);
    
        if(in_array('Credit',$numbers_unique) && in_array('Closing',$numbers_unique) && in_array('Title',$numbers_unique) && in_array('Financial',$numbers_unique) && in_array('Personal',$numbers_unique) && in_array('Internal',$numbers_unique) && in_array('Legal',$numbers_unique) && in_array('Other',$numbers_unique)){
            echo '<p>Loan Number: <i>' .$value. '</i> is complete!</p>';
            $completecount++;
        }
    }

    if($complete_count == 0)
        echo '<p>There are no complete loans...</p>';
    echo '<h2 class="page-head-line">--------------------</h2>';

    // 3. List the total number of each document received across all loan numbers DONE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    echo '<p><b>Number of documents per Loan Number:</b></p>';
    foreach($loan_unique as $key=>$value){
        // get the number of each type of document for each loan number
        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Credit' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
	        die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<p>Loan Number: <i><b>' .$value. '</b></i> has <b>' .$data[0]. '</b> Credit document(s), ';
        
        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Closing' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<b>' .$data[0]. '</b> Closing document(s), ';

        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Title' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<b>' .$data[0]. '</b> Title document(s), ';

        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Financial' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<b>' .$data[0]. '</b> Financial document(s), ';

        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Personal' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<b>' .$data[0]. '</b> Personal document(s), ';

        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Internal' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<b>' .$data[0]. '</b> Internal document(s), ';

        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Legal' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<b>' .$data[0]. '</b> Legal document(s), ';

        $sql = "SELECT count(`document_type`) FROM `Files` WHERE `document_type` = 'Other' AND `file_name` LIKE '%$value%'";
        $result=$dblink->query($sql) or
            die("Something went wrong with $sql<br>".$dblink->error);
        $data=$result->fetch_array(MYSQLI_NUM);
        echo '<b>' .$data[0]. '</b> Other document(s)</p>';
    }
    echo '<h2 class="page-head-line">====================</h2>';
    echo '<a href="../index.php"><p>Go Home</p></a>';
?>