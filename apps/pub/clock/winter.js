const second = 1000,
minute = second * 60,
hour = minute * 60,
day = hour * 24;

let countDown = new Date('Dec 01, 2020 00:00:00').getTime(),
x = setInterval(function() {    

let now = new Date().getTime(),
distance = countDown - now;

document.getElementById('days-winter').innerText = Math.floor(distance / (day)),
document.getElementById('hours-winter').innerText = Math.floor((distance % (day)) / (hour)),
document.getElementById('minutes-winter').innerText = Math.floor((distance % (hour)) / (minute)),
document.getElementById('seconds-winter').innerText = Math.floor((distance % (minute)) / second);

}, second)