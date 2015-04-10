<?php


function isotope_gallery() {
  wp_enqueue_script('masonry-gallery', get_stylesheet_directory_uri(). '/js/masonry-gallery.js', array('masonry'),'1.0.0', true);

  function get_bg_style($img_name) {
    echo 'style="background-image:url('  . get_stylesheet_directory_uri(). '/images/' . $img_name. '.jpg)"';
  }

  ob_start();?>
    <div id="masonry-container">
      <article class="item">
        <div class="barge-img" <?php get_bg_style('team-gray');?>></div>
      </article>
      <article class="item">
        <div class="barge-img"  <?php get_bg_style('plants-growing');?>></div>
      </article>
      <article class="item item-2x">
        <div class="barge-img" <?php get_bg_style('growing-flora');?>></div>
      </article>
      <article class="item">
        <div class="barge-img" <?php get_bg_style('solar-panels');?>></div>
      </article>
      <article class="item">
        <div class="barge-img" <?php get_bg_style('old-science-barge');?>></div>
      </article>

      <!-- First row done -->
      <article class="item item-2x">
        <div class="barge-img"  <?php get_bg_style('person-mending');?>></div>
      </article>
      <article class="item">
        <div class="barge-img" <?php get_bg_style('swimming-mahi');?>></div>
      </article>
      <article class="item">
        <div class="barge-img" <?php get_bg_style('haggman-bermingham');?>></div>
      </article>

      <article class="item">
        <div class="barge-img" <?php get_bg_style('interested-crowd');?>></div>
      </article>
      <article class="item">
        <div class="barge-img" <?php get_bg_style('ny-sci-barge');?>></div>
      </article>
    </div>
  <?php
  echo ob_get_clean();
}



function do_custom_front_page () {


  ob_start(); ?>

  <iframe src="<?php echo get_stylesheet_directory_uri()."/hype.html";?>" frameborder="0" style="width:100%; height: 425px; overflow:hidden;"></iframe>


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

    // include('google-map.php');
    isotope_gallery();?>

    <?php
    echo do_shortcode('[gravityform id="1" title="true" description="true"]');

  ?>
  <?php
  echo ob_get_clean();
}

remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop',    'do_custom_front_page');

genesis();


?>

