$(function() {
    $('.prompt').html('[user@Catbin] # ');


  var term = new Terminal('#input-line .cmdline', '#container output');
  term.init();
  

  setInterval(function() {
    function r(cls, deg) {
      $('.' + cls).attr('transform', 'rotate('+ deg +' 50 50)')
    }
    var d = new Date()
    r("sec", 6*d.getSeconds())  
    r("min", 6*d.getMinutes())
    r("hour", 30*(d.getHours()%12) + d.getMinutes()/2)
  }, 1000);
  
});