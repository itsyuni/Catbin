<?php

class DB {

    private static function connect() {
            $pdo = new PDO('mysql:host=localhost;dbname=mohooks_catbin;charset=utf8', 'mohooks_user', 'mohookscatbin');
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
                                DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
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
       <title></title>
       <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/vendor.css">
        <link rel="stylesheet" href="https://webuildthemes.com/guidebook/assets/css/style.css">
        <link rel="stylesheet" href="/assets/fonts/stylesheet.css">
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
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
       <script>
       // Setup End Date for Countdown (getTime == Time in Milleseconds)
let launchDate = new Date("Sep 01, 2020 00:00:00").getTime();

// Setup Timer to tick every 1 second
let timer = setInterval(tick, 1000);

function tick () {
  // Get current time
  let now = new Date().getTime();
  // Get the difference in time to get time left until reaches 0
  let t = launchDate - now;

  // Check if time is above 0
  if (t > 0) {
    // Setup Days, hours, seconds and minutes
    // Algorithm to calculate days...
    let days = Math.floor(t / (1000 * 60 * 60 * 24));
    // prefix any number below 10 with a "0" E.g. 1 = 01
    if (days < 10) { days = "0" + days; }
    
    // Algorithm to calculate hours
    let hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    if (hours < 10) { hours = "0" + hours; }

    // Algorithm to calculate minutes
    let mins = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
    if (mins < 10) { mins = "0" + mins; }

    // Algorithm to calc seconds
    let secs = Math.floor((t % (1000 * 60)) / 1000);
    if (secs < 10) { secs = "0" + secs; }

    // Create Time String
    let time = `${days} : ${hours} : ${mins} : ${secs}`;

    // Set time on document
    document.querySelector('.countdown').innerText = time;
  }
}

       </script>
       <style>
       body {
       background-color: #222226;
       }
       h1 {
  font-weight: normal;
}

li {
  display: inline-block;
  font-size: 1.5em;
  list-style-type: none;
  padding: 1em;
  text-transform: uppercase;
}

li span {
  display: block;
  font-size: 4.5rem;
}

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

            footer {
                background-color: #222226;
            }

            * {
							  box-sizing: border-box;
							  margin: 0;
							  padding: 0;
							}

							h1 {
							  font-weight: normal;
							}

							li {
							  display: inline-block;
							  font-size: 1.5em;
							  list-style-type: none;
							  padding: 1em;
							  text-transform: uppercase;
							}

							li span {
							  display: block;
							  font-size: 4.5rem;
							}

							html, body {
							  height: 100%;
							  margin: 0;
							}

							.containerttt {
							  color: #333;
							  margin: 0 auto;
							  padding: 0.5rem;
							  text-align: center;
							}
            </style>

            <script src="catbin-time.js"></script>
            <script src="christmas.js"></script>
            <script src="fall.js"></script>
            <script src="karantin.js"></script>
            <script src="new-year.js"></script>
            <script src="spring.js"></script>
            <script src="summer.js"></script>
            <script src="winter.js"></script>
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
                            <a style="" class="nav-item nav-link dropdown-toggledropdown-toggle active" href="#" id="dropdown-1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Главная</a>
                            <a style="" class="nav-item nav-link" href="apps">Каталог приложений</a>
                            <a style="" class="nav-item nav-link" href="support">Помощь</a>
                            <a style="" class="nav-item nav-link" href="login">Войти</a>
                </div>
              </nav>
            </div>
        </div>
    </header>
    <br><br><br><br><br>
    <div class="containerttt">
					<center><h1>До конца лета осталось:</h1>
					  <ul>
					  </ul>
					</div>
                    <br>
                    <center><h1>С момента запуска Catbin прошло:</h1>
					  <ul>
                      <div style="color: #fff; font-size: 50px;" class="countdown">00 : 00 : 00 : 00</div>
					  </ul>
					</div>
                    <br>
                    <center><h1>До рождества осталось:</h1>
					  <ul>
                      <div style="color: #fff; font-size: 50px;" class="countdownch">00 : 00 : 00 : 00</div>
					  </ul>
					</div>
                    <br>
                    <center><h1>До начала осени осталось:</h1>
					  <ul>
					    <li><span id="days-fall"></span>Дней</li>
					    <li><span id="hours-fall"></span>Часов</li>
					    <li><span id="minutes-fall"></span>Минут</li>
					    <li><span id="seconds-fall"></span>Секунд</li>
					  </ul>
					</div>
                    <br>
                    <center><h1>С момента начала карантина против Covid-19 прошло:</h1>
					  <ul>
					    <li><span id="days-karantin"></span>Дней</li>
					    <li><span id="hours-karantin"></span>Часов</li>
					    <li><span id="minutes-karantin"></span>Минут</li>
					    <li><span id="seconds-karantin"></span>Секунд</li>
					  </ul>
					</div>
                    <center><h1>До нового года осталось:</h1>
					  <ul>
					    <li><span id="days-new-year"></span>Дней</li>
					    <li><span id="hours-new-year"></span>Часов</li>
					    <li><span id="minutes-new-year"></span>Минут</li>
					    <li><span id="seconds-new-year"></span>Секунд</li>
					  </ul>
					</div>
                    <br>
                    <center><h1>До начала осени осталось:</h1>
					  <ul>
					    <li><span id="days-spring"></span>Дней</li>
					    <li><span id="hours-spring"></span>Часов</li>
					    <li><span id="minutes-spring"></span>Минут</li>
					    <li><span id="seconds-spring"></span>Секунд</li>
					  </ul>
					</div>
                    <br>
                    <center><h1>До начала зимы осталось:</h1>
					  <ul>
					    <li><span id="days-winter"></span>Дней</li>
					    <li><span id="hours-winter"></span>Часов</li>
					    <li><span id="minutes-winter"></span>Минут</li>
					    <li><span id="seconds-winte"></span>Секунд</li>
					  </ul>
					</div></center>
                    <footer><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></footer>
</body>
</html>