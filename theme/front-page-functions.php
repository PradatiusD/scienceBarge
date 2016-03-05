<?php

/*
 * Homepage Render
 * -----------------
 * Render of the science barge.  Eventually should be another Hype animation.
 * 
 */

function homepage_render () {

  $img_src = get_stylesheet_directory_uri() . "/images/miami-science-barge-3D-render.png";
  $img_style = 'margin-top: -1em; margin-bottom: -1.2em; width: 100%;';

  ob_start();?>
  
  <img class="img-responsive" src="<?php echo $img_src;?>" alt="" style="<?php echo $img_style; ?>">
  
  <?php
  echo ob_get_clean();
}


/*
 * Hype animation
 * -----------------
 * Electron spinning around the logo.
 * 
 */

function hype_animation () {
  echo "<section id='hype_animation'>";
    include('hype.php');
  echo "</section>";
  wp_enqueue_script('hype', get_stylesheet_directory_uri() . '/hype.hyperesources/hype_hype_generated_script.js', array(), '1.0.0',true);
}



function class_slug ($id) {
  
  $class  = get_the_title($id);
  $class  = strtolower($class);
  $class = str_replace(" ", "-", $class);

  return $class;
}

function member_layout ($unit_class, $col_width) {

  $title = get_the_title();

  $title = preg_replace('/\s+/', '</span> <span>', $title);
  ?>
  <article class="col-xs-<?php echo $col_width?> text-center">
    <div class="<?php echo $unit_class;?>">
      <a href="<?php the_permalink(); ?>">
        <p><span><?php echo $title;?></span></p>
      </a>
      <?php 
      $args = array(
        'class'=> class_slug(get_the_ID())
      );

      if (has_post_thumbnail()) {
        the_post_thumbnail('medium', $args);      
      } else {
        echo "<img src='http://placehold.it/300x300&text=Coming+Soon'";
      }
      ?>
    </div>
  </article>
  <?php
}

function face_grid($post_type, $message, $col_width, $id) {

  $query = new WP_Query(array(
    'post_type' => $post_type
  ));
  
  ob_start(); ?>

    <div id="<?php echo $id;?>">

      <p class="h1 text-center"><?php echo $message;?></p>
      <section class="row">
        <?php

        if ($query->have_posts()) {
          while ($query->have_posts()) {
            $query->the_post();
            member_layout($post_type, $col_width);
          }
        } else {
          // no posts found
        }?>
      </section>

    </div>
    <br>
  <?php
  wp_reset_postdata(); // Restore original Post Data
  echo ob_get_clean();
}

function homepage_lead_team () {
  face_grid('lead-team','The Lead Team', 4, 'lead-team');
}

function homepage_advisors () {
  face_grid('advisors','Our Awesome Advisors', '5-special', 'advisors');
}

function homepage_gravity_form() {
  echo do_shortcode('[gravityform id="1" title="true" description="true"]');
}

function latest_news () {

  $args = array(
      'post_type' => 'press',
      'posts_per_page'=> 5
  );

  $query = new WP_Query($args);

  ob_start(); 

  ?>

      <section id="latest-news">
        <p class="h1 text-center">Latest News</p>
        <?php

        if ($query->have_posts()) {
          while ($query->have_posts()) {
            $query->the_post();

            $news_source_url = types_render_field('news-source-url', array('output'=>'raw'));

            ?>
            <div class="row">
              <figure class="col-sm-2 text-center">
                <?php echo the_post_thumbnail('thumbnail', array(''));?>
              </figure>
              <article class="col-sm-10">
                <h3>
                  <a class="text-green" href="<?php echo $news_source_url;?>" target="_blank">
                    <?php echo get_the_title(); ?>
                  </a>
                  <br>
                  <small class="text-muted" >
                    <?php 
                      $human_time_diff = human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago';
                      $author_name     = types_render_field('author-name');
                      
                      echo $human_time_diff . " by " .  $author_name;
                    ?>
                  </small>
                </h3>                
              </article>
              <hr>
            </div>
            <?php
          }
        } else {
          echo "no posts found";
        }?>
      </section>

  <?php
  wp_reset_postdata();
  echo ob_get_clean();
}