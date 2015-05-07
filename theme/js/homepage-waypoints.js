
(function($){

	function fadeWaypoint(selector){

		var $selector = $(selector);

		$selector.waypoint({
		  handler: function(direction) {

		  	if (direction == 'down') {
			    $selector.addClass('fadeInUp animated');	  		
		  	}
		  },
		  offset: '66%'
		});
	}

	var selectors = [
		'homepage_quote',
		'hype_animation',
		'lead-team',
		'advisors',
		'isotope_gallery',
		'gform_wrapper_1',
		'partners',
		'latest-news'
	];

	for (var i = 0; i < selectors.length; i++) {
		fadeWaypoint('#' + selectors[i]);
	}

})(jQuery);