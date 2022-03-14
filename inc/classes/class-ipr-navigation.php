<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress navigation features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Navigation' ) ) :

	/**
	 * Set up navigation features
	 */
	final class IPR_Navigation {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Remove surrounding <div> from WP Navigation
			add_filter( 'wp_nav_menu_args', [ $this, 'nav_menu_args' ] );

			// Remove navigation <li> injected classes
			add_filter( 'nav_menu_css_class', [ $this, 'css_attributes_filter' ], 99, 1 );
			add_filter( 'nav_menu_item_id', [ $this, 'css_attributes_filter' ], 99, 1 );
			add_filter( 'page_css_class', [ $this, 'css_attributes_filter' ], 99, 1 );

			// Custom navigation markup template
			add_filter( 'navigation_markup_template', [ $this, 'navigation_markup_template' ], 10, 2 );
		}

		//---------------------------------------------
		// Navigation Action & Filter Functions
		//---------------------------------------------

		/**
		 * Remove the <div> surrounding the dynamic navigation to cleanup markup
		 *
		 * @param array $args default []
		 * @return array $args
		 */
		public function nav_menu_args( $args = [] ) {

			// Filterable menu args
			$ip_nav_clean = (bool) apply_filters( 'ipress_nav_clean', false );
			if ( true !== $ip_nav_clean ) {
				$args['container'] = false;
			}

			// Return menu args
			return $args;
		}

		/**
		 * Remove Injected classes, ID's and Page ID's from Navigation <li> items
		 *
		 * @param array|string
		 * @return array|string
		 */
		public function css_attributes_filter( $var ) {

			// Filterable css attributes
			$ip_nav_css_attr = (bool) apply_filters( 'ipress_nav_css_attr', false );
			$css_attr_val    = ( is_array( $var ) ) ? [] : '';

			// Return attributes
			return ( true === $ip_nav_css_attr ) ? $css_attr_val : $var;
		}

		/**
		 * Custom navigation markup template hooked into `navigation_markup_template` filter hook.
		 *
		 * @param $template default template
		 * @param $class class name
		 * @return $string
		 */
		public function navigation_markup_template( $template, $class ) {
			return apply_filters( 'ipress_navigation_markup_template', $template, $class );
		}
	}

endif;

// Instantiate Navigation Class
return new IPR_Navigation;
