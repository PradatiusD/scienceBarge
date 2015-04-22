(function($){


	$('.twitter').sharrre({
	  share: {
	    twitter: true
	  },
	  enableHover: false,
	  buttons: { twitter: {via: 'miascibarge'}},
	  click: function(api, options){
	    api.simulateClick();
	    api.openPopup('twitter');
	  }
	});
	$('.facebook').sharrre({
	  share: {
	    facebook: true
	  },
	  enableHover: false,
	  click: function(api, options){
	    api.simulateClick();
	    api.openPopup('facebook');
	  }
	});

})(jQuery);