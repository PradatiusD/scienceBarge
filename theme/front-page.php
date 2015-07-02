<?php

/*
 * front-page.php
 * -------------------
 * Document is just an index of the function hooks present
 * at front-page-functions.php.
 */

add_action('genesis_after_header', 'homepage_render');

remove_action('genesis_loop',      'genesis_do_loop');

add_action('genesis_loop',         'hype_animation');
add_action('genesis_loop',         'homepage_quote');
add_action('genesis_loop',         'homepage_lead_team');
add_action('genesis_loop',         'homepage_advisors');
add_action('genesis_loop',         'isotope_gallery');
add_action('genesis_loop',         'homepage_gravity_form');
add_action('genesis_loop',         'barge_partners');
add_action('genesis_loop',         'latest_news');

genesis();


?>

