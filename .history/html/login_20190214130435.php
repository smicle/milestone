<?php
	$errorMessage = "";
	if (@$_GET['err'] == '1') {
		$errorMessage = "ＩＤまたはパスワードが違います<br>";
	}
?>

<html>

<head>
	<link rel="stylesheet" href="css/default.css" type="text/css">
	<title>ログイン</title>
</head>
<body>
<h1>ログイン</h1>
<span class="error"><?php echo $errorMessage ?></span>
<form method="post" action="login_chk.php">
<table>
<tr><th>ユーザID:</th><td><input type="text" name="id" size="12"></td></tr>
<tr><th>パスワード:</th><td><input type="password" name="password" size="20"></td></tr>
</table>
<input type="submit" value="ログイン">
</form>
</body>
</html>
