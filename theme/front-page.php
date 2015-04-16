<?php



add_action('genesis_after_header', 'homepage_render');


remove_action('genesis_loop',      'genesis_do_loop');

add_action('genesis_loop',         'hype_animation');
add_action('genesis_loop',         'homepage_quote');
add_action('genesis_loop',         'homepage_lead_team');
add_action('genesis_loop',         'isotope_gallery');
add_action('genesis_loop',         'homepage_gravity_form');
genesis();


?>

