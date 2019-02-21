<?php
  require('dataBaseConnect.php');
  date_default_timezone_set('Asia/Tokyo');

  $id   = $_SESSION['id'];
  $name = $_SESSION['name'];
  $date = $_POST['date'];
  $msg  = htmlspecialchars($_POST['msg']);

  $stmt = $pdo->prepare('INSERT INTO msg (id, name, date, msg) VALUES (?, ?, ?, ?)');
  $stmt->bindValue(1, $id);
  $stmt->bindValue(2, $name);
  $stmt->bindValue(3, $date);
  $stmt->bindValue(4, $msg);
  $stmt->execute();
?>
