const second = 1000,
minute = second * 60,
hour = minute * 60,
day = hour * 24;

let countDown = new Date('Sep 01, 2020 00:00:00').getTime(),
x = setInterval(function() {    

let now = new Date().getTime(),
distance = countDown - now;

document.getElementById('days-fall').innerText = Math.floor(distance / (day)),
document.getElementById('hours-fall').innerText = Math.floor((distance % (day)) / (hour)),
document.getElementById('minutes-fall').innerText = Math.floor((distance % (hour)) / (minute)),
document.getElementById('seconds-fall').innerText = Math.floor((distance % (minute)) / second);

}, second)