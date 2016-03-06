(function ($) {
  var $faces = $('.face-grid').find('article');

  $faces.find('a').click(function (e) {

    e.preventDefault();

    var $a = $(this);

    var parentClass = $a.parent().attr('class');
    var targetClass = "."+parentClass.replace('-photo','');
    var target = $(targetClass);

    if (target.length) {
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 1000);
      return false;
    }
  });

})(jQuery);