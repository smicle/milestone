<?php
  require('dataBaseConnect.php');

  $seqno = $_POST['seqno'];

  $stmt = $pdo->prepare('DELETE FROM `msg` WHERE `msg`.`seqno` = ?');
  $stmt->bindValue(1, $seqno);
  $stmt->execute();
?>
