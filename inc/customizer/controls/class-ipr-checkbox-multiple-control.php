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
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @uses WP_Customize_Control::to_json()
		 */
		public function to_json() {

			// Set JSON
			parent::to_json();
			$this->json['choices'] = $this->choices;

			// Multiple values from array or string, default array
			$multi_values = ( is_array( $this->value() ) ) ? $this->value() : explode( ',', $this->value() );

			// Set up choice list
			$rendered_list = '';
			foreach ( $this->choices as $label => $value ) {
				$rendered_list .= $this->render_list( $value, $label, $multi );
			}
			$this->json['rendered_list'] = $rendered_list;

			// Set up hidden input
			$this->json['hidden_input'] = sprintf(
				'<input type="hidden" id="%1$s" %2$s class="%3$s" value="%4$s" />',
				esc_attr( $this->id ),
				esc_attr( $this->link() ),
				esc_attr( $this->type . '-hidden' ),
				esc_attr( implode( ',', $multi_values ) )
			);
		}

		/**
		 * Render a list item item from choice
		 *
		 * @param string $value Render value
		 * @param string $label Render HTML
		 * @param array $multi Multi checkbox value 
		 */
		private function render_list( $value, $label, $multi ) {

			// Construct list item
			return sprintf(
				'<li><label><input type="checkbox" name="%1$s" id="%2$s" class="%3$s" value="%4%s" %5$s />%6$s</label></li>',
				esc_attr( $this->type . '-' . $value ),
				esc_attr( $this->id . '_' . $value ),
				esc_attr( $this->type ),
				esc_attr( $value ),
				checked( in_array( $value, $multi_values, true ) ),
				esc_html( $label )
			);
		}

		/**
		 * Renders the JS content template
		 *
		 * @see WP_Customize_Control::print_template()
		 */
		public function content_template() {
?>
			<# if ( ! data.choices ) { return; } #>

			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #> 

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<ul>{{{ data.rendered_list }}}</ul>

			{{{ data.hidden_input }}}
<?php
		}
	}
}
