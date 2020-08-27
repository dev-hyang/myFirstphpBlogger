<?php
	include_once('include_fns.php');

	$conn = db_connect();

	$headline = $_REQUEST['headline'];
	$page = $_REQUEST['page'];
	$time = time();

	if ((isset($_FILES['html']['name']) && (dirname($_FILES['html']['type']) == 'text') && is_uploaded_file($_FILES['html']['tmp_name']) )){
		//if user upload some file, then set the content of the files as the story_text
		$story_text = file_get_contents($_FILES['html']['tmp_name']);
	}else{
		$story_text = $_REQUEST['story_text'];
	}
	# addslashes -> php中发送text内容到数据库的一个函数：addslashes，作用是在一些特定的符号前面加上/ 符号，特定的符号有', '' , nul, \等
	# 也可以用mysqli_real_escape_string
	$story_text = addslashes($story_text);

	if (isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
		#it's an update
		$storyID = $_REQUEST['id'];
		$query = "update stories
				set headline = '$headline', 
					story_text = '$story_text',
					page = '$page',
					modified = '$time'
				where id = '$storyID'
				";
	}else{
		# new story
		$query = "insert into stories
				(headline, story_text, page, writer, created, modified)
				values
				('$headline', '$story_text', '$page', '".$_SESSION['auth_user']."', $time, $time)";
	}

	$result = mysqli_query($conn, $query);

	if (!$result){
		# code ...
		echo "There was a database error when executing <pre>$query</pre>";
		echo mysqli_error();
		exit;
	}

	#是标准的php上传文件的步骤，可以试着记一下
	if ((isset($_FILES['picture']['name']) && is_uploaded_file($_FILES['picture']['tmp_name'] ))){
		# there is uploaded picture
		if (!isset($_REQUEST['id']) || $_REQUEST['id'] == ''){
			#?
			$storyID = mysqli_insert_id($conn);
			#return the auto generated id used in the last query
		}

		$type = basename($_FILES['picture']['type']);

		switch($type){
			case 'jpeg':
			case 'pjpeg':
			case 'png':
			case 'jpg':
				#hardcode filename, not a good idea
				$filename = "images/$storyID.jpeg";
				move_uploaded_file($_FILES['picture']['tmp_name'], '../'.$filename);
				$query = "update stories
						set picture = '$filename'
						where id = $storyID";
				$result = mysqli_query($conn, $query);
				break;
			default:
				echo 'Invalid picture format:'.$_FILES['picture']['type'];
				break;
		}
	}else{
		//there is no uploaded image file
		echo 'Possible file upload attack:';
		echo "filename '".$_FILES['picture']['tmp_name']."'.";
	}

	header('Location: '.$_REQUEST['destination']);
?>