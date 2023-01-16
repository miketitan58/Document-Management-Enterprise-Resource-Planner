<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
<?php
include("functions.php");
$dblink=db_connect("DocStorage");
echo '<div id="page-inner">';
echo '<h1 class="page-head-line">Search Files on DB</h1>';
echo '<div class="panel-body">';
if (!isset($_POST['submit']))
{
	echo '<form action="" method="post">';
	echo '<div class="form-group">';
	echo '<label>Search String:</label>';
	echo '<input type="text" class="form-control" name="searchString">';
	echo '</div>';
	echo '<select name="searchType">';
	echo '<option value="name">Name</option>';
	echo '<option value="uploadBy">Uploaded By</option>';
	echo '<option value="uploadDate">Date</option>';
	echo '<option value="all">All</option>';
	echo '</select>';
	echo '<hr>';
	echo '<button type="submit" name="submit" value="submit">Search</button>';
	echo '</form>';
}
if (isset($_POST['submit']))
{
	$searchType=$_POST['searchType'];
	$searchString=addslashes($_POST['searchString']);
	switch($searchType)
	{
		case "name":
			$sql="SELECT `file_name`,`upload_date`,`user_id`,`file_id` FROM `Files` WHERE `file_name` LIKE '%$searchString%'";
			break;
		case "uploadBy":
			$sql = "SELECT `user_id` FROM `Users` WHERE `user_record_num` LIKE '%$searchString%'";
			$result=$dblink->query($sql) or
				die("Something went wrong with $sql<br>".$dblink->error);
			$data=$result->fetch_array(MYSQLI_ASSOC);
			$user_id = $data['user_id'];
			$sql="SELECT `file_name`,`upload_date`,`user_id`,`file_id` FROM `Files` WHERE `user_id` = $user_id";
			break;
		case "uploadDate":
			$sql="SELECT `file_name`,`upload_date`,`user_id`,`file_id` FROM `Files` WHERE `upload_date` LIKE '%$searchString%'";
			break;
		case "all":
			$sql="SELECT `file_name`,`upload_date`,`user_id`,`file_id` FROM `Files`";
			break;
		default:
			redirect("search.php?msg=searchTypeError");
			break;
	}
	$result=$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
	echo '<table>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC))
	{
		echo '<tr>';
		echo '<td>'.$data['file_name'].'</td>';
		echo '<td>'.$data['upload_date'].'</td>';
		echo '<td><a href="view.php?fid='.$data['file_id'].'">View</a></td>';
		echo '</tr>';
	}
	echo '</table>';
}

echo '<a href="index.php"><p>Go Home</p></a>';

echo '</div>';//end panel-body
echo '</div>';//end page-inner
?>