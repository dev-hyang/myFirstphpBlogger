<?php
	include_once('include_fns.php');

	$conn = db_connect();

	$storyID = $_REQUEST['id'];
	if (check_permission($_SESSION['auth_user'], $storyID)){
		$query = "delete from stories where id = $storyID";
		$result = mysqli_query($conn, $query);
	}
	header('Location: '.$_SERVER['HTTP_REFERER']);
?>