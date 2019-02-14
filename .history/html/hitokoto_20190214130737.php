
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/default.css" type="text/css">
	<script src="script/jquery-2.2.4.min.js"></script>
	<script>
	$(function() {
		$("#sendBtn").click( function(){				//[投稿する]ボタンが押されたとき
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
		$("button.delete").click( function(){				//[削除]ボタンが押されたとき
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
<p class="comment">taroさん、こんにちは！&nbsp;&nbsp;<a href="logout.php">ログアウト</a></p>
<p class="comment">コメント：<input type="text" id="msg" name="msg" style="width:330px" />
<button id="sendBtn">投稿する</button></p>
</form>
</div>
<div id="view">
<h1>投稿一覧</h1>
<div id="detail">
<p><strong>2019/02/14 12:51:43 さん&nbsp;</strong><br>idてきとうでもはいれるんだけど<br><br></p>
<p><strong>2019/02/14 12:51:23 さん&nbsp;</strong><br>asad<br><br></p>
<p><strong>2019/02/14 12:51:10 さん&nbsp;</strong><br>a<br><br></p>
<p><strong>2019/02/14 12:48:15 taroさん&nbsp;<button class="delete" id="del_52">削除</button></strong><br>参る<br><br></p>
</div>
</div>
</body>
</html>
