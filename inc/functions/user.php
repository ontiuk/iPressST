<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * User & Role functions & functionality.
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//---------------------------------------------
//	Users & Rols
//	
//	- ipress_users_by_role
//---------------------------------------------

if ( ! function_exists( 'ipress_users_by_role' ) ) :

	/**
	 * Retrieve users by role
	 *
	 * @return array
	 */
	function ipress_users_by_role( $role, $orderby = '', $order = '' ) {

		// Set up user query args
		$args = [ 'role' => $role ];

		// Tag on ordering: OrderBy
		if ( ! empty( $orderby ) ) {
			$args['orderby'] = $orderby;
		}

		// Tag on ordering: Order
		if ( ! empty( $order ) ) {
			$args['order'] = strtoupper( $order ); // ASC | DESC
		}

		// retrieve users
	    return get_users( $args );
	}
endif;

//end
