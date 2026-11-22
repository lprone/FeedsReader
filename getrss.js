(function () {
  'use strict';

  // Sticky header that hides on scroll down, shows on scroll up.
  (function initHeader() {
    var header = document.querySelector('.page-header');
    if (!header) return;
    var headerHeight = header.offsetHeight;
    var lastScroll = 0;

    window.addEventListener('scroll', function () {
      var scrolled = window.pageYOffset || document.documentElement.scrollTop;
      if (scrolled > headerHeight) {
        header.classList.add('off-canvas');
      } else {
        header.classList.remove('off-canvas');
      }
      if (scrolled > lastScroll) {
        header.classList.remove('fixed');
      } else {
        header.classList.add('fixed');
      }
      lastScroll = scrolled;
    }, { passive: true });
  })();

  // Load a feed via AJAX and render it in #rssOutput.
  window.showRSS = function showRSS(str) {
    var output = document.getElementById('rssOutput');
    var select = document.getElementById('rssList');
    var titleEl = document.title;

    if (!str) {
      output.innerHTML = '';
      document.title = 'Lprone Feeds Reader';
      return;
    }

    output.innerHTML =
      '<p class="loading"><span class="spinner"></span> Loading feed…</p>';
    document.title = 'Loading…';

    fetch('getrss.php?q=' + encodeURIComponent(str), { cache: 'no-store' })
      .then(function (res) {
        if (!res.ok) throw new Error('Feed request failed');
        return res.text();
      })
      .then(function (html) {
        output.innerHTML = html;
        document.title = select.options[select.selectedIndex].text;
        window.scrollTo(0, 0);
      })
      .catch(function () {
        output.innerHTML =
          '<p class="error">Unable to load this feed. Try again later.</p>';
        document.title = titleEl;
      });
  };
})();
