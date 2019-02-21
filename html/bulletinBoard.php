<?php
  $userId   = $_SESSION['id'];
  $userName = $_SESSION['name'];

  // ログインしていない場合はログインページに飛ばす
  if (!isset($userId)) {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: loginPage.php');
    exit(0);
  }

  require('dataBaseConnect.php');
  date_default_timezone_set('Asia/Tokyo');

  $dateArray = array();
  $nameArray = array();
  $msgArray  = array();
  $likeArray  = array();
  $stmt = $pdo->query('SELECT * FROM msg ORDER BY date ASC');
  foreach ($stmt as $row) {
    array_push($dateArray, $row['date']);
    array_push($nameArray, $row['name']);
    array_push($msgArray, $row['msg']);
    array_push($likeArray, $row['like']);
  }
?>

<script type='text/javascript'>
  const userId    = <?php echo json_encode($userId)?>;
  const userName  = <?php echo json_encode($userName)?>;
  const dateArray = <?php echo json_encode($dateArray)?>;
  const nameArray = <?php echo json_encode($nameArray)?>;
  const msgArray  = <?php echo json_encode($msgArray)?>;
  const likeArray = <?php echo json_encode($likeArray)?>;
</script>

<html lang="ja">

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>

  <link rel='icon' href='./favicon.ico'>
  <script src='./script/jquery.min.js'></script>

  <script src='./script/react.development.js'></script>
  <script src='./script/react-dom.development.js'></script>
  <script src='./script/react-router-dom.min.js'></script>
  <script src='./script/babel.min.js'></script>
  <script src='./script/prop-types.js'></script>

  <title>一言掲示板</title>
</head>

<body>
  <main id='example'></main>

  <div id='input'>
    <form method='post' id='msgform' action='dataBaseUpdate.php'>
      <p class='comment'>
        <?php print($userName)?>さん、こんにちは！ <a href='logout.php'>ログアウト</a>
      </p>
      <p class='comment'>
        コメント：<input type='text' id='msg' name='msg' style='width:330px' value=''>
        <button type='button' id='sendBtn'>投稿する</button>
      </p>
    </form>
  </div>

  <div id='view'>
    <h1>投稿一覧</h1>
    <div id='detail'>
    </div>
  </div>

  <script type='text/babel'>
    class Header extends React.Component {
      render () {
        return (
          <p>{userName}</p>
        )
      }
    }

    class Main extends React.Component {
      render () {
        return (
          <h1>一言掲示板</h1>
        )
      }
    }

    ReactDOM.render(
      <div>
        <Header />
        <Main />
      </div>,
      document.getElementById('example')
    )
  </script>

  <script type='text/javascript'>
  now = _ => {
    d = new Date()
    d.setTime(d.getTime() + 1000 * 60 * 60 * 9)
    return d.toJSON().slice(0, 19).replace('T', ' ')
  }

  $('#sendBtn').click(_ => {
    const date = now()
    const msg  = $('#msg').val()
    if (msg.length <= 0) {
      alert('コメント欄に内容を入力してください')
    } else if (msg.length > 140) {
      alert('コメント欄の内容が上限(140文字)を超えています')
    } else {
      let xhr = new XMLHttpRequest()
      xhr.open('POST', 'msgUpload.php', true)
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
      xhr.send(`msg=${msg}&date=${date}`)
      $('#msg').val('')
    }
  })
</script>
</body>

</html>
