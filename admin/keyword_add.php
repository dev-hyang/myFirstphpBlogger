<?php
	include_once('include_fns.php');

	$conn = db_connect();
	$storyID = $_REQUEST['id'];
	$keyword = $_REQUEST['keyword'];
	$weight = $_REQUEST['weight'];

	if (check_permission($_SESSION['auth_user'], $storyID)){
		$query = "insert into keywords (story, keyword, weight)
				values ($storyID, '$keyword', $weight)";
		mysqli_query($conn, $query);
	}
	#will return status_code: 302
	header("Location: keywords.php?id=$storyID");
?>