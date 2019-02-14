<?php
  // 入力された値を取得
  $id = $_POST['id'];
  $password = $_POST['password'];

  require_once('db.inc');
  session_start();
  require('fn/mysqliConnect.php');

  // SQL文を実行
  $stmt = $mysqli->prepare('SELECT password FROM user WHERE id=?');
  $stmt->bind_param('s', $id);
  $stmt->execute();
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
