<?php
function barge_partners () {

  $args = array(
    'post_type' => 'partner'
  );

  $query = new WP_Query($args);

  if($query->have_posts()){
    echo "<section class='partner-logos text-center'>";
    echo "<p class='h1'>Our Genereous Partners</p>";

      while($query->have_posts()){
        $query->the_post();
        $partner_url = types_render_field('partnership-link', array('output'=>'raw'));
        ?>
          <a href="<?php echo $partner_url;?>" target="_blank">
            <?php the_post_thumbnail('full');?>          
          </a>
        <?php
      }
    echo "</section>";
  } else {
    echo "No posts found.";
  }

  wp_reset_postdata();
}
