<?php
  require_once('db.inc');
  session_start();

  // 入力された値を取得
  $id = $_POST['id'];
  $password = $_POST['password'];

  $mysqli = new mysqli($dbserver, $dbuser, $passwd, $dbname);
  if ($mysqli->connect_error) {
    print($mysqli->connect_error);
    exit();
  } else {
    $mysqli->set_charset('utf8');
  }

  // SQL文を準備(パラメタ部は「?」とする)
  $stmt = $mysqli->prepare('SELECT password FROM user where id=?');

  // パラメータをバインド
  $stmt->bind_param('s', $id);

  // SQL文を実行
  $stmt->execute();

  // 結果をバインドして取得
  $stmt->bind_result($passwordHash);
  $stmt->fetch();

  // DB接続を切断
  $stmt->close();
  $mysqli->close();


  header('HTTP/1.1 301 Moved Permanently');

  // パスワードが正しければメニューに飛ばす
  if ($password == $passwordHash) {
    $_SESSION['id'] = $id;
    header('Location: hitokoto.php');
    // 見つからなかったまたはパスワードが違ったらログインページに戻す
  } else {
    $_SESSION['id'] = '';
    header('Location: login.php?err=1');
  }
?>
