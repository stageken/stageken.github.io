$(function() {
  $('.nav-icon').on('click', function () {
   $(this).toggleClass('open');
   $('.global-nav').toggleClass('open');
   $('.nav-content').toggleClass('open');
  });
 });