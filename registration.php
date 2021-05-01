<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include('DB.php');
include('UserInformation.php');


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
    header("Location: http://{$_SERVER['SERVER_NAME']}/apps/");
}

if (isset($_POST['createaccount'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $ip = UserInfo::get_ip();
        $versionos = UserInfo::get_os();
        $browser = UserInfo::get_browser();
        $verified = '0';
        $about = 'Привет, я пользователь Catbin!';
        $photourl = '/nophoto.jpg';
        $worker = '0';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $key = '6LdINbsZAAAAAOAH-FklczB6vaBbAoANkKs7jCrI';
        $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip'.$_SERVER['REMOTE_ADDR'];
        $data = json_decode(file_get_contents($query));
        
        if($_POST['g-recaptcha-response']) {
            
            if($data->success == true) {

                if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                    if (strlen($username) >= 5 && strlen($username) <= 15) {

                            if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

                                    if (strlen($password) >= 6 && strlen($password) <= 60) {

                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                    if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

                                            DB::query('INSERT INTO users VALUES (\'0\', :username, :password, :email, :ip, :browser, :version_os, \'0\', :about, :photourl, \'0\')', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email, ':ip'=>$ip, ':browser'=>$browser, ':version_os'=>$versionos, ':about'=>$about, ':photourl'=>$photourl));
                                            echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-success" role="alert">Успешная регистрация, можете входить в аккаунт!</div></div>';
                                    } else {
                                        echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">Почта уже используется</div></div>';
                                    }
                            } else {
                                echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">Некорректнй формат почты</div></div>';
                                    }
                            } else {
                                echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">Пароль должен быть от 6 до 60 символов</div></div>';
                            }
                            } else {
                                echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">Никнейм должен быть от 5 до 15 символов</div></div>';
                            }
                    } else {
                        echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">В никнейме содержатся кракозябры</div></div>';
                    }

            } else {
                echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">Такой никнейм уже занят</div></div>';
            }
            } else {

                echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">Вы точно робот?</div></div>';
            }
            } else {
                echo '<center><br><br><br><br><div class="alertlog"><div class="alert alert-danger" role="alert">Рекапча не заполнена</div></div>';
            }
                
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
        <link rel="stylesheet" href="/assets/fonts/montserrat/stylesheet.css">
        <link rel="stylesheet" href="/assets/scripts/css/login.css">
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
    <br>
    <center><form action="registration" class="form" method="POST">
        <br><br>
        <center><h3 class="form__title">Регистрация в CatbinID</h3></center>
        <br>
        

        <br><div class="form__div">
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <input type="nickname" class="form__input" placeholder=" " name="username" id="username">
            <label for="" class="form__label">Логин</label>
        </div>

        <div class="form__div">
            <input type="email" class="form__input" placeholder=" " name="email" id="email">
            <label for="" class="form__label">Электронная почта</label>
        </div>

        <div class="form__div">
            <input type="password" class="form__input" placeholder=" " name="password" id="password">
            <label for="" class="form__label">Пароль</label>
        </div>

        <center><input type="submit" class="form__button" value="Зарегистрироваться" name="createaccount"></center>
        <br><br><center><div class="g-recaptcha" data-sitekey="6LdINbsZAAAAALO9X5bvdLDVmRq880kpVszCRza3"></div></center>
        <br><br><br><center><a href="/login.php">У вас уже есть аккаунт?</a></center>
    </form></center>