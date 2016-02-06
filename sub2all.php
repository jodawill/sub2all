<?php 
/**
* Plugin Name: Sub2All
* Plugin URI: https://github.com/jodawill/sub2all
* Description: Allow BBPress users to subscribe to all topics.
* Version: 0.01
* Author: Josh Williams
* Author http://jodawill.com
* License: GPL2
*/
defined ('ABSPATH') or die('');

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

include_once('sub2all-options.php');

function s2a_activate() {
} register_activation_hook(__FILE__, 's2a_activate');

function s2a_is_enabled($user_id) {
 $ret = (get_user_meta($user_id, 's2a_disabled', true) != 'on');
 return $ret;
}

function s2a_is_user_subscribed_to_topic($is_subscribed, $user_id) {
 if (s2a_is_enabled($user_id)) {
  return true;
 } else {
  return $is_subscribed;
 }
} add_filter('bbp_is_user_subscribed_to_topic', 's2a_is_user_subscribed_to_topic', 10, 2);

function s2a_is_user_subscribed_to_forum($is_subscribed, $user_id) {
 if (s2a_is_enabled($user_id)) {
  return true;
 } else {
  return $is_subscribed;
 }
} add_filter('bbp_is_user_subscribed_to_forum', 's2a_is_user_subscribed_to_forum', 10, 2);

function s2a_is_user_subscribed($is_subscribed, $user_id, $object_id) {
 if (s2a_is_enabled($user_id)) {
  return true;
 } else {
  return $is_subscribed;
 }
} add_filter('bbp_is_user_subscribed', 's2a_is_user_subscribed', 10, 3);

function s2a_get_topic_subscribers($users) {
 $args = array('fields' => 'id');
 $all_users = get_users($args);
 foreach ($all_users as $user) {
  if (s2a_is_enabled($user)) {
   $users[] = $user;
  }
 }
 $users = array_unique($users, SORT_REGULAR);
 return $users;
} add_filter('bbp_get_topic_subscribers','s2a_get_topic_subscribers', 10, 1);

function s2a_get_forum_subscribers($users) {
 $args = array('fields' => 'id');
 $all_users = get_users($args);
 foreach ($all_users as $user) {
  if (s2a_is_enabled($user)) {
   $users[] = $user;
  }
 }
 $users = array_unique($users, SORT_REGULAR);
 return $users;
} add_filter('bbp_get_forum_subscribers','s2a_get_forum_subscribers', 10, 1);

function s2a_get_user_subscribe_link($html, $r, $user_id) {
 if (s2a_is_enabled($user_id)) {
  return '';
 } else {
  return $html;
 }
} add_filter('bbp_get_user_subscribe_link', 's2a_get_user_subscribe_link', 10, 3);
?>
