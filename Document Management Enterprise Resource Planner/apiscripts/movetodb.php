<?php
    include_once("/var/www/html/functions.php");
    $dblink=db_connect("DocStorage"); 
    $dblink2=sessions_db_connect("ValadezSessions"); // issue here

    // loop through all files in receive directory
    $dir = new DirectoryIterator(dirname("/var/www/html/receive/*.pdf"));
    foreach($dir as $fileinfo){
        if(!$fileinfo->isDot()){
            $file_name = $fileinfo->getFilename();
            echo "File Name: $file_name\r\n";

            $tmp = explode("-",$file_name);
            $tmp2 = explode(".",$tmp[2]);

            $record_num = $tmp[0];
            echo "$record_num\r\n"; // record_number
            $doc_type = $tmp[1];
            echo "$doc_type\r\n"; // document type
            $date = $tmp2[0];
            echo "$date\r\n"; // date
            $file_type = $tmp2[1];
            echo "$file_type\r\n"; // file type 

            // check if user with record policy number already exists, if not create a user with that number    
            $sql = "SELECT `user_record_num` FROM `Users` WHERE `user_record_num` = $record_num";
            $result=$dblink->query($sql) or
                die("Something went wrong with $sql<br>".$dblink->error);
            $data=$result->fetch_array(MYSQLI_ASSOC);

            // if record exists send info to database, if not create it then send file
            if($data['user_record_num'] == $record_num){

                echo "Record exists!!!\r\n";
                // get user_id 
                $sql = "SELECT `user_id` FROM `Users` WHERE `user_record_num` = $record_num";
                $result=$dblink->query($sql) or
                    die("Something went wrong with $sql<br>".$dblink->error);
                $data=$result->fetch_array(MYSQLI_ASSOC);
                $user_id = $data['user_id'];

                // send file to database
                $path="/var/www/html/uploads/";
                $fp=fopen("/var/www/html/receive/$file_name", 'r');
                $file_size = filesize("/var/www/html/receive/$file_name");
                echo "File name being added: $file_name\r\n";
	            //$content=fread($fp, filesize("/var/www/html/receive/$file_name"));
                $content=fread($fp, $file_size);
	            fclose($fp);
	            $contentsClean=addslashes($content);
                $sql = "INSERT INTO `Files` (`user_id`,`file_name`,`file_type`,`document_type`,`creation_date`,`status`,`file_path`,`file_data`) VALUES ('$user_id','$file_name','$file_type','$doc_type','$date','active','$path','$contentsClean')";
                // upload and test
                $result=$dblink->query($sql) or
                    die("Something went wrong with $sql<br>".$dblink->error);
                echo "File added to database\r\n\n";
            }
            else{
                echo "Record does not exist, adding it...\r\n";
                $sql = "INSERT INTO `Users` (`user_record_num`) VALUES ('$record_num')";
                $result2=$dblink->query($sql) or
                    die("Something went wrong with $sql<br>".$dblink->error);
                echo "Record added\r\n";

                // get user_id 
                $sql = "SELECT `user_id` FROM `Users` WHERE `user_record_num` = $record_num";
                $result=$dblink->query($sql) or
                    die("Something went wrong with $sql<br>".$dblink->error);
                $data=$result->fetch_array(MYSQLI_ASSOC);
                $user_id = $data['user_id'];

                // send file to database
                $path="/var/www/html/uploads/";
                $fp=fopen("/var/www/html/receive/$file_name", 'r');
                $file_size = filesize("/var/www/html/receive/$file_name");
                echo "File name being added: $file_name";
	            //$content=fread($fp, filesize("/var/www/html/receive/$file_name"));
                $content=fread($fp, $file_size);
	            fclose($fp);
	            $contentsClean=addslashes($content);
                $sql = "INSERT INTO `Files` (`user_id`,`file_name`,`file_type`,`document_type`,`creation_date`,`status`,`file_path`,`file_data`) VALUES ('$user_id','$file_name','$file_type','$doc_type','$date','active','$path','$contentsClean')";
                // upload and test
                $result=$dblink->query($sql) or
                    die("Something went wrong with $sql<br>".$dblink->error);
                echo "File added to database\r\n\n";
            }
            
            echo "Marking as used...\r\n";
            $sql = "UPDATE `Files` SET `status` = 'used' WHERE `file_name` = '/storage/files/hfx349/$file_name'"; 
            $result=$dblink2->query($sql) or
                die("Something went wrong with $sql<br>".$dblink->error);
        }
    }
?>