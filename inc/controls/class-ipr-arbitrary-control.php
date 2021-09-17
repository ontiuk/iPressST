<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Class to create a custom arbitrary html control for dividers etc
 *
 * @package iPress\Controls
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Load if in customizer
if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * The arbitrary control class
	 */
	class IPR_Arbitrary_Control extends WP_Customize_Control {

		/**
		 * The settings var
		 *
		 * @var string $settings the blog name.
		 */
		public $settings = 'blogname';

		/**
		 * The description var
		 *
		 * @var string $description the control description.
		 */
		public $description = '';

		/**
		 * Renter the control
		 *
		 * @return void
		 */
		public function render_content() {

			// Render by type
			switch ( $this->type ) {
				case 'text':
					echo sprintf( '<p class="customize-control-description">%s</p>', wp_kses_post( $this->description ) );
					break;
				case 'heading':
					echo sprintf( '<span class="customize-control-title">%s</span>', esc_html( $this->label ) );
					break;
				case 'divider':
					echo '<hr class="customize-control-divider" />';
					break;
				default: // default as text type
					echo sprintf( '<p class="customize-control-description">%s</p>', wp_kses_post( $this->description ) );
					break;
			}
		}
	}
}
