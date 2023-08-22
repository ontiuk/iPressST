<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Multiple checkbox customizer
 *
 * @package iPress\Controls
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

// Load if in customizer
if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Multiple checkbox customize control class
	 *
	 * @package iPress\Controls
	 */
	class IPR_Customize_Base_Control extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered
		 *
		 * @var string $type
		 */
		public $type = 'ipress-base-control';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @uses WP_Customize_Control::to_json()
		 */
		public function to_json() {

			parent::to_json();
			$this->json['choices'] = $this->choices;
		}

		/**
		 * Empty JS template
		 */
		public function content_template() {}

		/**
		 * Empty PHP template
		 */
		public function render_content() {}
	}
}
