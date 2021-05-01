<?php
include('UserInformation.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class DB {

    private static function connect() {
            $pdo = new PDO('mysql:host=95.181.157.246;dbname=catbin_u;charset=utf8', 'mohooks', 'chikiMOHO');
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

if (isLoggedIn()) {
    
}
error_reporting(E_ALL);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Catbin | Каталог мини-приложеий</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="vendor-second.css">
        <link rel="stylesheet" href="vendor.css">
        <link rel="stylesheet" href="/assets/fonts/stylesheet.css">
        <link rel="stylesheet" href="/assets/fonts/montserrat/stylesheet.css">
        <script data-ad-client="ca-pub-1559110670812414" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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

            @media (min-width: 1025px) {
            .catbin-descp {
              margin-right: 1200px;
              margin-left: 256px;
                font-family: 'Montserrat';
            }
            
            .footer {
              background-color: #151515;
              height: 230px;
            }
            .imgfooter {
              width: 100px;
              height: 130px;
              margin-left: 64px;
              margin-top: 20px;
            }
          
          .textfooter {
            margin-left: 64px;
          } }

            @media (min-width: 801px) {
            .catbin-descp {
              margin-right: 600px;
              margin-left: 64px;
                font-family: 'Montserrat';
            }
            .footer {
              background-color: #151515;
              height: 230px;
            }
            .imgfooter {
              width: 100px;
              height: 130px;
              margin-left: 64px;
              margin-top: 20px;
            }
          
          .textfooter {
            margin-left: 64px;
          } }
             

            
            @media (max-width: 1024px) {
            .catbin-descp {
              margin-right: 500px;
              margin-left: 64px;
                font-family: 'Montserrat';
            }
            .footer {
              background-color: #151515;
              height: 230px;
            }
            .imgfooter {
              width: 100px;
              height: 130px;
              margin-left: 64px;
              margin-top: 20px;
            }
          
          .textfooter {
            margin-left: 64px;
          } 
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
              font-family: 'Montserrat';
            }

            @media (max-width: 800px) {
              .catbin-descp {
              margin-right: 150px;
              margin-left: 32px;
                font-family: 'Montserrat';
            } 
            .footer {
              background-color: #151515;
              height: 230px;
            }
            .imgfooter {
              width: 100px;
              height: 130px;
              margin-left: 64px;
              margin-top: 20px;
            }
          
          .textfooter {
            margin-left: 64px;
          } }
            
        


            


        </style>
        <meta charset="UTF-8">
        <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
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
    <br><br>
    <br><br><br><center><h1 style="font-size: 25px; color: aliceblue; font-family: 'Montserrat';">Catbin - больше не каталог миниприложений.</h1></center><br>
    <center><h1 style="font-size: 30px; color: aliceblue; font-family: 'Montserrat'; margin-right: 32px; margin-left: 32px;">Теперь это <b>облачный сервис</b>. Для тебя. Для меня. Для всех.</h1></center>
    <br><br>
    <center><div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="assets/img/cards/card1-wide.jpg" class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="assets/img/cards/card2-wide.jpg" class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="assets/img/cards/card3-wide.jpg" class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" alt="...">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div></center>
      <br><br><hr><br>
      <center><h1 style="font-size: 50px; font-family: 'Montserrat';">Почему именно <b>Catbin</b>?</h1></center>
      <br><br>
      <img src="/assets/img/airplane.png" class="catbin-descp">
      <h5 class="catbin-descp">Catbin никогда не подведёт вас в скорости, даже при огромной нагрузке на сайт. Вы сможете получить доступ к мини-приложениям всегда и везде.</h5>
      <br><br><br>
      <img src="/assets/img/gadgets.png" class="catbin-descp">
      <h5 class="catbin-descp">В Catbin вы можете заходить с разных устройств, с любого места. Catbin уже совсем скоро будет поддерживать вход через: Google, ВКонтакте, Facebook и т.д.</h5>
      <br><br><br>
      <img src="/assets/img/disk.png" class="catbin-descp">
      <h5 class="catbin-descp">У вас осталось очень мало места на диске, но там хранятся важные данные которые нельзя удалить, но под рукой у вас нету телефона, а устанавливать сотни приложений не хочется? Мы вас поняли.</h5>
      <br><br><br><img width="100" class="catbin-descp" height="100" src="assets/img/video_white.png">
      <h5 class="catbin-descp">Хотите стать популярным среди сообщества Catbin? Тогда это предложение для вас! Запишите видео-обзор Catbin, расскажите о нём и что в нём есть. Как только всё будет готово, отправьте ссылку на видео на адрес: <a href="mailto:support@catbin.ru">support@catbin.ru</a> с пометкой, что это видео от сообщества! Как только мы рассмотрим вашу заявку, мы опубликуем ваше видео по адресу: <a href="community_videos">https://catbin.ru/community_videos</a>. Дерзайте!</h5>
      <br><img width="100" height="100" class="catbin-descp" src="assets/img/users_white.png"><br><br>  
      <h5 class="catbin-descp">Общение с другими людьми сообщества Catbin? Уже совсем скоро! Вам также нужно просто зарегистрироваться, по желанию подписаться на группу ВКонтакте <a href="https://vk.com/catbn">https://vk.com/catb1n</a> и следить за новостями.</h5>
<center>
<br><br><br><br><br>
<div class="footer">
      <img src="/assets/img/catbin.png" class="imgfooter">
      <br><br>
      <h5 class="textfooter">Catbin © 2020 | На oснове сетях <a href="https://yunihost.ru">Юни.хостинга</a></h5>
    </div>
</body>
</html>