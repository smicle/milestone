<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);

	require_once('db.inc');

	//セッション開始
	session_start();

	//入力された値を取得
	$id = $_POST['id'];
	$password = $_POST['password'];

	//DBに接続
	$mysqli = new mysqli($dbserver, $dbuser, $passwd, $dbname);

	//SQL文を準備(パラメタ部は「？」とする)
	$stmt = $mysqli->prepare("select password from user where id=?");

	//パラメータをバインド
	$stmt->bind_param("s", $id);

	//SQL文を実行
	$stmt->execute();

	//結果をバインドして取得
	$stmt->bind_result($passwordHash);
	$stmt->fetch();

	//DB接続を切断
	$stmt->close();
	$mysqli->close();

	//入力されたパスワードを、同じソルトを使ってハッシュ化
	$inputPasswordHash = crypt($password, $passwordHash);

  print($password);
  print($passwordHash);
  print($passwordHash);
  print($inputPasswordHash);

	header("HTTP/1.1 301 Moved Permanently");
	//パスワードが正しければメニューに飛ばす
	// if ($passwordHash == $inputPasswordHash) {
	if ($passwordHash == $inputPassword) {
		$_SESSION['id'] = $id;
    header("Location: hitokoto.php");
    //見つからなかったまたはパスワードが違ったらログインページに戻す
	} else {
		$_SESSION['id'] = '';
		header("Location: login.php?err=1");
	}
?>
