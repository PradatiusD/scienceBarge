<?php


function do_custom_front_page () {
	ob_start(); ?>

	<?php // include('google-map.php'); ?>

	<h1>Under Construction</h1>
	<?php
	echo ob_get_clean();
}

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop',    'do_custom_front_page');

genesis();


?>

