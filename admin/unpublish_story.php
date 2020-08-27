<?php
	include_once('include_fns.php');

	$storyID = $_REQUEST['id'];

	if (check_permission($_SESSION['auth_user'], $storyID)){
		$conn = db_connect();
		$query = "update stories set published = null
				where id = $storyID";
		$result = mysqli_query($conn, $query);
	}
	header('Location: '.$_SERVER['HTTP_REFERER']);
?>