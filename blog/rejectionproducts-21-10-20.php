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
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/vendor.css">
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/style.css">
        <link rel="stylesheet" href="/assets/fonts/montserrat/stylesheet.css"
        <link rel="stylesheet" href="/assets/fonts/stylesheet.css">
        <link rel="shortcut icon" type="image/png" href="favicon.png"/>
        <script data-ad-client="ca-pub-1559110670812414" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(66291088, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/66291088" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
        <script>
         window.dataLayer = window.dataLayer || [];
          function gtag(){dataLaye  r.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-174561723-1');
        </script>
        <style>
            body { background-color: #222226; font-family: Google Sans; }
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

            @media (min-width: 1025px) {
                .content {
                margin-right: 128px;
                margin-left: 128px;
            } }

            @media (min-width: 801px) {
                .content {
                margin-right: 32px;
                margin-left: 32px;
            } }

            
            @media (max-width: 1024px) {
                .content {
                margin-right: 64px;
                margin-left: 64px;
            } }

            @media (max-width: 800px) {
                .content {
                margin-right: 32px;
                margin-left: 32px;
            } }

            .blog-text {
                font-family: 'Montserrat';
            }

            .uk-accordion {
                background-color: aliceblue;
            }

            .catbin-descp {
                margin: 64px;
            }

            a, li, h1, h2, h3, h4, h5, h6, p {
                color: aliceblue;
            }

            a {
              text-decoration: none;
            }
            
            a:hover {
              color: #DADCE0;
            }



        </style>
        <meta charset="UTF-8">
        <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
    </head> 
    <body oncontextmenu="return false" data-spy="scroll" data-target="#toc">
<script src="https://sindresorhus.com/devtools-detect/index.js"></script>
    <script>
    document.currentScript.parentElement.volume = 0.50;
        if(window.devtools.isOpen) { window.location.href = "/antipiracy"; }
         window.addEventListener('devtoolschange', event => { window.location.href = "/antipiracy"; });
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
                            <a class="nav-item nav-link active" href="/">Главная</a>
                            <a class="nav-item nav-link" href="/community_videos">Видео о Catbin</a>
                            <?php
                            if (isLoggedIn()) { ?>
                              <a class="nav-item nav-link" href="/welcome">Главное меню</a>
                              <a class="nav-item nav-link" href="/@<?php echo getUsername(); ?>">Профиль</a>
                               <?php
                            } else { ?>
                              <a class="nav-item nav-link" href="/login">Войти в CatbinID</a> <?php
                            } ?>
                </div>
              </nav>
            </div>
        </div>
    </header>
<br><br><br><br><br><br><br>
<div class="content">
<h1 class="blog-text"><b>Отказ от CatbinLabs, CatbinGames, CatbinMiniApps.</b></h1>
<br>
<h4 class="blog-text">21.10.2020 21:20</h4>
<br><br><br>
<h3 class="blog-text">Всем привет. На связи главный разработчик Catbin - Максим Жуйков. Сегодня я расскажу, почему мы решили отказаться от отдельных продуктов, таких как: CatbinMiniApps, CatbinLabs, CatbinGames. Ну что ж, начнём. <br><br><br> Проект Catbin родился на свет 1 августа. Тогда, он не был облачным сервисом, а обычным агрегатором мини-приложений, аналог VK MiniApps. Но со временем, появлялись новые продукты, которые просто не вписывались в рамки агрегатора мини-приложений. Тогда было принято решение сменить концепцию.<br><br><br> CatbinLabs вышел на свет в конце августа. Но с тех пор, он больше не менялся. Как были два приложения, один из которых еще в разработке, так и остались. CatbinGames тоже не менялся. Вышел он также, в конце августа, или в начале сентября. Не помню. Суть не в этом. Мы не занимались их обновлением. Пользователи даже и не заметили такого, что на первый взгляд, немного удивительно.<br><br><br> У нас уже есть второй сервер, мы плаируем открыть ещё несколько продуктов. Планируется публикация ваших собственных прложений Catbin, вход и регистрация через VK и многое другое. Раскрывать полностью не буду.<br><br><br> В общем, чтобы предотвратить такую безалаберность, CatbinGames, CatbinLabs, CatbinMiniApps объединятся в один единый продукт - CatbinApps. Произойдёт это 1 ноября, но попробовать такой продукт, вы сможете уже совсем скоро.</h3>
</div><br><br><br><br><br><br><br><br><br><br>