<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme navigation functions & functionality.
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Menu & Navigation
// 
// - ipress_is_nav_location
// - ipress_has_nav_location_menu
// - ipress_has_menu
// - ipress_get_nav_menu_items
//----------------------------------------------

if ( ! function_exists( 'ipress_is_nav_location' ) ) :

	/**
	 * Determine if a theme supports a particular menu location 
	 * - Case sensitive, so camel-case location
	 *
	 * @see		has_nav_menu()
	 * @param  	string $location
	 * @return 	boolean 
	 */
	function ipress_is_nav_location( $location ) {

		// Set the menu name
		if ( empty( $location ) ) { return false; }

		// Retrieve registered menu locations
		$locations = array_keys( get_nav_menu_locations() );

		// Test location correctly registered
		return in_array( $location, $locations );
	}
endif;

if ( ! function_exists( 'ipress_has_nav_location_menu' ) ) :

	/**
	 * Determine if a theme supports a particular menu location & menu combination
	 * - Case sensitive, so camel-case location & menu
	 *
	 * @param	string $location
	 * @param	string $menu 
	 * @param	string $route slug or name default name
	 * @return boolean 
	 */
	function ipress_has_nav_location_menu( $location, $menu, $route = 'name' ) {

		// Set the menu name
		if ( empty( $location ) || empty( $menu ) ) { return false; }

		// Retrieve registered menu locations
		$locations = get_nav_menu_locations();

		// Test location correctly registered
		if ( ! array_key_exists( $location, $locations ) ) { return false; }

		// Get location menu 
		$term = get_term( (int) $locations[$location], 'nav_menu' );

		// Test menu
		return ( 'slug' === $route ) ? ( $term->slug === $menu ) : ( $term->name === $menu ); 
	}
endif;

if ( ! function_exists( 'ipress_has_menu' ) ) :

	/**
	 * Determine if a theme has a particular menu registered
	 * - Case sensitive, so camel-case menu
	 *
	 * @param  string $menu
	 * @return boolean 
	 */
	function ipress_has_menu( $menu ) {

		// Set the menu name
		if ( empty( $menu ) ) { return false; }

		// Retrieve registered menu locations
		$menus = wp_get_nav_menus();

		// None registered
		if ( empty( $menus ) ) { return false; }

		// Registered
		foreach ( $menus as $m ) {
			if ( $menu === $m->name ) { return true; }
		}

		// Default
		return false;
	}
endif;

if ( ! function_exists( 'ipress_get_nav_menu_items' ) ) :

	/**
	 * Retrieve menu items for a menu by location
	 *
	 * @param  string $menu Name of the menu location
	 * @return array
	 */
	function ipress_get_nav_menu_items( $menu ) {

		// Set the menu name
		if ( empty( $menu ) ) { return false; }

		// Retrieve registered menu locations
		$locations = get_nav_menu_locations();

		// Test menu is correctly registered
		if ( ! isset( $locations[ $menu ] ) ) { return false; }

		// Retrieve menu set against location
		$menu = wp_get_nav_menu_object( $locations[ $menu ] );
		if ( false === $menu ) { return false; }

		// Retrieve menu items from menu
		$menu_items = wp_get_nav_menu_items( $menu->term_id );

		// No menu items?
		return ( empty( $menu_items ) ) ? false : $menu_items;
	}
endif;

//end
