<?php


function do_custom_front_page () {
	ob_start(); ?>

	<style>
	#map-canvas {
	  height: 400px;
	  margin: 0px;
	  padding: 0px
	}
	</style>

	<p class="lead">Located off of Museum Park</p>
	<div id="map-canvas"></div>

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&ver=3.0"></script>
	<script>

	  // This example adds a red rectangle to a map.

    var scienceBarge = {
    	lat: 25.785184,
    	lng: -80.185525,
    	factor: 0.00025
    }
	  
	  function initialize() {
	    var map = new google.maps.Map(document.getElementById('map-canvas'), {
	      zoom: 20,
	      center: new google.maps.LatLng(scienceBarge.lat, scienceBarge.lng),
	      mapTypeId: google.maps.MapTypeId.TERRAIN
	    });

	    var rectangle = new google.maps.Rectangle({
	      strokeColor: '#FF0000',
	      strokeOpacity: 1,
	      strokeWeight: 1,
	      fillColor: '#FF0000',
	      fillOpacity: 1,
	      map: map,
	      bounds: new google.maps.LatLngBounds(
	        new google.maps.LatLng(scienceBarge.lat + scienceBarge.factor, scienceBarge.lng - scienceBarge.factor/2),
	        new google.maps.LatLng(scienceBarge.lat - scienceBarge.factor, scienceBarge.lng + scienceBarge.factor/2)
	       )
	    });
	  }

	  google.maps.event.addDomListener(window, 'load', initialize);
	</script>

	<?php
	echo ob_get_clean();
}

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop',    'do_custom_front_page');

genesis();


?>

