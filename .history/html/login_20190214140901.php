<?php
  $errorMessage = "";
  if (@$_GET['err'] == '1') {
    $errorMessage = "IDまたはパスワードが違います<br>";
  }
?>

<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <link rel="stylesheet" href="css/default.css" type="text/css"> -->
  <title>ログイン</title>
</head>

<body>
  <h1>ログイン</h1>
  <span class="error"><?php print($errorMessage ?></span>

  <form method="post" action="login_chk.php">
    <table>
      <tr><th>ユーザID:</th><td><input type="text" name="id" size="12"></td></tr>
      <tr><th>パスワード:</th><td><input type="password" name="password" size="20"></td></tr>
    </table>

    <input type="submit" value="ログイン">
  </form>

</body>

</html>
