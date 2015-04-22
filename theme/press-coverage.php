<?php

function press_coverage_share() {

  $share_url = types_render_field('news-source-url', array('output'=>'raw'));
  $title = get_the_title();

  $data_attr = 'data-url="'.$share_url.'"  data-text="'.$title.'"';

  ob_start();
  ?>
  <aside class="sharrre-container">
    <div class="twitter" <?php echo $data_attr;?> data-title="<i class='fa fa-twitter'></i> Tweets"></div>
    <div class="facebook"<?php echo $data_attr;?> data-title="<i class='fa fa-facebook'></i> Likes"></div>    
  </aside>
  <?php
  echo ob_get_clean();
}

function press_coverage_scripts () {
  wp_enqueue_script('sharrre', get_stylesheet_directory_uri().'/js/jquery.sharrre.min.js', array('jquery'), '1.3.5', true);
  wp_enqueue_script('sharrre-client', get_stylesheet_directory_uri().'/js/sharrre-client.js', array('sharrre'), '1.0.0', true);
}


function press_coverage_archive_body_content () {

  $author_name = types_render_field('author-name');
  ob_start();
  ?>

  <blockquote>
    <?php the_excerpt();?>
    <footer class="text-right">
      <cite class="h5">
        By <?php echo $author_name; ?>
      </cite>
    </footer>
  </blockquote>

  <?php
  echo ob_get_clean();
}





function press_coverage_title () {
  global $post;

  // First add the link

  $params = array(
    "title" => get_the_title(),
    "target" => "_blank"
  );

  $title = types_render_field("news-source-url", $params);

  echo '<h1 class="entry-title">'. $title. '</h1>';

  // Now bring in the title of the organization that wrote it
  
  $post_id = $post->ID;
  $post_terms = wp_get_post_terms( $post_id, 'news-source');

  if (!empty($post_terms)) {
    $news_source_name = $post_terms[0]->name;
    // $news_source_taxonomy_url = get_term_link($post_terms[0]);

    $params = array(
      "title" => $news_source_name,
      "target" => "_blank"    
    );

    $url = types_render_field("news-source-url", $params);

    echo '<span class="text-muted h4">From the '.$url.'</span>';
  }
}

function press_coverage_functions () {
  if (is_post_type_archive('press')) {

    // Remove post meta data
    remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

    // Add special share icons
    add_action('genesis_entry_header', 'press_coverage_share', 12);
    add_action('wp_enqueue_scripts','press_coverage_scripts');

    // Change title to correct title
    remove_action('genesis_entry_header', 'genesis_do_post_title');
    add_action('genesis_entry_header','press_coverage_title');

    // Organize body
    add_action('genesis_entry_content', 'press_coverage_archive_body_content');
  }
}


add_action('pre_get_posts','press_coverage_functions');