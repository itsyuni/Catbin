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


function isLoggedIn() {

  if (isset($_COOKIE['SNID'])) {
          if (DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))) {
                  $userid = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))[0]['user_id'];

                  if (isset($_COOKIE['SNID_'])) {
                          return $userid;
                  } else {
                          $cstrong = True;
                          $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                          DB::query('INSERT INTO login_tokens VALUES (\'0\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
                          DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));

                          setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                          setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                          return $userid;
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
        <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://yastatic.net/jquery/3.3.1/jquery.js"></script>
        <link rel="stylesheet" href="/vendor-second.css">
        <link rel="stylesheet" href="/vendor.css">
        <link rel="stylesheet" href="/assets/fonts/stylesheet.css">
        <link rel="shortcut icon" href="favicon.png" type="image/png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
        <script src="script.js"></script>
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
            :root {
            --animate-duration: 800ms;
            --animate-delay: 0.9s;
            }  
            
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

                transform: translate(0px, 120%);
                opacity: 0;
                transition: all 1s ease 0s;
            }
            
            .catbin-descp, .active {
                transform: translate(0px, 0px);
                opacity: 1;
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

            .section-1 {
                height: 100vh;
                background-image: url(/assets/img/labs/header.jpg);
                background-attachment: fixed;
                background-size: cover;
                width: 1400px;
                background-position: center;
            }

            .box {
                width: 100%;
            }

            .section-2 {
                background-color: #000024;
                height: 750px;
            }

            .section-3 {
                height: 100vh;
                background-image: url(/assets/img/labs/labs-background.jpg);
                background-attachment: fixed;
                background-size: cover;
                background-position: center;
            }


            


        </style>
        <meta charset="UTF-8">
        <meta name=viewport content="initial-scale=0.5, minimum-scale=0.5, width=device-width">
    </head> 
<body oncontextmenu="return false" data-spy="scroll" data-target="#toc">
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
    <br><br><br>
    <div class="section-1 box"></div>
    <div class="section-2 box">
     <center><br><center><img width="270" height="150" class="animate__fadeInDown" src="/assets/img/labs/catbinlabstext_white.png"></center></center>
     <center><p style="font-size: 35px;" class="catbin-descp animate__fadeInDown"><b>Для самых любопытных и экспериментальных, подборка экспериментальных продуктов - это CatbinLabs</b></p></center></div>
    <div class="section-3 box"></div>
    <div class="section-4 box">
    <br><center><img width="100" height="150" class="animate__animated animate__fadeInLeft wow" src="/assets/img/labs/experiment_white.png"></center>
    <p style="font-size: 35px;" class="catbin-descp animate__animated animate__fadeInLeft">Catbin запускает новую платформу тестирования экспериментальных продуктов, принять участие в этом тестировании может каждый.</p>
    <center><img width="100" height="100" class="animate__fadeInLeft" src="/assets/img/labs/graphics_white.png"></center>
    <p style="font-size: 35px;" class="catbin-descp animate__fadeInLeft">Сводку о тестировании какого-либо ведёте вы. Мы можем только проанализировать по отзывам.</p>
    <center><img width="100" height="100" class="animate__fadeInLeft" src="/assets/img/labs/bug_white.png"></center>
    <p style="font-size: 35px;" class="catbin-descp animate__fadeInLeft">Вступая в программу тестирования CatbinLabs, вы соглашаетесь с <a href="/privacy/">политикой кондифициальности</a>, а также гарантию на то, что продукты могут быть нестабильными с кучей ошибок и глюков.</p>
    <br>
    </div>
    <center><a href="apps/" role="button" class="btn btn-primary btn-lg animate__fadeInLeft">Присоединиться</a></center>
    <br><br><br><br>
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
<br><br><br><br>