<?php
  $mysqli = new mysqli($dbserver, $dbuser, $passwd, $dbname);
  if ($mysqli->connect_error) {
    print($mysqli->connect_error);
    exit();
  } else {
    $mysqli->set_charset('utf8');
  }
  }
?>
