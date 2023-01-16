<!DOCTYPE html>
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
<?php
echo '<div id="page-inner">';
if (isset($_REQUEST['msg']) && ($_REQUEST['msg']=="success"))
{
	echo '<div class="alert alert-success alert-dismissable">';
	echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	echo 'Document successfully uploaded!</div>';
}
echo '<h1 class="page-head-line">Upload a New File to DocStorage</h1>';
echo '<div class="panel-body">';
echo '<form method="post" enctype="multipart/form-data" action="">';
echo '<input type="hidden" name="uploadedby" value="user@test.mail">';
echo '<input type="hidden" name="MAX_FILE_SIZE" value="100000000">';
echo '<div class="form-group">';
echo '<label class="control-label col-lg-4">File Upload</label>';
echo '<div class="">';
echo '<div class="fileupload fileupload-new" data-provides="fileupload">';
echo '<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>';
echo '<div class="row">';//buttons
echo '<div class="col-md-2"><span class="btn btn-file btn-primary"><span class="fileupload-new">Select File</span><span class="fileupload-exists">Change</span>';
echo '<input name="userfile" type="file"></span></div>';
echo '<div class="col-md-2"><a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a></div>';
echo '</div>';//end buttons
echo '</div>';//end fileupload fileupload-new
echo '</div>';//end ""
echo '</div>';//end form-group
echo '<hr>';
echo '<button type="submit" name="submit" value="submit" class="btn btn-lg btn-block btn-success">Upload File</button>';
echo '</form>';

echo '<a href="index.php"><p>Go Home</p></a>';
echo '</div>';//end panel-body
echo '</div>';//end page-inner

include("/var/www/html/functions.php");
$dblink=db_connect("DocStorage");   

if (isset($_POST['submit']))
{
    if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }
	$uploadDate=date("Y-m-d H:i:s");
	$user_id="1";
	$fileName=$_FILES['userfile']['name'];
	$docType="pdf";
	$tmpName=$_FILES['userfile']['tmp_name'];
	$fileSize=$_FILES['userfile']['size'];
	$fileType=$_FILES['userfile']['type'];
    $path="/var/www/html/uploads/";	
	$fp=fopen($tmpName, 'r');
	$content=fread($fp, filesize($tmpName));
	fclose($fp);
	$contentsClean=addslashes($content);

	$sql="Insert into `Files` (`file_name`,`file_path`,`user_id`,`upload_date`,`status`,`file_type`,`file_data`) values ('$fileName','$path','$user_id','$uploadDate','active','$docType','$contentsClean')";
	$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
}
?>