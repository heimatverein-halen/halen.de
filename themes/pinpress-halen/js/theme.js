// Phone menu toggle, navigation dropdowns and sticky header (replaces the old Bootstrap 2 / Blogger scripts).
document.addEventListener('DOMContentLoaded', function () {
  var nav = document.querySelector('.nav-collapse');
  var toggle = document.querySelector('.btn-navbar');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.style.height = nav.classList.toggle('in') ? 'auto' : '';
    });
  }

  document.addEventListener('click', function (event) {
    var link = event.target.closest('[data-toggle="dropdown"]');
    document.querySelectorAll('li.dropdown.open').forEach(function (item) {
      if (!link || item !== link.parentNode) {
        item.classList.remove('open');
      }
    });
    if (link) {
      event.preventDefault();
      link.parentNode.classList.toggle('open');
    }
  });

  var header = document.getElementById('masthead');
  if (header) {
    var update = function () {
      var scrolled = window.scrollY > 0;
      header.classList.toggle('affix', scrolled);
      header.classList.toggle('affix-top', !scrolled);
    };
    window.addEventListener('scroll', update, { passive: true });
    update();
  }
});
