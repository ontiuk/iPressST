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
	class IPR_Checkbox_Multiple_Control extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered
		 *
		 * @var string $type
		 */
		public $type = 'checkbox-multiple';

		/**
		 * Displays the control content
		 */
		public function render_content() {

			// No options?
			if ( empty( $this->choices ) ) {
				return;
			}

			if ( ! empty( $this->label ) ) {
				echo sprintf( '<span class="customize-control-title">%s</span>', esc_html( $this->label ) );
			}

			if ( ! empty( $this->description ) ) {
				echo sprintf( '<span class="description customize-control-description">%s</span>', esc_html( $this->description ) );
			}

			$multi_values = ( is_array( $this->value() ) ) ? $this->value() : explode( ',', $this->value() );

			echo '<ul>';
			foreach ( $this->choices as $value => $label ) {

				echo sprintf(
					'<li><label><input type="checkbox" name="%s" id="%s" class="%s" value="%s" %s />%s</label></li>',
					esc_attr( $this->type . '-' . $value ),
					esc_attr( $this->id . '_' . $value ),
					esc_attr( $this->type ),
					esc_attr( $value ),
					checked( in_array( $value, $multi_values, true ) ),
					esc_html( $label )
				);
			}
			echo '</ul>';

			echo sprintf(
				'<input type="hidden" id="%s" %s class="%s" value="%s" />',
				esc_attr( $this->id ),
				esc_attr( $this->link() ),
				esc_attr( $this->type . '-hidden' ),
				esc_attr( implode( ',', $multi_values ) )
			);
		}
	}
}
