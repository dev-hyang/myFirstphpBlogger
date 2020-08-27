<?php
	include_once('include_fns.php');

	$conn = db_connect();
	$storyID = $_REQUEST['id'];
	$keyword = $_REQUEST['keyword'];
	if (check_permission($_SESSION['auth_user'], $storyID)){
		$query = "delete from keywords where story='$storyID' and keyword = '$keyword'";
		mysqli_query($conn, $query);
	}
	header("Location: keywords.php?id=$storyID");
?>