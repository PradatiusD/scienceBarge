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

//* Remove Post Meta (Filed under: )
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


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


function header_scripts () {
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '4.3.0');
}

add_action('wp_enqueue_scripts','header_scripts');

// move Secondary Sidebar to .content-sidebar-wrap
remove_action('genesis_after_content_sidebar_wrap','genesis_get_sidebar_alt');
add_action('genesis_after_content','genesis_get_sidebar_alt' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );


wp_register_script('angular','//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js', array(), '1.3.14', true);
wp_register_script('angular-sanitize','//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular-sanitize.min.js',array('angular'),'1.3.15', true);


// Add social feed php script
include 'social-feed.php';


function navigation_social_links( $menu, $args ) {
  if ( 'primary' == $args->theme_location) {
    ob_start();?>
      <li><a href="https://www.facebook.com/miamisciencebarge" target="_blank"><i class="fa fa-facebook"></i></a></li>
      <li><a href="https://twitter.com/miascibarge" target="_blank"><i class="fa fa-twitter"></i></a></li>
      <li><a href="https://instagram.com/miascibarge/" target="_blank"><i class="fa fa-instagram"></i></a></li>
    <?php
    $menu .= ob_get_clean();
  }
  return $menu;
}

add_filter( 'wp_nav_menu_items', 'navigation_social_links', 10, 2 );

/*
 * Add featured images conditionally
 * ------------------------
 * Goes through loop and adds a featured image if there is one.
 * If there is afeatured image, the layout is split into a 4-8
 * layout.
 */

function add_featured_image () {

  $has_featured_image = strlen(get_the_post_thumbnail()) > 0;

  ob_start();?>
  
  <?php if ($has_featured_image): ?>
    <div class="row">
      <aside class="col-md-4">
        <?php the_post_thumbnail(); ?>
      </aside>
      <section class="col-md-8">
  <?php endif; ?>
      
        <?php genesis_do_post_content();?>

  <?php if ($has_featured_image): ?>
      <section>
    </div>
  <?php endif; ?>
  <hr>
  <?php
  echo ob_get_clean();
}


remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action('genesis_entry_content','add_featured_image');

function add_org_name_and_title(){

  $post_types = array('team-member','advisor');
  
  if (is_post_type_archive($post_types)){
    ob_start();?>

      <h5 class="text-muted">
        <?php echo types_render_field('organization-name') . " – " . types_render_field('organizational-title');?>
      </h5>

    <?php
    echo ob_get_clean();
  }

}

add_action('genesis_entry_header','add_org_name_and_title');

// Add all functions used for homepage
include_once('front-page-functions.php');