<?php
	include_once('include_fns.php');
	#将auth_user置空
	unset($_SERVER['auth_user']);
	#销毁当前session
	session_destroy();
	#执行header函数，会刷新writer.php页面并执行逻辑判断当前user是否authorized。
	header('Location: '.$_SERVER['HTTP_REFERER']);
?>