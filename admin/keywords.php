<?php
	include_once('include_fns.php');

	if (!check_auth_user()){
		login_form();
	}elseif (check_permission($_SESSION['auth_user'], $_REQUEST['id'])){
		$conn = db_connect();
		$storyID = $_REQUEST['id'];
		$story = get_story_record($storyID);
		echo "
			<h2>Keywords for <i>{$story['headline']}</i></h2>
			<form action='keyword_add.php' method='POST'>
				<input type='hidden' name='id' value='$storyID'>
				<input size='20' name='keyword'>
				<select name='weight'>
					<option>10</option>
					<option>9</option>
					<option>8</option>
					<option>7</option>
					<option>6</option>
					<option>5</option>
					<option>4</option>
					<option>3</option>
					<option>2</option>
					<option>1</option>
				</select>
				<input type='submit' value='Add'>
			</form>
		";

		//show the exist keywords in the database
		$query = "select * from keywords where story=$storyID order by weight desc, keyword";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result)){
			echo '<table>';
			echo '<tr><th>Keywords</th><th>Weight</th></tr>';
			while ($keyword = mysqli_fetch_assoc($result)){
				echo "
					<tr>
					<td>{$keyword['keyword']}</td>
					<td>{$keyword['weight']}</td>
					<td>[<a href='keyword_delete.php?id=$storyID&keyword=";
				echo urlencode($keyword['keyword']);
				echo "'>del</a>]
					</td></tr>";
			}
			echo '</table>';
		}
	}
?>