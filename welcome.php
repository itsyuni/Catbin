<?php
include('DB.php');

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


if(isset($_POST['profile'])) {
    header("Location: https://{$_SERVER['SERVER_NAME']}/profile?id=$userid");
}

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
        <script data-ad-client="ca-pub-1559110670812414" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-174561723-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-174561723-1');
</script>
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


            @media (min-width: 1025px) {
              .updatelist {
                margin-left: 100px;
                margin-right: 100px;
                } }

            @media (min-width: 801px) {
              .updatelist {
                } }

            
            @media (max-width: 1024px) {
              .updatelist {
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
                            <a class="nav-item nav-link" href="/">Главная</a>
                            <a class="nav-item nav-link" href="/community_videos">Видео о Catbin</a>
                            <?php
                            if (isLoggedIn()) { ?>
                              <a class="nav-item nav-link active" href="/welcome">Главное меню</a>
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
    <br><br><br>
    <center><?php
            date_default_timezone_set('Europe/Moscow');
            $hour = date('G');
            if ($hour >= 5 && $hour <= 10) {
                ?> <h1>Доброе утро, <?php echo getUsername(); ?>!</h1>
            <?php } else if ($hour >= 11 && $hour <= 16) {
                ?> <h1>Добрый день, <?php echo getUsername(); ?>!</h1>
            <?php } else if ($hour >= 17 && $hour <= 22) {
            ?> <h1>Добрый вечер, <?php echo getUsername(); ?>!</h1>
            <?php } else if ($hour >= 23 && $hour <=4) {
            ?> <h1>Спокойной ночи, <?php echo getUsername(); ?>!</h1>
            <?php } ?>    </center>
    <br>
    <link rel="stylesheet" href="/canvasvendor.css">
 <div class="my-3 p-3 bg-white rounded shadow-sm updatelist" >
    <h6 style="color: black;" class="border-bottom border-gray pb-2 mb-0">Последние обновления</h6>
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" style="color: black;">
        <strong class="d-block text-gray-dark"><b>Глобальный релиз Catbin!</b></strong>
        Спустя четырёх месяцев тестирования, мы вышли на глобальный релиз! Новые сногшибательные продукты уже не за горами =)
      </p>
    </div>
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#e83e8c"/><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" style="color: black;">
        <strong class="d-block text-gray-dark">Исправление ошибок</strong>
        Мы прибрались у себя дома, чтобы вам стало комфортнее находиться.
      </p>
    </div>
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#6f42c1"/><text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" style="color: black;">
        <strong class="d-block text-gray-dark">Играйте не выходя из дома</strong>
        Мы представили новый каталог игр! Играйте сколько угодно, с кем угодно, где угодно. Установка дополнительноо ПО не требуется.
      </p>
    </div>
    <small style="color: black;" class="d-block text-right mt-3">
      <a style="color: #007acc;" href="/updatelist.php">Прошлые обновления</a>
    </small>
  </div>
  <br>
  <div class="container padding">
        <div class="row padding">
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/appsnew.png" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinApps</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Лёгкие, удобные. Не требуют установки</p>   
                        <center><a class="btn btn-warning" href="/apps/">Перейти</a></center>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/imagesnew.png" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinImages</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Бесплатный и удобный хостинг картинок.</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/cloud.png" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinCloud</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Дешёвое, однако быстрое облачное хранилище.</p>   
                        <center><a class="btn btn-warning" href="/cloud/">Перейти</a></center>
                    </div>
                </div>
            </div>
        </div>
  </div><br>
  <div class="container padding">
        <div class="row padding">
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/edu.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinEdu</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Обучайтесь онлайн вместе с Catbin без проблем, если вам помешал COVID-19.</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/enginecloud.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinEngineCloud</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Вам нужны наши ресурсы для ваших проектов? Нет проблем! Вы можете взять в аренду у нас.</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/imageedit.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinEditImage</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Редактор фотографий в браузере? Хорошо, так и запишем...</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
        </div>
  </div><br>
  <div class="container padding">
        <div class="row padding">
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/links.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinLinks</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Длинные ссылки это всегда не красиво, упрощайте ихс помощью CatbinLinks!</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/meetings.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinMeetings</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Организуйте встречу со своими друзьями, одноклассниками и т.д дистанционно с помощью CatbinMeetings, если вам помешал COVID-19.</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/moneylink.png" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinMoneyLinks</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Зарабатывать легко - это задача, но попробуйте заработать на ссылках с помощью CatbinMoneyLinks!</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
        </div>
  </div><br>
  <div class="container padding">
        <div class="row padding">
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/videodownload.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinVideoDownload</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Легко скачивайте видео с более 30 источников с помощью CatbinVideoDownload!</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/webcreator.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <center><b><h4 style="color: #000;" class="card-title">CatbinWebCreator</h4></b></center>
                        <hr>
                        <p style="color: #000;" class="card-text">Легко и быстро создайте свой сайт с помощью CatbinWebCreator!</p>   
                        <center><a class="btn btn-secondary">В разработке</a></center>
                    </div>
                </div>
            </div>
        </div>
  </div>