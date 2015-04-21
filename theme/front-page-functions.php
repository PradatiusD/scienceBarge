<?php

function homepage_render () {

  $img_src = get_stylesheet_directory_uri() . "/images/miami-science-barge-3D-render.png";
  $img_style = 'margin-top: -1em; margin-bottom: 1em;width: 100%;';

  ob_start();?>
  
  <img class="img-responsive" src="<?php echo $img_src;?>" alt="" style="<?php echo $img_style; ?>">
  
  <?php
  echo ob_get_clean();
}

function hype_animation () {
  ob_start();?>

  <iframe src="<?php echo get_stylesheet_directory_uri()."/hype.html";?>" frameborder="0" style="width:100%; height: 425px; overflow:hidden;"></iframe>

  <?php
  echo ob_get_clean();

}


function homepage_quote () {
  ob_start(); ?>
  
<div class="row">
  <aside class="col-md-2">
    <img src="<?php echo get_stylesheet_directory_uri()."/images/sachs.jpg";?>" class="img-circle">
  </aside>
  <article class="col-md-10" style="  margin-top: 0;padding-top: 0;">
    <blockquote>
    <p class="h1">“The Science Barge is not only an invitation to ideas and learning, but to change.”</p>
    <footer>
      <h4>Dr. Jeffrey Sachs</h4>
      Director of the Earth Institute at Columbia University<br>
      Special Economic Advisor to the United Nations
    </footer>
  </blockquote>
  </article>  
</div>

  <?php
  echo ob_get_clean();
}



function isotope_gallery() {

  wp_enqueue_script('masonry-gallery', get_stylesheet_directory_uri(). '/js/masonry-gallery.js', array('masonry'),'1.0.0', true);

  function get_bg_style($img_name) {
    $style = "background-image:url(" . get_stylesheet_directory_uri(). "/images/" . $img_name. ".jpg)";
    echo 'style="'.$style.'"';
  }

  ob_start();

  $masonry_images = array(
    array('image' => 'team-gray'         ,'class' => 'item'),
    array('image' => 'plants-growing'    ,'class' => 'item'),
    array('image' => 'growing-flora'     ,'class' => 'item item-2x'),
    array('image' => 'solar-panels'      ,'class' => 'item'),
    array('image' => 'old-science-barge' ,'class' => 'item'),
    array('image' => 'person-mending'    ,'class' => 'item item-2x'),
    array('image' => 'swimming-mahi'     ,'class' => 'item'),
    array('image' => 'haggman-bermingham','class' => 'item'),
    array('image' => 'interested-crowd'  ,'class' => 'item'),
    array('image' => 'ny-sci-barge'      ,'class' => 'item')
  );

  ?>
    <p class="h1">What we plan to build</p>
    <div id="masonry-container">
      <?php
        for ($i=0; $i < count($masonry_images); $i++) { 
          ?>
            <article class="<?php echo $masonry_images[$i]['class']; ?>">
              <div class="barge-img" <?php get_bg_style($masonry_images[$i]['image']);?>></div>
            </article>
          <?php
        }?>
    </div>
  <?php
  echo ob_get_clean();
}

function class_slug ($id) {
  
  $class  = get_the_title($id);
  $class  = strtolower($class);
  $class = str_replace(" ", "-", $class);

  return $class;
}

function member_layout ($unit_class, $col_width) {
  ?>
  <article class="col-md-<?php echo $col_width?> text-center">
    <div class="<?php echo $unit_class;?>">
      <a href="<?php the_permalink(); ?>">
        <p><?php the_title();?></p>
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

function face_grid($post_type, $message, $col_width) {

  $query = new WP_Query(array(
    'post_type' => $post_type
  ));
  
  ob_start(); ?>

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
    <br>
  <?php
  wp_reset_postdata(); // Restore original Post Data
  echo ob_get_clean();
}

function homepage_lead_team () {
  face_grid('lead-team','The Lead Team', 4);
}

function homepage_advisors () {
  face_grid('advisor','Our Awesome Advisors', '5-special');
}

function homepage_gravity_form() {
  echo do_shortcode('[gravityform id="1" title="true" description="true"]');
}