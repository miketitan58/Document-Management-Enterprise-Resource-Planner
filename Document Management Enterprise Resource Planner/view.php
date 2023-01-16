<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<?php
include("functions.php");
$dblink=db_connect("DocStorage");
$autoid=$_REQUEST['fid'];
echo '<div id="page-inner">';
echo '<h1 class="page-head-line">View Files on DB</h1>';
echo '<div class="panel-body">';
$sql="SELECT * FROM `Files` WHERE `file_id`='$autoid'";
$result=$dblink->query($sql) or
	die("Something went wrong with $sql<br>".$dblink->error);
$data=$result->fetch_array(MYSQLI_ASSOC);
if ($data['path']!=NULL)
	echo '<p>File: <a href="uploads/'.$data['file_name'].'" target="_blank">'.$data['file_name'].'</a></p>';
else
{
	$name = $data['file_name'];
	$content=$data['file_data'];
	$file_type = explode(".", $name);
	$fname=date("Y-m-d_H:i:s")."-00$autoid.$file_type[1]";
	if (!($fp=fopen("/var/www/html/uploads/$fname","w")))
		echo "<p>File could not be loaded at this time</p>";
	else
	{
		fwrite($fp,$content);
		fclose($fp);
		echo '<p>File: <a href="uploads/'.$fname.'" target="_blank">'.$data['file_name'].'</a></p>';
	}
}

echo '<a href="index.php"><p>Go Home</p></a>';

echo '</div>';//end panel-body
echo '</div>';//end page-inner
?>