<?php

include_once('core.php');

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Miami Science Barge Child Theme' );
define( 'CHILD_THEME_URL', 'http://github.com/PradatiusD/scienceBarge' );
define( 'CHILD_THEME_VERSION', '1.0.0' );


function header_scripts () {
  wp_enqueue_style('fonts.com'   , '//fast.fonts.net/cssapi/59c6b193-28c7-421e-b0e2-2ef3f974c071.css',      array(), CHILD_THEME_VERSION);
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0');
}
add_action('wp_enqueue_scripts','header_scripts');

// move Secondary Sidebar to .content-sidebar-wrap
remove_action('genesis_after_content_sidebar_wrap','genesis_get_sidebar_alt');
add_action('genesis_after_content',                'genesis_get_sidebar_alt');


wp_register_script('angular','//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js', array(), '1.3.14', true);
wp_register_script('angular-sanitize','//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular-sanitize.min.js',array('angular'),'1.3.15', true);


/*
 * Add featured images conditionally
 * ------------------------
 * Goes through loop and adds a featured image if there is one.
 * If there is afeatured image, the layout is split into a 4-8
 * layout.
 */

function add_featured_image () {

  $has_featured_image = strlen(get_the_post_thumbnail()) > 0;

  if ($has_featured_image) {
    the_post_thumbnail();
  }

  genesis_do_post_content();

}


remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action('genesis_entry_content',     'add_featured_image');


// Add social feed php script
include_once('social-feed.php');

// Add the functions needed for showing sponsors on homepaeg
include_once('partners.php');

// Add all functions used for press coverage archive
// and homepage
include_once('press-coverage.php');

// Archives
include_once('custom-archives.php');