<?php
  session_start();
  $mode = 'input';
  $errmessage = array();
  if ( isset($_POST['input']) && $_POST['input']) {
  } else if ( isset($_POST['send']) && $_POST['send']) {

    if (!$_POST['yourname']) {
      $errmessage[] = "お名前を入力してください";
    } else if ( mb_strlen($_POST['yourname']) > 100 ){
      $errmessage[]= "お名前は100文字以内にして下さい";
    }
    $_SESSION['yourname'] = htmlspecialchars($_POST['yourname'], ENT_QUOTES);

    if( !$_POST['email'] ){
      $errmessage[] = "メールアドレスを入力して下さい";
    } else if( mb_strlen($_POST['email']) > 200 ){
      $errmessage[] = "メールアドレスは200文字以内にして下さい";
    } else if( !filter_var($_POST['email'], FILTER_VALIDETE_EMAIL) ){
      $errmessage[] = "メールアドレスが不正です";
    }
    $_SESSION['email'] = htmlspecialchars($POST["email"], ENT_QUOTES);

    if ( !$_POST['message'] ){
      $errmessage[] = "お問い合わせ内容を入力して下さい";
    } else if( mb_strlen($_POST['message']) > 500 ){
      $errmessage = "お問い合わせ内容は500文字以内にして下さい";
    }
    $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);

    if ($errmessage) {
      $mode = 'input';
    } else {
      $mode = 'send';
    }

    $message = "お問い合わせを受け付けました\r\n"
    . "お名前" . $_SESSION['yourname'] . "\r\n"
    . "メールアドレス" . $_SESSION['email'] . "\r\n"
    . "内容:\r\n"
    . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message'] );
    mail($_SESSION['email'], "お問い合わせありがとうございます", $message );
    mail("Noukou.Syoumei@gmail.com", "お問い合わせありがとうございます", $message );
    $_SESSION = array();
  } else {
    $_SESSION = array();
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head prefix=”og:http://ogp.me/ns#”>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" href="/img/apple-touch-icon.png">
  <title>農工大ステージ研究会</title>
  <meta name="description" content="照明、音響、映像、衣装、大道具小道具等の美術、演出、VR/ARなどステージエンターテイメントに関すること全般の研究を行う農工大ステージ研の公式サイト">
  <meta name="keywords" content="ステージ研,ステージ研究会,照明,音響,映像,衣装,美術,演出,舞台,VR,AR,プロジェクションマッピング,農工大,東京農工大学">
  <link rel="canonical" href="https://stageken.github.io/">
  <!-- ogp -->
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:site" content="@tuatsyoumei"/>
  <meta property="og:title" content="農工大ステージ研"/>
  <meta property="og:type" content="website"/>
  <meta property="og:url" content="https://stageken.github.io/"/>
  <meta property="og:description" content="照明、音響、映像、衣装、大道具小道具等の美術、演出、VR/ARなどステージエンターテイメントに関すること全般の研究を行う農工大ステージ研の公式サイト"/>
  <meta property="og:image" content="/img/logo.png"/>
  <meta property="og:site_name" content="農工大ステージ研"/>
  <!-- ogp end-->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script src="/script.js"></script>
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <header class="header">
    <h1 class="logo"><a href="/">農工大ステージ研</a></h1>
    <nav class="global-nav">
      <div class="nav-content">
        <li>
          <div class="nav-icon">
            <div class="nav-bar"></div>
            <div class="nav-bar"></div>
            <div class="nav-bar"></div>
          </div>
          <ul>
            <li class="nav-item"><a href="/">TOP</a></li>
            <li class="nav-item"><a href="/news/">NEWS</a></li>
            <li class="nav-item"><a href="/event/">EVENT</a></li>
            <!-- <li class="nav-item"><a href="/exhibition/">EXHIBITION</a></li> -->
            <li class="nav-item"><a href="/works/">WORKS</a></li>
            <li class="nav-item"><a href="/contact/">CONTACT</a></li>
            <li class="nav-item"><a href="https://ameblo.jp/noukou-stage/">BLOG</a></li>
          </ul>
        </li>
      </div>
    </nav>
  </header>
  <main class="main">
    <h2 class="section">CONTACT</h2>
    <div class="contact-form">
      <?php if($mode == "input") { ?>
        <!-- 入力画面　-->
        <?php
        if( $errmessage ){
          echo '<div class="alert alert-danger" role="alert">';
          echo implode('<br>', $errmessage );
          echo '</div>';
        }
        ?>
        <form action="./contactform.php" method="POST">
          <div class="form-item">
            <label for="yourname" class="required-information">
              お名前
            </label>
            <input id="yourname" type="text" name="yourname" value="<?php echo $_SESSION['yourname'] ?>">
          </div>
          <div class="form-item">
            <label for="email" class="required-information">
              メールアドレス
            </label>
            <input id="email" type="email" name="email" value="<?php echo $_SESSION['email'] ?>">
          </div>
          <div class="form-item">
            <label for="textarea" class="required-information">
              内容
            </label>
            <textarea id="message" name="message"><?php echo $_SESSION['message'] ?></textarea>
          </div>
          <div class="form-item">
            <button type="submit" name="send" value="send">送信</button>
          </div>
        </form>
      <?php } else { ?>
        <!-- 完了画面 -->
        <div class="completed">
          送信しました。お問い合わせありがとうございました。
        </div>
      <?php } ?>
    </div>

    <div class="snsitem">
      <h5 class="twitter">twitter</h5>
      <a class="twitter-timeline" data-width="320" data-height="400" 
      data-chrome=”noheadernofooter” href="https://twitter.com/tuatsyoumei?ref_src=twsrc%5Etfw">Tweets by tuatsyoumei</a>
    </div>
  </main>
  <footer class="footer">
    <p class="copyright">Copyright © 2021 STAGEKEN.</p>
  </footer>
</body>
</html>