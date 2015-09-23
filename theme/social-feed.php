<?php

require 'lib/autoload.php';
require 'config.php';
use TwitterOAuth\Auth\SingleUserAuth;
use TwitterOAuth\Serializer\ArraySerializer;
date_default_timezone_set('UTC');

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

$auth = new SingleUserAuth($twitter_credentials, new ArraySerializer());
/**
 * Returns a collection of the most recent Tweets posted by the user
 * https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
 */
$params = array(
  'screen_name' => 'miascibarge',
  'count' => 12,
  'exclude_replies' => true
);


function social_feed () {
  include 'feed-template.html';
  wp_enqueue_script('instafeed', get_stylesheet_directory_uri(). '/js/instafeed.min.js', array(),'1.3.2', true);
  wp_enqueue_script('async', get_stylesheet_directory_uri(). '/js/async.js', array(),'0.9.2', true);
  wp_enqueue_script('social-angular-client', get_stylesheet_directory_uri().'/js/social-client.js', array('angular', 'angular-sanitize', 'instafeed', 'async'), '1.0.0', true);
}

if (isset($_GET['service'])) {
  $response = $auth->get('statuses/user_timeline', $params);
  $response = json_encode($response);
  header('Content-Type: application/json');
  echo $response;
} else {
  add_action('genesis_after_sidebar_widget_area','social_feed');
}