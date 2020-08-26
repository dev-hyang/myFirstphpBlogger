<?php
session_start();
include_once('db_fns.php');
include_once('header.php');

$conn = db_connect();
if(!$conn){
	#if access into the database failed
	echo "Did not access to the database";
}

// $mysqli = mysqli_connect("host", "user", "password", "database");
// $stmt = $mysqli->prepare("INSERT INTO comments(cName, cComment) VALUES (?, ?)");

// $name = 'Peter';
// $comment = 'Haloooo';
// $stmt->bind_param("ss", $name, $comment);
// $stmt->execute();

$pages_sql = 'select * from pages order by code';
$pages_result = mysqli_query($conn, $pages_sql);	

echo '<table border = "0" width = "800"';

while ($pages = mysqli_fetch_assoc($pages_result)){
	$story_sql = "select * from stories where page = '{$pages['code']}' and published is not null order by published desc";
	$story_result = mysqli_query($conn, $story_sql);

	if (mysqli_num_rows($story_result)){
		$story = mysqli_fetch_assoc($story_result);
		echo "
			<tr>
			<td>
				<h2>{$pages['description']}</h2>
				<p>{$story['headline']}</p>
				<p align = 'right' class='morelink'>
					<a href='page.php?page={$pages['code']}'>
					Read more {$pages['code']} ...
					</a>
				</p>
			</td>
			<td width='100'>
		";
		if ($story['picture']){
			echo '<img src="resize_image.php?image=';
			echo urlencode($story['picture']);
			echo '&max_width=80&max_height=60" />';
		}
		echo '</td></tr>';
	}
}
echo '</table>';
include_once('footer.php');
?>