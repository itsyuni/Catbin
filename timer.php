<!DOCTYPE HTML>
<html>
     <head>
       <title>Уже скоро</title>
       <meta charset="UTF-8">
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

							body {
							  background-color: black;
							  display: -webkit-box;
							  display: -ms-flexbox;
							  display: flex;
							}

							.containerttt {
							  color: #333;
							  margin: 0 auto;
							  padding: 0.5rem;
							  text-align: center;
							}
							  
       </style>
     </head>
     
<body>
       <br>
       <br>
       <script>
              const second = 1000,
						minute = second * 60,
						hour = minute * 60,
						day = hour * 24;

						let countDown = new Date('Aug 04, 2020 00:00:00').getTime(),
						x = setInterval(function() {    

						let now = new Date().getTime(),
						distance = countDown - now;

						document.getElementById('days').innerText = Math.floor(distance / (day)),
						document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
						document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
						document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

                        }, second)
                        </script>
					  <div class="containerttt">
                      <br><br><br><br><br><br><ul>
					    <center><li><span style="-moz-text-shadow:0 0 10px #fff; -webkit-text-shadow:0 0 10px #fff; text-shadow:0 0 10px #fff;" id="days"></span>Дней</li>
					    <li><span style="-moz-text-shadow:0 0 10px #fff; -webkit-text-shadow:0 0 10px #fff; text-shadow:0 0 10px #fff;" id="hours"></span>Часов</li>
					    <li><span style="-moz-text-shadow:0 0 10px #fff; -webkit-text-shadow:0 0 10px #fff; text-shadow:0 0 10px #fff;" id="minutes"></span>Минут</li>
					    <li><span style="-moz-text-shadow:0 0 10px #fff; -webkit-text-shadow:0 0 10px #fff; text-shadow:0 0 10px #fff;" id="seconds"></span>Секунд</li></center>
                        <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
					  </ul>
                      </div>
</body>
</html>