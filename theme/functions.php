<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Miami Science Barge Child Theme' );
define( 'CHILD_THEME_URL', 'http://github.com/PradatiusD/scienceBarge' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Arvo|PT+Sans:400,700,400italic', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
  // For Debugging on Localhost
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  // For live reloading
  function local_livereload(){
    wp_register_script('livereload', 'http://localhost:35729/livereload.js', null, false, true);
    wp_enqueue_script('livereload');    
  }
  add_action( 'wp_enqueue_scripts', 'local_livereload');
}


// move Secondary Sidebar to .content-sidebar-wrap
remove_action('genesis_after_content_sidebar_wrap','genesis_get_sidebar_alt');
add_action('genesis_after_content','genesis_get_sidebar_alt' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );


wp_register_script('angular','//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js', array(), '1.3.14', true);
wp_register_script('angular-sanitize','//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular-sanitize.min.js',array('angular'),'1.3.15', true);


function instafeed() {
  wp_enqueue_script('instafeed', get_stylesheet_directory_uri(). '/js/instafeed.min.js', array(),'1.3.2', true);
  wp_enqueue_script('instafeed_consumer', get_stylesheet_directory_uri(). '/js/instaconsumer.js', array('instafeed', 'angular','angular-sanitize'), '1.0.0',true);
  include 'instagram-template.html';
}

add_action('genesis_after_sidebar_widget_area','instafeed');

// Add twitter php script
include 'twitter.php';
