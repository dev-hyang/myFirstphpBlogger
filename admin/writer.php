<?php
	//writer.php is the interface for writers to manage their stories
	
	include_once('include_fns.php');
	if (!check_auth_user()){
		#check if the user is auth in the database
		login_form();
	}else{
		$conn = db_connect();
		$writer = get_writer_record($_SESSION['auth_user']);

		echo '<p>Welcome, '.$writer['full_name'];
		echo '  (<a href="logout.php">Logout</a>)
				(<a href="index.php">Menu</a>)
				(<a href="../">Public Site</a>) </p>';
		echo '</p>';

		$query = 'select * from stories where writer=\''.$_SESSION['auth_user'].'\' order by created desc';
		$result = mysqli_query($conn, $query);

		echo 'Your stories: ';
		echo mysqli_num_rows($result);
		echo ' (<a href="story.php">Add new</a>)';
		echo '</p><br /><br/>';

		if (mysqli_num_rows($result)){
			# code...
			echo '<table>';
			echo '<tr><th>Headline</th><th>Page</th>';
			echo '<th>Created></th><th>Last modified</th></tr>';

			while ($stories = mysqli_fetch_assoc($result)){
				# code ...
				echo '<tr><td>';
				echo $stories['headline'];
				echo '</td><td>';
				echo $stories['page'];
				echo '</td><td>';
				echo date('M d, H:i', $stories['created']);
				echo '</td><td>';
				echo date('M d, H:i', $stories['modified']);
				echo '</td><td>';

				if ($stories['published']){
					# code...
					echo '[Published '.date('M d, H:i', $stories['published']).']';
				}else{
					echo '[<a href="story.php?id='.$stories['id'].'">edit</a>]';
					echo '[<a href="delete_story.php?id='.$stories['id'].'">delete</a>]';
				}
				echo '[<a href="keywords.php?id='.$stories['id'].'">keywords</a>]';
				echo '</td></tr>';
			}
			echo '</table>';
		}
	}
?>