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
	class IPR_Title_Control extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered
		 *
		 * @var string $type
		 */
		public $type = 'section_title';

		/**
		 * Enqueue custom css for control rendering
		 */
		public function enqueue() {
			wp_enqueue_style( 'ipress-controls-css', IPRESS_INCLUDES_URL . '/customizer/controls/css/customizer.css', [], null, 'all' );
		}

		/**
		 * Displays the control content
		 */
		public function render_content() {
		
			// Required: label
			if ( empty( $this->label ) ) { return; }

			echo sprintf( 
				'<div class="section-heading-control"><h3 class="customize-control-title">%s</h3></div>',
				esc_html( $this->label )
			);
		}
	}
}
