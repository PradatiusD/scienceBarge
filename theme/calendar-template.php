<?php
/* 
Template Name: Calendar Page
*/

if (!isset($_GET['calendar'])) {

	$full_calendar_cdn_base = "//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/";


	wp_enqueue_script('moment', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js', array(),'2.10.3', true);
	wp_enqueue_script('full-calendar-js',    $full_calendar_cdn_base .'fullcalendar.min.js' ,   array('jquery','moment'), '2.3.1', true);
	wp_enqueue_style( 'full-calendar-css',   $full_calendar_cdn_base .'fullcalendar.min.css',   array(), '2.3.1', 'all');
	wp_enqueue_style( 'full-calendar-print', $full_calendar_cdn_base .'fullcalendar.print.css', array(), '2.3.1', 'print');
	wp_enqueue_script('full-calendar-client', get_stylesheet_directory_uri() . '/js/program-calendar.js', array('full-calendar-js','jquery'), '1.0.0',true);


	function program_calendar () {
		ob_start();?>
			<div id='calendar'></div>
		<?php
		echo ob_get_clean();
	}

	add_action('genesis_entry_footer','program_calendar');
	genesis();

} else {

  $args = array(
  	'post_type' => array('events','bookings')
  );

	$activities_query = new WP_Query($args);
	$activities = array();

	if ($activities_query->have_posts()) { 

		while ($activities_query->have_posts()) { 

			$activities_query->the_post();

			$activity = array(
				"title"     => get_the_title(),
				"content"   => get_the_content(),
				"data"      => get_post_custom(),
				"permalink" => get_permalink()
			);

			array_push($activities, $activity);
		}
	}

	wp_send_json($activities);
	wp_reset_postdata();
}