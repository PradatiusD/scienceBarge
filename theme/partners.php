<?php
function barge_partners () {

  $args = array(
    'post_type' => 'partner'
  );

  $query = new WP_Query($args);

  if($query->have_posts()){
    echo "<section class='partner-logos text-center' id='partners'>";
    echo "<p class='h1 text-center'>Our Genereous Partners</p>";

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



/**
 * Adds Featured_Partner_Widget widget.
 */

class Featured_Partner_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'featured_partner_widget', // Base ID
      __( 'Featured Parter', 'text_domain' ), // Name
      array( 'description' => __( 'Featured Partner Widget', 'text_domain' ), ) // Args
    );
  }

  /**
   * Front-end display of widget partners.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    if ( ! empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
    }

    $query_args = array('post_type' => 'partner');

    $query = new WP_Query($query_args);
    $posts = $query->posts;

    $random_number = rand(0, count($posts) - 1);

    if (!isset($posts[$random_number])) {
      return;
    }

    $post = $posts[$random_number];
    $post_id = $post->ID;

    $post_meta = get_post_meta($post_id);
    if (isset($post_meta['wpcf-partnership-link'][0])) {
      $partner_url = $post_meta['wpcf-partnership-link'][0];    
    } else {
      $partner_url = '/';
    }

    echo '<a href="'. $partner_url. '" target="_blank">';
      echo get_the_post_thumbnail($post_id, 'full');
    echo '</a>';

    echo '<p>'.$post->post_content.'</p>';

    echo $args['after_widget'];
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php 
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $instance;
  }

} // class Featured_Partner_Widget

// register Featured_Partner_Widget widget
function add_partner_widget() {
    register_widget( 'Featured_Partner_Widget' );
}
add_action( 'widgets_init', 'add_partner_widget' );