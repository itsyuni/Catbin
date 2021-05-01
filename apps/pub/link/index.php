<?php

$host = '95.181.157.246';
$dbuser = 'mohooks';
$dbpass = 'chikiMOHO';
$dbname = 'catbin_u';
$siteurl = 'https://ctli.ru';


$connect = new mysqli($host, $dbuser, $dbpass, $dbname);
if (!$connect) {
    echo '<script>alert("Не получилось подключиться к базе данных!")</script>';
}
function generateRandomString($length = 3) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if (isset($_GET['title'])) {
    $res = $connect->prepare("SELECT * FROM links WHERE title=?");
    $res->bind_param("s", $_GET['title']);
    $res->execute();
    $goto = $res->get_result()->fetch_array();
    $g = $goto[1];
    header ("Location: $g");
}
if (isset($_POST['shrt'])) {
    $title = generateRandomString();
  	if (substr($_POST['textarea'], 0, 4) != "http") {
      $url = "http://".$_POST['textarea'];
    } else {
    $url = $_POST['textarea'];
    }
	$res = $connect->prepare("INSERT INTO links VALUES('',?,?)");
  	$res->bind_param("ss",$url,$title);
  	$res->execute();
    echo "<script>prompt('Ссылка укорочена:', '".$siteurl."/".$title."');</script>"; 
}

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
        <title>Catbin | Укоротитель ссылок</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/vendor.css">
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/style.css">
        <link rel="stylesheet" href="/assets/fonts/stylesheet.css">
        <link rel="shortcut icon" type="image/png" href="favicon.png"/>
        <link rel="stylesheet" href="style.css">
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

            .uk-accordion {
                background-color: aliceblue;
            }

            .catbin-descp {
                margin: 64px;
            }

            a, li, h1, h2, h3, h4, h5, h6, p, label {
                color: aliceblue;
                font-family: 'Google Sans';
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
    </head> 
<body>
<script src="https://sindresorhus.com/devtools-detect/index.js"></script>
    <script>
    document.currentScript.parentElement.volume = 0.50;
        if(window.devtools.isOpen) { window.location.href = "/antipiracy"; }
         window.addEventListener('devtoolschange', event => { window.location.href = "/antipiracy"; });
    </script>    <header class="header header-sticky header-transparent" >
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <a class="navbar-brand" href="index.html">
                    <img src="/assets/img/catbintext.png" width="80" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                    <span class="badge badge-small badge-primary">BETA </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav ml-auto">
                        <li class="nav-item active"></li>
                            <a style="" class="nav-item nav-link dropdown-toggledropdown-toggle active" href="/" id="dropdown-1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Главная</a>
                            <a style="" class="nav-item nav-link" href="/apps">Каталог приложений</a>
                            <a style="" class="nav-item nav-link" href="/support">Помощь</a>
                            <a style="" class="nav-item nav-link" href="/login">Войти</a>
                </div>
              </nav>
            </div>
        </div>
    </header>
    <br><br><br><br><br><center><h1>Сокращатель ссылок</h1></center>
    <br><br><br>
    <center><div class="l-form">
            <form action="index" method="post" class="form">

                <div class="form__div">
                    <input type="text" class="form__input" placeholder=" " name="textarea" id="username">
                    <label for="" class="form__label">Ваша длинная ссылка</label>
                </div>

                <center><input type="submit" class="form__button" value="Укоротить" name="shrt" id="shrt"></center>
            </form></center>
        </div>
    </div>
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
</body>
</html>