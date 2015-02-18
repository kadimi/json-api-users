<?php

/*
Controller Name: Users
Controller Description: List all users
*/

class JSON_API_Users_Controller {

	public function all() {

		global $json_api;

		if ( ! $json_api->query->cookie ) {
			$json_api->error( "You must include a 'cookie' var in your request. Use the `generate_auth_cookie` Auth API method." );
		}
		
		$user_id = wp_validate_auth_cookie( $json_api->query->cookie, 'logged_in' );
		
		if ( ! $user_id) {
			$json_api->error( "Invalid authentication cookie. Use the `generate_auth_cookie` method." );
		}

		if ( ! user_can( $user_id, 'list_users' ) ) {
			$json_api->error( "This user can't list users" );
		}

		$users = array();
		$wp_users = get_users( array( 'orderby' => 'ID') );
		foreach ( $wp_users as $u ) {
			$users[] = $u->data;
		}
		return $users;
  	}
}