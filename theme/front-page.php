<?php

/*
 * front-page.php
 * -------------------
 * Document is just an index of the function hooks present
 * at front-page-functions.php.
 */

add_action('genesis_after_header', 'homepage_render');

remove_action('genesis_loop',      'genesis_do_loop');
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
genesis();


?>

