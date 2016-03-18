(function ($) {
  var $faces = $('.archive-img-grid').find('article');

  function navigateTo (offset) {

    $('html, body').animate({
      scrollTop: offset
    }, 1000);
    return false;
  }

  $faces.find('a').click(function (e) {

    e.preventDefault();

    var $a = $(this);

    var parentClass = $a.parent().attr('class');
    var targetClass = "."+parentClass.replace('-photo','');
    var target = $(targetClass);

    if (target.length) {
      navigateTo(target.offset().top);
    }
  });

  $('.back-to-top').click(function (e) {
    e.preventDefault();
    navigateTo(0);
  })

})(jQuery);