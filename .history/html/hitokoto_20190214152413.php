<?php
  //ログインユーザ情報を取得
  $id = $_SESSION['id'];

  //ログインしていない場合はログインページに飛ばす
  if ($id == '') {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: login.php');
    exit(0);
  }

  require_once('db.inc');
	session_start();
  require('fn/mysqliConnect.php');

  $stmt = $mysqli->prepare('SELECT name FROM user WHERE id=?');
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->bind_result($userName);
  $stmt->fetch();

  $stmt->close();
  $mysqli->close();
?>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <link rel="stylesheet" href="css/default.css" type="text/css"> -->
  <script src="script/jquery-2.2.4.min.js"></script>

  <script>
  $(function() {
    $("#sendBtn").click( function(){        //[投稿する]ボタンが押されたとき
      if($("#msg").val().length <= 0){
        alert('コメント欄に内容を入力してください');
      } else if($("#msg").val().length > 140){
        alert('コメント欄の内容が上限(140文字)を超えています');
      } else {
        $("<input>",{
          type:"hidden",
          name:"mode",
          value:"insert"
        }).appendTo("#msgform");
        $("#msgform").submit();
      }
    });

    $("button.delete").click( function(){        //[削除]ボタンが押されたとき
      var seqno = $(this).attr("id").slice(4);
      $("<input>",{
        type:"hidden",
        name:"mode",
        value:"delete"
      }).appendTo("#msgform");
      $("<input>",{
        type:"hidden",
        name:"seqno",
        value:seqno
      }).appendTo("#msgform");
      $("#msgform").submit();
    });
  });
  </script>
  <title>一言掲示板</title>
</head>

<body>
  <div id="input">
    <h1>一言掲示板</h1>
    <form method="post" id="msgform" action="hitokoto.php">
      <p class="comment"><?php print($userName) ?>さん、こんにちは！&nbsp;&nbsp;<a href="logout.php">ログアウト</a></p>
      <p class="comment">コメント：<input type="text" id="msg" name="msg" style="width:330px" />
      <button id="sendBtn">投稿する</button></p>
    </form>
  </div>

  <div id="view">
    <h1>投稿一覧</h1>
    <div id="detail">
    </div>
  </div>
</body>

</html>
