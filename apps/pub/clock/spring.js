const second = 1000,
minute = second * 60,
hour = minute * 60,
day = hour * 24;

let countDown = new Date('Mar 01, 2021 00:00:00').getTime(),
x = setInterval(function() {    

let now = new Date().getTime(),
distance = countDown - now;

document.getElementById('days-spring').innerText = Math.floor(distance / (day)),
document.getElementById('hours-spring').innerText = Math.floor((distance % (day)) / (hour)),
document.getElementById('minutes-spring').innerText = Math.floor((distance % (hour)) / (minute)),
document.getElementById('seconds-spring').innerText = Math.floor((distance % (minute)) / second);

}, second)