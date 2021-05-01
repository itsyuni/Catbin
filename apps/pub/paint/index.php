<?php
class DB {

  private static function connect() {
          $pdo = new PDO('mysql:host=localhost;dbname=catbin_u;charset=utf8', 'mohooks', 'chikiMOHO');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $pdo;
  }

  public static function query($query, $params = array()) {
          $statement = self::connect()->prepare($query);
          $statement->execute($params);

          if (explode(' ', $query)[0] == 'SELECT') {
          $data = $statement->fetchAll();
          return $data;
          }
  }

}

function getUsername() {

  if (isset($_COOKIE['SNID'])) {
      $usernameid = isLoggedIn();
          if (DB::query('SELECT username FROM users WHERE id=:idu', array(':idu'=>$usernameid))) {
                  $username = DB::query('SELECT username FROM users WHERE id=:idu', array(':idu'=>$usernameid))[0]['username'];

                  if (isset($_COOKIE['SNID_'])) {
                          return $username;
                  } else {
                          $cstrong = True;
                          $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                          DB::query('INSERT INTO login_tokens VALUES (\'0\', :token, :user_id)', array(':token'=>sha1($token), ':username'=>$username));
                          DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));

                          setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                          setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                          return $username;
                  }
          }
  }

  return false;
}






if (!isLoggedIn()) {
  header("Location: http://{$_SERVER['SERVER_NAME']}/login.php");
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Catbin | Каталог мини-приложеий</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/vendor-second.css">
        <link rel="stylesheet" href="/vendor.css">
        <link rel="stylesheet" href="styles-paint.css">
        <link rel="shortcut icon" type="image/png" href="favicon.png"/>
        <script src="painting.js"></script>
        <link rel="stylesheet" href="/assets/fonts/stylesheet.css">
        <script data-ad-client="ca-pub-3148028603897760" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-174561723-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-174561723-1');
</script>

        <style>
            body { background:url(/assets/img/winterb.png) fixed center;
                   background-image: url(/assets/img/winterb.png); 
                   background-attachment: fixed;
                   background-position: center; font-family: Google Sans; }
            @font-face {
                font-family: 'Google Sans';
                src: url('/assets/fonts/GoogleSans-Medium.eot');
                src: local('Google Sans Medium'), local('GoogleSans-Medium'),
                    url('/assets/fonts/GoogleSans-Medium.eot?#iefix') format('embedded-opentype'),
                    url('/assets/fonts/GoogleSans-Medium.woff2') format('woff2'),
                    url('/assets/fonts/GoogleSans-Medium.woff') format('woff'),
                    url('/assets/fonts/GoogleSans-Medium.ttf') format('truetype');
                font-weight: 500;
                font-style: normal;
                            }
            .background-accordion {
                background-color: aliceblue;
            }

            .uk-accordion {
                background-color: aliceblue;
            }

            .catbin-descp {
                margin: 64px;
            }

            a, li, h1, h2, h3, h4, h5, h6, p, span {
                color: aliceblue;
                font-family: 'Google Sans';
            }

            a {
              text-decoration: none;
            }
            
            a:hover {
              color: #DADCE0;
            }

            .catbin-featch {
              margin-right: 64px;
              margin-left: 64px;
            }


            


        </style>
        <meta charset="UTF-8">
        <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
    </head> 
<body oncontextmenu="return false" data-spy="scroll" data-target="#toc">
<script src="https://sindresorhus.com/devtools-detect/index.js"></script>
    <script>
    document.currentScript.parentElement.volume = 0.50;
        if(window.devtools.isOpen) { window.location.href = "antipiracy"; }
         window.addEventListener('devtoolschange', event => { window.location.href = "antipiracy"; });
    </script>
  <header class="header header-sticky header-transparent" >
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-dark">
                
                    <a class="navbar-brand" href="/">
                    <img src="/assets/img/catbintext.png" width="80" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav ml-auto">
                        <li class="nav-item active"></li>
                            <a class="nav-item nav-link" href="/">Главная</a>
                            <a class="nav-item nav-link" href="/community_videos">Видео о Catbin</a>
                            <?php
                            if (isLoggedIn()) { ?>
                              <a class="nav-item nav-link active" href="/welcome">Главное меню</a>
                              <a class="nav-item nav-link" href="/profile?username=<?php echo getUsername(); ?>">Профиль</a>
                               <?php
                            } else { ?>
                              <a class="nav-item nav-link" href="/login">Войти в CatbinID</a> <?php
                            } ?>
                </div>
              </nav>
            </div>
        </div>
    </header>
    <br><br><br><br><br>
    <main>
      <div class="left-block">
        <div class="colors">
          <button type="button" value="#0000ff"></button>
          <button type="button" value="#009fff"></button>
          <button type="button" value="#0fffff"></button>
          <button type="button" value="#bfffff"></button>
          <button type="button" value="#000000"></button>
          <button type="button" value="#333333"></button>
          <button type="button" value="#666666"></button>
          <button type="button" value="#999999"></button>
          <button type="button" value="#ffcc66"></button>
          <button type="button" value="#ffcc00"></button>
          <button type="button" value="#ffff00"></button>
          <button type="button" value="#ffff99"></button>
          <button type="button" value="#003300"></button>
          <button type="button" value="#555000"></button>
          <button type="button" value="#00ff00"></button>
          <button type="button" value="#99ff99"></button>
          <button type="button" value="#f00000"></button>
          <button type="button" value="#ff6600"></button>
          <button type="button" value="#ff9933"></button>
          <button type="button" value="#f5deb3"></button>
          <button type="button" value="#330000"></button>
          <button type="button" value="#663300"></button>
          <button type="button" value="#cc6600"></button>
          <button type="button" value="#deb887"></button>
          <button type="button" value="#aa0fff"></button>
          <button type="button" value="#cc66cc"></button>
          <button type="button" value="#ff66ff"></button>
          <button type="button" value="#ff99ff"></button>
          <button type="button" value="#e8c4e8"></button>
          <button type="button" value="#ffffff"></button>
        </div>
        <div class="brushes">
          <button type="button" value="1"></button>
          <button type="button" value="2"></button>
          <button type="button" value="3"></button>
          <button type="button" value="4"></button>
          <button type="button" value="5"></button>
        </div>
        <div class="buttons">
          <button id="clear" type="button">Очистить холст</button>
          <button id="save" type="button">Сохранить</button>
        </div>
      </div>
      <div class="right-block">
        <canvas id="paint-canvas" width="640" height="400"></canvas>
      </div>
    </main>
    <br><br><br>
    <script async src="https://yastatic.net/pcode-native/loaders/loader.js"></script>
    <script>
        (yaads = window.yaads || []).push({
            id: "622996-1",
            render: "#id-622996-1"
        });
    </script>
    <div id="id-622996-1"></div>

    <!-- Yandex.RTB R-A-622996-2 -->
<div id="yandex_rtb_R-A-622996-2"></div>
<script type="text/javascript">
    (function(w, d, n, s, t) {
        w[n] = w[n] || [];
        w[n].push(function() {
            Ya.Context.AdvManager.render({
                blockId: "R-A-622996-2",
                renderTo: "yandex_rtb_R-A-622996-2",
                async: true
            });
        });
        t = d.getElementsByTagName("script")[0];
        s = d.createElement("script");
        s.type = "text/javascript";
        s.src = "//an.yandex.ru/system/context.js";
        s.async = true;
        t.parentNode.insertBefore(s, t);
    })(this, this.document, "yandexContextAsyncCallbacks");
</script>

</div>