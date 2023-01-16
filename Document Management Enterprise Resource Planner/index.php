<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<?php
    echo '<div id="page-inner">';
    echo '<h1 class="page-head-line">Welcome to ESE DocStorage System</h1>';
    echo '<div class="panel-body">';

    // links to search and upload
    echo '<a href="search.php"><p>Search for File</p></a>';
    echo '<a href="upload.php"><p>Upload a File</p></a>';

    echo '<h1 class="page-head-line">DocStorage Reports</h1>';

    // links to reports
    echo '<a href="./analytics/report1.php"><p>Report 1</p></a>';
    echo '<a href="./analytics/report2.php"><p>Report 2</p></a>';
    echo '<a href="./analytics/report3.php"><p>Report 3</p></a>';
    echo '<a href="./analytics/report4.php"><p>Report 4</p></a>';

    echo '</div>';//end panel-body
    echo '</div>';//end page-inner
?>