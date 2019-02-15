<?php
  // 入力された値を取得
  $id = $_POST['id'];
  $password = $_POST['password'];

  // mysqlの準備
  session_start();
  require('mysqli_connect.php');

  // SQL文を実行
  $stmt = $mysqli->prepare('SELECT name FROM user WHERE id=? and password=?');
  $stmt->bind_param('ss', $id, $password);
  $stmt->execute();
  $stmt->bind_result($name);
  $stmt->fetch();
  $stmt->close();

  // idとpasswordが合っているか確認
  if (!empty($name)) {
    // lastloginを変更
    date_default_timezone_set('Asia/Tokyo');
    $sql = 'UPDATE user SET lastlogin="' . date("Y-m-d H:i:s") . '" WHERE id="' . $id . '"';
    $mysqli->query($sql);
    $mysqli->close();

    $_SESSION['id']   = $id;
    $_SESSION['name'] = $name;

    header('HTTP/1.1 301 Moved Permanently');
    header('Location: hitokoto.php');
  } else {
    $mysqli->close();

    $_SESSION['id']   = '';
    $_SESSION['name'] = '';

    header('HTTP/1.1 301 Moved Permanently');
    header('Location: login.php?err=1');
  }
?>
