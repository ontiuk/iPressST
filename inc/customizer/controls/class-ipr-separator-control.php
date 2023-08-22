<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Customizer control: separator
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
	 * Separator customize control class
	 *
	 * @package iPress\Controls
	 */
	class IPR_Separator_Control extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered
		 *
		 * @var string $type
		 */
		public $type = 'ipress-separator-control';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON
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
		public function content_template() {
?>		
		<hr class="customize-control-separator" />
<?php
		}

		/**
		 * Empty PHP template
		 */
		public function render_content() {}
	}
}
