<?php
	$image = $_REQUEST['image'];
	$max_width = $_REQUEST['max_width'];
	$max_height = $_REQUEST['max_height'];

	if (!$max_width){
		# code ...
		$max_width = 80;
	}

	if (!$max_height){
		# code ...
		$max_height = 60;
	}

	$size = getimagesize($image);
	$width = $size[0];
	$height = $size[1];

	$x_ratio = $max_width / $width;
	$y_ratio = $max_height / $height;

	if (($width <= $max_width) && ($height <= $max_height)){
		$tn_width = $width;
		$tn_height = $height;
	}elseif (($x_ratio * $height) < ($max_height)){
		$tn_height = ceil($x_ratio * $height);
		$tn_width = $width;
	}else {
		$tn_width = ceil($y_ratio * $width);
		$tn_height = $height;
	}

	$src = imagecreatefromjpeg($image);
	$dst = imagecreate($tn_width, $tn_height);
	imagecopyresized($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);
	header('Content-type: image/jpeg');
	imagejpeg($dst, null, -1);
	imagedestroy($src);
	imagedestroy($dst);
?>