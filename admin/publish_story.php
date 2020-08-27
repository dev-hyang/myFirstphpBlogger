<?php
	include_once('include_fns.php');

	$conn = db_connect();

	$now = time();

	$storyID = $_REQUEST['id'];

	if (check_permission($_SESSION['auth_user'], $storyID)){
		$query = "update stories set published = $now
				where id = $storyID";
		$result = mysqli_query($conn, $query);
	}
	header('Location: '.$_SERVER['HTTP_REFERER']);
	#这里并没有执行commit操作, Mysql之所以不需要显示提交commit，是因为mysql里面的autocommit是on，也就是说是自动提交的。
	# http://www.cnblogs.com/youxin/p/3196016.html
?>