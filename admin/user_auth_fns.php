<?php
	
	function check_auth_user(){
		#see if sbd. is logged in and notify them if not
		global $_SESSION;
		if (isset($_SESSION['auth_user'])){
			return true;
		}else{
			return false;
		}

	}

	function login_form(){
		#show the login form
		?>
		<form action='login.php' method='post'>
			<table border = 0>
				<tr>
					<td>Username:</td>
					<td><input size='16' name='username'></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input size='16' type='password' name='password'></td>
				</tr>
			</table>
			<input type='submit' value='Log in'>
		</form>
		<?php
	}

	function login($username, $password){
		$conn = db_connect();
		if (!$conn){
			return 0;
		}

		$query = "select * from writers where username = '$username' and password = sha1('$password')";

		$result = mysqli_query($conn, $query);
		if (!$result){
			trigger_error('Invalid query: ' . mysqli_error()." in ".$query);
			return 0;
		}

		if (mysqli_num_rows($result) > 0){
			return 1;
		}else{
			return 0;
		}
	}
?>