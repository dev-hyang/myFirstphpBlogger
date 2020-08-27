<?php
	# Script User to Create or Edit a Story
	include_once('include_fns.php');
 
	if (isset($_REQUEST['id'])) {
		$story = get_story_record($_REQUEST['id']);
	}
?>
 
<form action = "story_submit.php" method = "POST" enctype="multipart/form-data">
	<input type = "hidden" name="story" value = "<?php echo $_REQUEST['id'];?>">
	<input type = "hidden" name="destination"
			value = "<?php echo $_SERVER['HTTP_REFERER']; ?>">
 
	<table>
		<tr>
			<td>Headline</td>
		</tr>
 
		<tr>
			<td><input size="80" name="headline"
						value ="<?php echo $story['headline'];?>" ></td>
		</tr>
 
		<tr>
			<td>Page</td>
		</tr>
 
		<tr>
			<td>
				<?php
					#检查post参数中是否含有story id
					if (isset($_REQUEST['id'])) {
						# code...
						$query = "select p.code, p.description 
								from pages p, writer_permissions wp, stories s 
								where p.code = wp.page
									  and wp.writer = s.writer
									  and s.id = ".$_REQUEST['id']; 
					}else{
						$query = "select p.code, p.description 
								  from pages p, writer_permissions wp 
								  where p.code = wp.page 
								  		and wp.writer = '{$_SESSION['auth_user']}'";
					}
					echo query_select('page', $query , $story['page']);
				?>
			</td>
		</tr>
 
		<tr>
			<td>Story text (can contain HTML tags)</td>
		</tr>
 
		<tr>
			<td>
				<textarea cols = "80" rows="7" name="story_text" wrap="virtual">
					<?php echo $story['story_text'];?>
				</textarea>
			</td>
		</tr>
 
		<tr>
			<td>
				Or upload HTML file
			</td>
		</tr>
 
		<tr>
			<td>
				<input type = "file" name = "html" size="40">
			</td>
		</tr>
 
		<tr>
			<td>Picture</td>
		</tr>
		<tr>
			<td><input type="file" name= "picture" size="40"></td>
		</tr>
 
		<?php
			if ($story['picture']) {
				$size = getimagesize('../'.$story['picture']);
				$width = $size[0];
				$height = $size[1];
		?>
 
			<tr>
				<td>
					<img src="<?php echo '../'.$story['picture'];?>"
						 	width="<?php echo $width;?>" height="<?php echo $height;?>">
				</td>
			</tr>
		<?php
		}
		?>
 
		<tr>
			<td algin="center"><input type="submit" value="Submit"></td>
		</tr>
	</table> 
</form>