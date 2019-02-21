<?php
  $id       = $_POST['id'];
  $password = $_POST['password'];

  session_start();
  header('HTTP/1.1 301 Moved Permanently');
  require('dataBaseConnect.php');

  // idからnameを取得
  $stmt = $pdo->prepare('SELECT name FROM user WHERE id=?');
  $stmt->bindValue(1, $id);
  $stmt->execute();
  $name = $stmt->fetch();
  $name = $name['name'];

  if ($name) {
    $_SESSION['id']   = null;
    $_SESSION['name'] = null;

    header('Location: loginPage.html?err=2');
  } else {
    $name = $_POST['name'];

    date_default_timezone_set('Asia/Tokyo');
    $date = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('INSERT INTO user (id, password, name, lastlogin) VALUES (?, ?, ?, ?)');
    $stmt->bindValue(1, $id);
    $stmt->bindValue(2, $password);
    $stmt->bindValue(3, $name);
    $stmt->bindValue(4, $date);
    $stmt->execute();

    $_SESSION['id']   = $id;
    $_SESSION['name'] = $name;

    header('Location: bulletinBoard.php');
  }
?>
