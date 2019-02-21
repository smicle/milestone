<?php
  $id       = $_POST['id'];
  $password = $_POST['password'];

  session_start();
  header('HTTP/1.1 301 Moved Permanently');
  require('dataBaseConnect.php');

  // idとpasswordからnameを取得
  $stmt = $pdo->prepare('SELECT name FROM user WHERE id=? and password=?');
  $stmt->bindValue(1, $id);
  $stmt->bindValue(2, $password);
  $stmt->execute();
  $name = $stmt->fetch();
  $name = $name['name'];

  if ($name) {
    // lastloginを変更
    date_default_timezone_set('Asia/Tokyo');
    $date = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('UPDATE user SET lastlogin=? WHERE id=?');
    $stmt->bindValue(1, $date);
    $stmt->bindValue(2, $id);
    $stmt->execute();

    $_SESSION['id']   = $id;
    $_SESSION['name'] = $name;

    header('Location: bulletinBoard.php');
  } else {
    $_SESSION['id']   = null;
    $_SESSION['name'] = null;

    header('Location: loginPage.html?err=1');
  }
?>
