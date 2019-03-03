
      (function($){
        $(function(){
          // scroll is still position
          var scroll = $(document).scrollTop();
          var headerHeight = $('.page-header').outerHeight();
          //console.log(headerHeight);

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
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        } else {  // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                document.getElementById("rssOutput").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","getrss.php?q="+str,true);
        xmlhttp.send();
        window.scrollTo(0, 0);
        document.title = document.getElementById('rssList').options[document.getElementById('rssList').selectedIndex].text;;
      }


