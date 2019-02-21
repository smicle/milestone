<?php
  require_once('dataBase.inc');

  $dsn = sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $dbname, $dbhost);

  $driver_options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
  );

  try {
    $pdo = new PDO($dsn, $dbuser, $dbpass, $driver_options);
  } catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
  }
?>
