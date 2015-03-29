
// Documentation at http://instafeedjs.com/

var userFeed = new Instafeed({
  get: 'user',
  userId: 1774511928,
  accessToken: '1774511928.2c90c39.680a9751b646476e82df1b5719e02261',
  resolution: 'standard_resolution',
  template: '<article>'+
              '<figure">'+
                '<a href="{{link}}" target="_blank">' +
                  '<img src="{{image}}" class="img-responsive"/>'+
                '</a>'+
                '<figcaption class="small">'+
                '{{caption}}'+
                '</figcaption>'+
              '</figure>'+
              '<hr>'+
            '</article>'
});

userFeed.run();