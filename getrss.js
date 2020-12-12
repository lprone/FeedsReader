(function($){
  $(function(){
    var scroll = $(document).scrollTop();
    var headerHeight = $('.page-header').outerHeight();

    $(window).scroll(function() {
      // scrolled is new position just obtained
      var scrolled = $(document).scrollTop();

      // optionally emulate non-fixed positioning behaviour

      if (scrolled > headerHeight){
        $('.page-header').addClass('off-canvas');
      } else {
        $('.page-header').removeClass('off-canvas');
      }
      if (scrolled > scroll){
        // scrolling down
        $('.page-header').removeClass('fixed');
      } else {
        //scrolling up
        $('.page-header').addClass('fixed');
      }
      scroll = $(document).scrollTop();
    });
  });
})(jQuery);

function showRSS(str) {
  if (str.length==0) {
    document.getElementById("rssOutput").innerHTML="";
    return;
  }
  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("rssOutput").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getrss.php?q="+str,true);
  xmlhttp.send();
  window.scrollTo(0, 0);
  document.title = document.getElementById('rssList').options[document.getElementById('rssList').selectedIndex].text;
}