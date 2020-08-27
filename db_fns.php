<?php
# for db connection
# https://documentation.mamp.info/en/MAMP-Mac/How-Tos/Connect-to-MySQL-from-PHP/
DEFINE('DB_USERNAME', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_DATABASE', 'myblogger');
function db_connect(){
	try{
		$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	} catch (Exception $e){
		echo $e->message;
		exit;
	}
	if (!$conn){
		return false;
	}
	// echo 'Connected Successfully';
	return $conn;
}

function get_writer_record($username){
	$conn = db_connect();
	$query = "select * from writers where username = '$username'";
	$result = mysqli_query($conn, $query);
	return mysqli_fetch_assoc($result);
}

function get_story_record($id){
	$conn = db_connect();
	$query = "select * from stories where id = '$id'";
	$result =  mysqli_query($conn, $query);
	return mysqli_fetch_assoc($result);
}

function query_select($name, $query, $default=''){
	$conn = db_connect();

	$result = mysqli_query($conn, $query);

	if (!$result){
		# code ...
		return ('');
	}

	$select = "<select name = '$name'>";
	$select .='<option value=""';
	if ($default == ''){
		# code ...
		$select .= ' selected';
	}
	$select .= '>-- Choose --</option>';

	for ($i = 0; $i < mysqli_num_rows($result); $i++){
		$option = mysqli_fetch_array($result);
		$select .= "<option value='{$option[0]}'";
		if ($option[0] == $default){
			$select .= 'selected';
		}
		$select .= ">[{$option[0]}] {$option[1]}</option>";
	}
	$select .= "</select>\n";

	return($select);
	#以上代码构成下面的 html代码
	// <select name = 'page'>
	// <option value="" selected>-- Choose --</option>
	// <option value='news'>[news] The Top News Stories From Around the World</option>
	// <option value='sport'>[sport] Sports Latest - All The Winners and Losers</option>
	// </select>
}
?>