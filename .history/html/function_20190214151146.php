<?php
  ini_set('display_errors', 1);
  ini_set('error_reporting', E_ALL);

  function mysqliConnect() {
    $mysqli = new mysqli($dbserver, $dbuser, $passwd, $dbname);
    if ($mysqli->connect_error) {
      print($mysqli->connect_error);
      exit();
    } else {
      $mysqli->set_charset('utf8');
    }
  }
?>
