<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Generate dynamic CSS styles.
 *
 * - Based on gihub.com/CarlosRios/php-css
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_CSS' ) ) :

	/**
	 * Set up dynamic CSS generation
	 */
	final class IPR_CSS {

		/**
		 * The css selector that you're currently adding rules to
		 *
		 * @access protected
		 * @var string
		 */
		protected $selector = '';

		/**
		 * Stores the final css output with all of its rules for the current selector.
		 *
		 * @access protected
		 * @var string
		 */
		protected $selector_output = '';

		/**
		 * Stores all of the rules that will be added to the selector
		 *
		 * @access protected
		 * @var string
		 */
		protected $css = '';

		/**
		 * The string that holds all of the css to output
		 *
		 * @access protected
		 * @var string
		 */
		protected $output = '';

		/**
		 * Stores media queries
		 * 
		 * @access protected
		 * @var null
		 */
		protected $media_query = null;

		/**
		 * The string that holds all of the css to output inside of the media query
		 *
		 * @access protected
		 * @var string
		 */
		protected $media_query_output = '';

		/**
		 * Sets a selector to the object and changes the current selector to a new one
		 *
		 * @param string $selector The css identifier of the html that you wish to target
		 * @return object $this
		 */
		public function set_selector( $selector = '' ) {

			// Render the css in the output string whenever the selector changes
			if ( '' !== $this->selector ) {
				$this->add_selector_rules_to_output();
			}
			
			// Set selector and chain result
			$this->selector = $selector;
			return $this;
		}

		/**
		 * Wrapper for the set_selector method, changes the selector to add new rules
		 *
		 * @param string $selector The css identifier of the html that you wish to target
		 * @return object $this
		 */
		public function change_selector( $selector = '' ) {
			return $this->set_selector( $selector );
		}

		/**
		 * Adds a new rule to the css output
		 *
		 * @param string $property The css property
		 * @param string $value The value to be placed with the property
		 * @param string $prefix Optional, allows for the creation of a browser prefixed property
		 * @return object $this
		 */
		public function add_property( $property, $value, $prefix = null ) {
			
			// Non-zero properties
			$ip_css_non_zero = apply_filters( 'ipress_css_non_zero', [ 'font-size', 'opacity' ] );

			// Disallow setting selected non-zero properties
			if ( in_array( $property, $ip_css_non_zero ) && 0 === $value ) {
				return false;
			}

			// Invalid non-numeric
			if ( empty( $value ) && ! is_numeric( $value ) ) {
				return false;
			}

			// Set property format depending on prefix
			$format = ( is_null( $prefix ) ) ? '%1$s:%2$s;' : '%3$s%1$s:%2$s;';

			// Set selector property and chain result
			$this->css .= sprintf( $format, $property, $value, $prefix );
			return $this;
		}

		/**
		 * Adds multiple properties with their values to the css output
		 *
		 * @param  array $properties List of properties & values
		 * @return object $this
		 */
		public function add_properties( $properties ) {

			// Iterate properties and chain result
			array_walk( $properties, function( $value, $property ) {
				$this->add_property( $property, $value );
			} );
			return $this;
		}

		/**
		 * Sets a media query in the class
		 *
		 * @param  string $value Media query to add
		 * @return object $this
		 */
		public function start_media_query( $value ) {

			// Add the current rules to the output
			$this->add_selector_rules_to_output();

			// Add any previous media queries to the output
			if ( ! empty( $this->media_query ) ) {
				$this->add_media_query_rules_to_output();
			}

			// Set the new media query
			$this->media_query = $value;
			return $this;
		}

		/**
		 * Stops using a media query
		 *
		 * @see start_media_query()
		 * @return object $this
		 */
		public function stop_media_query() {
			return $this->start_media_query( null );
		}

		/**
		 * Adds the current media query's rules to the class' output variable
		 *
		 * @return object $this
		 */
		private function add_media_query_rules_to_output() {

			// Add media query & reset cache, chain result
			if ( ! empty( $this->media_query_output ) ) {
				$this->output .= sprintf( '@media %1$s{%2$s}', $this->media_query(), $this->media_query_output );
				$this->media_query_output = '';
			}
			return $this;
		}

		/**
		 * Adds the current selector rules to the output variable
		 *
		 * @return object $this
		 */
		private function add_selector_rules_to_output() {

			// Add css and reset cache, chain result
			if ( ! empty( $this->css ) ) {
				$this->selector_output = $this->selector;
				$selector_output = sprintf( '%1$s{%2$s}', $this->selector_output, $this->css );

				// Add all CSS to output				
				if ( ! empty( $this->media_query ) ) {
					$this->media_query_output .= $selector_output;
					$this->css = '';
				} else {
					$this->output .= $selector_output;
				}

				// Reset the css
				$this->css = '';
			}
			return $this;
		}

		/**
		 * Checks if the media query is active
		 */
		public function has_media_query() : bool {
			return empty( $this->media_query );
		}
		
		/**
		 * Checks if the css is active
		 */
		public function has_css() : bool {
			return empty( $this->css );
		}

		/**
		 * Resets the css variable
		 */
		public function reset_css() {
			$this->css = '';
		}

		/**
		 * Returns the minified css in the $_output variable
		 *
		 * @return string
		 */
		public function css_output() {

			// Add current selector's rules to output
			$this->add_selector_rules_to_output();

			// Output minified css
			return $this->output;
		}
	}

endif;
