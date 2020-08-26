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
	echo 'Connected Successfully';
	return $conn;
}

function get_writer_record($username){
	$conn = db_connect();
	$query = "select * from writers where username = '$username'";
	$result = mysqli_query($conn, $query);
	return mysqli_fetch_assoc($result);
}
?>