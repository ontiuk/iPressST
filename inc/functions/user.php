<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * User & Role functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//---------------------------------------------
//	Users & Role
//
// ipress_users_by_role
//---------------------------------------------

if ( ! function_exists( 'ipress_users_by_role' ) ) :

	/**
	 * Retrieve users by role
	 *
	 * @param string $role User role
	 * @param string $orderby default empty
	 * @param string $order default empty
	 * @return array
	 */
	function ipress_users_by_role( $role, $orderby = '', $order = '' ) {

		// Set up user query args
		$args = [ 'role' => $role ];

		// Tag on ordering: OrderBy
		if ( ! empty( $orderby ) ) {
			$args['orderby'] = sanitize_text_field( $orderby );
		}

		// Tag on ordering: Order
		if ( ! empty( $order ) ) {
			$args['order'] = strtoupper( sanitize_text_field( $order ) ); // ASC | DESC
		}
		return get_users( $args );
	}
endif;
