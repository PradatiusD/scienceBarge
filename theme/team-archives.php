<?php

/*
 * Team Archive
 * ------------------- 
 */
class Team_Archive {

  public  $slug;
  private $posts;
  
  function __construct( $post_type, $wp_query) {
    $this->slug     = $post_type;
    $this->posts    = $wp_query->posts;
  }

  function face_grid_wrap ($isOpenTag)  {
    if ($isOpenTag) {
      echo "<h1 class='face-grid-title'>".post_type_archive_title('Our ',false)."</h1>";
      echo '<header class="face-grid row">';
    } else {
      echo '</header>';
    }
  }

  function face_grid () {

    $this->face_grid_wrap(true);

    foreach ($this->posts as $post) {

      $ID              = $post->ID;
      $title           = preg_replace('/\s+/', '</span> <span>', $post->post_title);
      $placeholder_img = '<img src="http://placehold.it/300x300&text=Coming+Soon"/>';

      if (has_post_thumbnail($ID)) {
        $img = get_the_post_thumbnail($ID, 'medium', $this->get_image_class($ID));
      } else {
        $img = $placeholder_img;
      }

      ?>
      <article class="col-xs-3 text-center">
        <div class="post-<?php echo $ID; ?>-photo">
          <a href="#">
            <p class="h3">
                <span>
                  <?php echo $title;?>
                </span>
            </p>
          </a>
          <?php echo $img;?>          
        </div>
      </article>
      <?php

    } // End foreach
    $this->face_grid_wrap(false);
  }

  function get_image_class ($ID) {
    
    $class  = get_the_title($ID);
    $class  = strtolower($class);
    $class  = str_replace(" ", "-", $class);

    $image_args = array('class'=> $class);
    return $image_args;
  }
}

$team_post_types = array('lead-team','advisors');

function circle_headers () {

  global $wp_query;
  global $team_post_types;

  $post_type  = get_post_type();
  $is_archive = is_post_type_archive($team_post_types);

  if ($post_type && $is_archive) {
    $archive = new Team_Archive($post_type, $wp_query);
    wp_enqueue_script('team-scroll-To', get_stylesheet_directory_uri() . '/js/team-scroll-to.js', array(), '1.0.0',true);
    return $archive->face_grid();
  }
}

add_action('genesis_before_loop', 'circle_headers');



function add_org_name_and_title(){
  global $team_post_types;

  $is_archive = is_post_type_archive($team_post_types);

  if ($is_archive){
    $org_name  = types_render_field('organization-name');
    $org_title = types_render_field('organizational-title');
    $has_role  = strlen($org_name) > 0 && strlen($org_title) > 0;

    if (!$has_role) {
      return;
    }

    ob_start();?>

      <h5 class="text-muted">
        <?php echo types_render_field('organization-name') . " – " . types_render_field('organizational-title');?>
      </h5>

    <?php
    echo ob_get_clean();
  }

}

add_action('genesis_entry_header','add_org_name_and_title');

?>