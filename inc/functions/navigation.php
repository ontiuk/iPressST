<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme navigation functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

//----------------------------------------------
//	Menu & Navigation
//
// ipress_is_nav_location
// ipress_has_nav_location_menu
// ipress_has_menu
// ipress_get_nav_menu_items
//----------------------------------------------

if ( ! function_exists( 'ipress_is_nav_location' ) ) :

	/**
	 * Determine if a theme supports a particular menu location
	 *
	 * - Case sensitive, so camel-case location
	 *
	 * @see has_nav_menu()
	 * @param string $location Nav location
	 */
	function ipress_is_nav_location( $location ) : bool {

		// Retrieve registered menu locations
		$locations = array_keys( get_nav_menu_locations() );

		// Test location correctly registered
		return in_array( $location, $locations, true );
	}
endif;

if ( ! function_exists( 'ipress_has_nav_location_menu' ) ) :

	/**
	 * Determine if a theme supports a particular menu location & menu combination
	 *
	 * - Case sensitive, so camel-case location & menu
	 *
	 * @param string $location Nav location name
	 * @param string $menu Name of the menu location
	 * @param string $route Slug or name, default name
	 */
	function ipress_has_nav_location_menu( $location, $menu, $route = 'name' ) : bool {

		// Retrieve registered menu locations
		$locations = get_nav_menu_locations();

		// Test location correctly registered
		if ( ! array_key_exists( $location, $locations ) ) {
			return false;
		}

		// Get location menu
		$term = get_term( (int) $locations[ $location ], 'nav_menu' );

		// Test menu
		return ( 'slug' === $route ) ? ( $term->slug === $menu ) : ( $term->name === $menu );
	}
endif;

if ( ! function_exists( 'ipress_has_menu' ) ) :

	/**
	 * Determine if a theme has a particular menu registered
	 *
	 * - Case sensitive, so camel-case menu
	 *
	 * @param string $menu Name of the menu location
	 */
	function ipress_has_menu( $menu ) : bool {

		// Retrieve registered menu locations
		$menus = wp_get_nav_menus();

		// None registered
		if ( empty( $menus ) ) {
			return false;
		}

		// Registered
		foreach ( $menus as $m ) {
			if ( $menu === $m->name ) {
				return true;
			}
		}
		return false;
	}
endif;

if ( ! function_exists( 'ipress_get_nav_menu_items' ) ) :

	/**
	 * Retrieve menu items for a menu by location
	 *
	 * @param string $menu Name of the menu location
	 * @return array
	 */
	function ipress_get_nav_menu_items( $menu ) {

		// Retrieve registered menu locations
		$locations = get_nav_menu_locations();

		// Test menu is correctly registered
		if ( ! isset( $locations[$menu] ) ) {
			return false;
		}

		// Retrieve menu set against location
		$menu = wp_get_nav_menu_object( $locations[ $menu ] );
		if ( false === $menu ) {
			return false;
		}

		// Retrieve menu items from menu if there
		$menu_items = wp_get_nav_menu_items( $menu->term_id );
		return ( empty( $menu_items ) ) ? false : $menu_items;
	}
endif;
