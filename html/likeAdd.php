<?php
  require('dataBaseConnect.php');

  $seqno = $_POST['seqno'];
  $like  = $_POST['like'] + 1;

  $stmt = $pdo->prepare('UPDATE msg SET `like` = ? where seqno = ?');
  $stmt->bindValue(1, $like);
  $stmt->bindValue(2, $seqno);
  $stmt->execute();
?>
