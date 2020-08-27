<?php
	include_once('include_fns.php');

	if (!check_auth_user()){
		login_form();
	}else{
		$conn = db_connect();

		$writer = get_writer_record($_SESSION['auth_user']);

		echo '<p>Welcome, '.$writer['full_name'];
		echo '(<a href="logout.php">Logout</a>) (<a href="index.php">Menu</a>) ';
		echo '(<a href="../">Public Site</a>)';

		$query = "select * from stories s, writer_permissions wp where wp.writer = '{$_SESSION['auth_user']}' and s.page = wp.page and s.writer = wp.writer order by modified desc";

		$result = mysqli_query($conn, $query);

		echo '<h1>Editor admin</h1>';

		echo '<table>';
		echo '<tr><th>Headline</th><th>Last Modified</th></tr>';
		while ($story = mysqli_fetch_assoc($result)){
			echo '<tr><td>';
			echo $story['headline'];
			echo '</td><td>';
			echo date('M d,H:i', $story['modified']);
			echo '</td><td>';
			# if published is null, then means story is not published yet.
			if ($story['published']){
				echo '[<a href="unpublish_story.php?id='.$story['id'].'">unpublish</a>]';
			}else{
				echo '[<a href="publish_story.php?id='.$story['id'].'">publish</a>]';
				echo '[<a href="delete_story.php?id='.$story['id'].'">delete</a>]';
			}
			echo '[<a href="story.php?id='.$story['id'].'">edit</a>]';

			echo '</td></tr>';
		}
		echo '</table>';
	}
?>