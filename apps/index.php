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
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/vendor.css">
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/style.css">
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

            a, li, h1, h2, h3, h4, h5, h6, p {
                color: aliceblue;
            }

            a {
              text-decoration: none;
            }
            
            a:hover {
              color: #DADCE0;
            }

            .tag {
            background-color: #ccc;
            color: #fff;
            border-radius: 50px;
            font-size: 12px;
            margin: 0;
            padding: 2px 10px;
            text-transform: uppercase;
            }
            .tag-apps {
            background-color: #0059ff;
            }
            .tag-game {
            background-color: #3d1d94;
            }
            .tag-labs {
            background-color: #2bcd2b;
            }

            .cnopka {
              margin-left: 20px;
              padding: 9px 25px;
              background-color: #262727;
              border: none;
              border-radius: 15px;
              border-width: 5px;
              cursor: pointer;
            }
            .container-n {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  width: 940px;
  margin: auto;
}

.container-n {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  width: 940px;
  margin: auto;
}
.card-n {
  background-color: rgb(27, 27, 27);
  border-radius: 10px;
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  width: 300px;
}
.card-header-n img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.card-body-n {
  display: flex;
  flex-direction: column;
  align-items: start;
  padding: 20px;
  min-height: 250px;
}
.tag {
  background-color: #ccc;
  color: #fff;
  border-radius: 50px;
  font-size: 12px;
  margin: 0;
  padding: 2px 10px;
  text-transform: uppercase;
}
.tag-apps {
  background-color: #0059ff;
}
.tag-game {
  background-color: #3d1d94;
}
.tag-labs {
  background-color: #2bcd2b;
}
.card-body-n h4 {
  margin: 10px 0;
}
.card-body-n p {
  font-size: 14px;
  margin: 0 0 40px 0;
  font-weight: 500;
  color: rgb(252, 252, 252);
}

@media (max-width: 940px) {
  .container-n {
    grid-template-columns: 1fr;
    justify-items: center;
  }
}

.catbin-descp {
                margin-right: 64px;
              margin-left: 64px;
            }
    .content {
        justify-content: center;
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
    <div class="container padding">
        <div class="row padding">
            <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/apps.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <span class="tag tag-apps">CatbinApps</span>
                        <h4 style="color: #000;" class="card-title">CatbinMiniApps</h4>  
                        <p style="color: #000;" class="card-text">Лёгкие, удобные. Не требуют установки</p>   
                        <center><a class="btn btn-warning" href="pub/">Перейти</a></center>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/games.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <span class="tag tag-game">CatbinApps</span>
                        <h4 style="color: #000;" class="card-title">CatbinGames</h4>  
                        <p style="color: #000;" class="card-text">Игры в браузере, от разных авторов.</p><br> 
                        <center><a class="btn btn-dark" href="games/">Перейти</a></center>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="card">
                    <img src="/assets/img/cards/welcome/labs.jpg" alt="Калькулятор">
                    <div class="card-body">
                        <span class="tag tag-labs">CatbinApps</span>
                        <h4 style="color: #000;" class="card-title">CatbinLabs</h4>  
                        <p style="color: #000;" class="card-text">Самые необычные, сумасшедшие идеи, от их создателей.</p>   
                        <center><a class="btn btn-warning" href="labs/">Перейти</a></center>
                    </div>
                </div>
            </div>
        </div>
        </div>