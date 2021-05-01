<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
            if (DB::query('SELECT username FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))) {
                    $username = DB::query('SELECT username FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))[0]['username'];
  
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
        <link rel="stylesheet" href="style.css">
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
       <!DOCTYPE html>
<html lang="en">
  </head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Calculator</title>
 <div class="calc">
   <form class="form" name="form">
    <input class="output">
   </form>  
    <table>
      <tr>
        <td colspan="3"><input class="button ac btnColor" type="button" value="AC" onclick="clean()"></td>
        <td><input class="button btnColor" type="button" value="/" onclick="insert('/')"></td>
      </tr>
      <tr>
        <td><input class="button" type="button" value="7" onclick="insert(7)"></td>
        <td><input class="button" type="button" value="8" onclick="insert(8)"></td>
        <td><input class="button" type="button" value="9" onclick="insert(9)"></td>
        <td><input class="button btnColor" type="button" value="*" onclick="insert('*')"></td>
      </tr>
      <tr>
        <td><input class="button" type="button" value="4" onclick="insert(4)"></td>
        <td><input class="button" type="button" value="5" onclick="insert(5)"></td>
        <td><input class="button" type="button" value="6" onclick="insert(6)"></td>
        <td><input class="button btnColor" type="button" value="-" onclick="insert('-')"></td>
      </tr>
      <tr>
        <td><input class="button" type="button" value="1" onclick="insert(1)"></td>
        <td><input class="button" type="button" value="2" onclick="insert(2)"></td>
        <td><input class="button" type="button" value="3" onclick="insert(3)"></td>
        <td><input class="button btnColor" type="button" value="+" onclick="insert('+')"></td>
      </tr>
      <tr>
        <td><input class="button" type="button" value="0" onclick="insert(0)"></td>
        <td><input class="button" type="button" value="." onclick="insert('.')"></td>
        <td colspan="2"><input class="button equal" type="button" value="=" onclick="equal()"></td>
      </tr>
    </table>
 </div>
<script src="main.js"></script>
</body>
</html>