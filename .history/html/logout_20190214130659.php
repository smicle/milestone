<?php
	session_start();

	//ログインユーザ情報を消去
	$_SESSION['id'] = '';

	//ログインページに飛ばす
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: login.php");
?>
