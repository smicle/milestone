<?php
	//ログインユーザ情報を消去
	$_SESSION['id']   = null;
  $_SESSION['name'] = null;

	//ログインページに飛ばす
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: loginPage.html');
?>
