<?php

/*
  Plugin Name: JSON API Users
  Plugin URI: http://www.kadimi.com/en/quote
  Description: add "/users"
  Version: 1.0
  Author: Nabil Kadimi
  Author URI: http://www.kadimi.com/
  License: GPLv3
 */

// include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
add_filter( 'json_api_controllers', 'json_users_add_controller', 10, 2 );
function json_users_add_controller( $c ) {

	$c[] = 'users';
	return $c;
}

add_filter( 'json_api_users_controller_path', 'json_users_controller_path' );
function json_users_controller_path() {
	return dirname(__FILE__) . '/controllers/users.php';
}

add_action( 'init', 'json_users_check_auth_cookie', 100 );
function json_users_check_auth_cookie() {
	
	global $json_api;

	if ( $json_api->query->cookie ) {
		$user_id = wp_validate_auth_cookie( $json_api->query->cookie, 'logged_in' );
		if ( $user_id ) {
			$user = get_userdata($user_id);
			wp_set_current_user($user->ID, $user->user_login);
		}
	}
}