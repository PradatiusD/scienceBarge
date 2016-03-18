<?php

/*
 * Homepage Render
 * -----------------
 * Render of the science barge.  Eventually should be another Hype animation.
 */

function homepage_render () {
  global $wp_query;

  $ID = $wp_query->post->ID;
  $image_attr = array("class"=>'barge-render');

  $image = get_the_post_thumbnail($ID, 'full', $image_attr);

  if (!$image) {
    $default_image_src = get_stylesheet_directory_uri()."/images/miami-science-barge-3D-render.png";
    $image_class = 'img-responsive '.$image_attr["class"];

    echo '<img class="'.$image_class.'" src="'.$default_image_src.'">';

  }
}


/*
 * Hype animation
 * -----------------
 * Electron spinning around the logo.
 */

function hype_animation () {
  echo "<section id='hype_animation'>";
    include('hype.php');
  echo "</section>";
  wp_enqueue_script('hype', get_stylesheet_directory_uri() . '/hype.hyperesources/hype_hype_generated_script.js', array(), '1.0.0',true);
}


/*
 * Index of Functions
 * ---------------------
 */

add_action('genesis_after_header', 'homepage_render');
remove_action('genesis_loop', 'genesis_do_loop');

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
genesis();


?>

