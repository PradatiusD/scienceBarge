<?php



add_action('genesis_after_header', 'homepage_render');


remove_action('genesis_loop',      'genesis_do_loop');

add_action('genesis_loop',         'hype_animation');
add_action('genesis_loop',         'homepage_quote');
add_action('genesis_loop',         'homepage_lead_team');
add_action('genesis_loop',         'homepage_advisors');
add_action('genesis_loop',         'isotope_gallery');
add_action('genesis_loop',         'homepage_gravity_form');
add_action('genesis_loop',         'barge_partners');

wp_enqueue_script('waypoints',          get_stylesheet_directory_uri() . '/js/jquery.waypoints.min.js', array('jquery'), '3.1.1', true);
wp_enqueue_script('homepage-waypoints', get_stylesheet_directory_uri() . '/js/homepage-waypoints.js', array('waypoints'),'1.0.0', true);

genesis();


?>

