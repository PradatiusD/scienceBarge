<?php

function instafeed() {
	wp_enqueue_script('instafeed', get_stylesheet_directory_uri(). '/js/instafeed.min.js', array(),'1.3.2', true);
	wp_enqueue_script('instafeed_consumer', get_stylesheet_directory_uri(). '/js/instaconsumer.js', array('instafeed'), '1.0.0',true);
	echo '<div id="instafeed"></div>';	
}


function do_custom_front_page () {


	ob_start(); ?>

	<?php 
		// include('google-map.php');
		// instafeed();
		echo do_shortcode('[gravityform id="1" title="true" description="true"]');
	?>
	<?php
	echo ob_get_clean();
}

add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop',    'do_custom_front_page');

genesis();


?>

