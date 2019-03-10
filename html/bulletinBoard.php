<?php
  $userId   = $_SESSION['id'];
  $userName = $_SESSION['name'];

  if (!isset($userId)) {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: loginPage.html');
    exit(0);
  }

  require('dataBaseConnect.php');

  $seqno = array(); $id  = array(); $name = array();
  $date  = array(); $msg = array(); $like = array();

  $stmt = $pdo->query('SELECT * FROM msg ORDER BY date DESC');
  foreach ($stmt as $row) {
    array_push($seqno, $row['seqno']);
    array_push($id,    $row['id']);
    array_push($name,  $row['name']);
    array_push($date,  $row['date']);
    array_push($msg,   $row['msg']);
    array_push($like,  $row['like']);
  }
?>

<html lang="ja">

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>

  <link rel='icon' href='./img/favicon.ico'>
  <link rel='stylesheet' href='./css/common.css'>
  <link rel='stylesheet' href='./css/bulletinBoard.css'>

  <script src='./script/jquery.min.js'></script>
  <script src='./script/react.development.js'></script>
  <script src='./script/react-dom.development.js'></script>
  <script src='./script/react-router-dom.min.js'></script>
  <script src='./script/babel.min.js'></script>
  <script src='./script/prop-types.js'></script>

  <title>BulletinBoard</title>
</head>

<body>
  <main id='root'></main>
<body>

<script type='text/javascript'>
  const userId   = <?php echo json_encode($userId)?>;
  const userName = <?php echo json_encode($userName)?>;
  let $seqno = <?php echo json_encode($seqno)?>;
  let $id    = <?php echo json_encode($id)?>;
  let $name  = <?php echo json_encode($name)?>;
  let $date  = <?php echo json_encode($date)?>;
  let $msg   = <?php echo json_encode($msg)?>;
  let $like  = <?php echo json_encode($like)?>;
</script>

<script type='text/babel'>
  const {HashRouter, Route, Link} = window.ReactRouterDOM

  const timeNow = _ => {
    let d = new Date()
    d.setTime(d.getTime() + 1000 * 60 * 60 * 9)
    return d.toJSON().slice(0, 19).replace('T', ' ')
  }

  const msgUpload = (msg, date) => {
    if (msg.length <= 0) {
      alert('コメント欄に内容を入力してください')
      return false
    }

    if (msg.length > 140) {
      alert('コメント欄の内容が上限(140文字)を超えています')
      return false
    }

    let xhr = new XMLHttpRequest()
    xhr.open('POST', 'msgUpload.php', true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    xhr.send(`msg=${msg}&date=${date}`)

    return true
  }

  const msgDelete = seqno => {
    let xhr = new XMLHttpRequest()
    xhr.open('POST', 'msgDelete.php', true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    xhr.send(`seqno=${seqno}`)
  }

  const likeAdd = (seqno, like) => {
    let xhr = new XMLHttpRequest()
    xhr.open('POST', 'likeAdd.php', true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    xhr.send(`seqno=${seqno}&like=${like}`)
  }

  class MsgSearch extends React.Component {
    constructor(props) {
      super(props)
      this.state = {text: ''}
      this.changeText = this.changeText.bind(this)
    }

    changeText = e => this.setState({text : e.target.value})

    render = _ => (
      <div>
        <input type='text' placeholder='検索' required='required' value={this.state.text} onChange={this.changeText} />
        <Link to={this.state.text === '' ? '/' : `/search?${this.state.text}`}>
          <div id='searchButton'><img src='./img/search.png' alt='search' /></div>
        </Link>
      </div>
    )
  }

  const ProfileCard = _ => (
    <div id='profileContainer'>
      <div id='profileName'>
        <p>{userName}</p>
        <span>@{userId}</span>
      </div>
      <Link to='/mypost' className='userPost btn'>投稿一覧</Link>
      <a className='userSignOut btn' href='./SignOut.php'>サインアウト</a>
    </div>
  )

  class PostMsg extends React.Component {
    constructor(props) {
      super(props)
      this.state  = {msg: ''}
      this.submit = this.submit.bind(this)
      this.changeMsg = this.changeMsg.bind(this)
    }

    submit() {
      const msg  = this.state.msg
      const date = timeNow()

      if (!msgUpload(msg, date)) return
      this.setState({msg: ''})

      $seqno.unshift($seqno[0] + 1)
      $id.unshift(userId)
      $name.unshift(userName)
      $date.unshift(date)
      $msg.unshift(msg)
      $like.unshift(0)
    }

    changeMsg = e => this.setState({msg: e.target.value})

    render = _ => (
      <div id='postContainer'>
        <input type='text' placeholder='いまどうしてる？' required='required' value={this.state.msg} onChange={this.changeMsg} />
        <Link to='/' className='btn' onClick={this.submit}>投稿</Link>
      </div>
    )
  }

  class MsgDelete extends React.Component {
    constructor(props) {
      super(props)
      this.submit = this.submit.bind(this)
    }

    submit() {
      const i = this.props.i
      msgDelete($seqno[i])
      $seqno.splice(i, 1)
      $id.splice(i, 1)
      $name.splice(i, 1)
      $date.splice(i, 1)
      $msg.splice(i, 1)
      $like.splice(i, 1)
    }

    render() {
      if ($name[this.props.i] == userName) {
        return (
          <Link to='/' className='msgDelete btn' onClick={this.submit}>削除</Link>
        )
      } else {
        return null
      }
    }
  }

  class MsgLike extends React.Component {
    constructor(props) {
      super(props)
      this.state  = {like: $like[this.props.i]}
      this.submit = this.submit.bind(this)
    }

    submit() {
      const i = this.props.i
      likeAdd($seqno[i], $like[i])
      this.setState({like: ++$like[i]})
    }

    render = _ => (
      <a className='displayLike btn' onClick={this.submit}>いいね！&ensp;{this.state.like}</a>
    )
  }

  const MsgList = (k, i) => (
    <div className='mainContainer' key={k}>
      <div className='msgName'>
        <span>{$id[i]}&nbsp;</span>
        @{$name[i]}&nbsp;&nbsp;&nbsp;&nbsp;
        {$date[i]}
      </div>
      <MsgDelete i={i} />
      <div className='displayMsg'>{$msg[i]}</div>
      <MsgLike i={i} />
    </div>
  )

  const DisplayMsg = _ => (
    <div>{
      $seqno.map(MsgList)
    }</div>
  )

  const MypostMsg = _ => (
    <div>{
      $seqno.map((k, i) => {
        if (userId !== $id[i]) return
        return MsgList(k, i)
      })
    }</div>
  )

  const SearchMsg = _ => (
    <div>{
      $seqno.map((k, i) => {
        const param = decodeURI(location.href.split('?')[1])
        if (param.slice(0, 1) == '@') {
          if (param.slice(1) !== $id[i]) return
        } else {
          if ($msg[i].indexOf(param) === -1 && $name[i].indexOf(param) === -1) return
        }
        return MsgList(k, i)
      })
    }</div>
  )

  const DisplayMain = _ => (
    <div>
      <PostMsg />
      <Route exact path='/' component={DisplayMsg} />
      <Route path='/mypost' component={MypostMsg} />
      <Route path='/search' component={SearchMsg} />
    </div>
  )

  const ScreenLayout = _ => (
    <HashRouter>
      <div id='screenContainer'>
        {/* Header */}
        <div id='headerTitle'><Link to='/'>BulletinBoard</Link></div>
        <div id='headerMargin'></div>
        <div id='headerSearch'><MsgSearch /></div>

        {/* main */}
        <div id='profileCard'><ProfileCard /></div>
        <div id='main'><DisplayMain /></div>
      </div>
    </HashRouter>
  )

  ReactDOM.render(
    <ScreenLayout />,
    document.getElementById('root')
  )
</script>

</html>
