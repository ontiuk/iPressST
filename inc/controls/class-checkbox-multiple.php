<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Multiple checkbox customizer
 *	
 * @package		iPress\Controls
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

// Load if in customizer
if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Multiple checkbox customize control class
	 * 
	 * @package iPress\Controls
	 */
	class WP_Customize_Checkbox_Multiple_Control extends WP_Customize_Control {

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
			if ( empty( $this->choices ) ) { return; }
	?>

			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<?php $multi_values = ( is_array( $this->value() ) ) ? $this->value() : explode( ',', $this->value() ) ; ?>

			<ul>
			<?php foreach ( $this->choices as $value => $label ) : ?>

				<li>
					<label>
						<input type="checkbox" name="<?php echo esc_attr( $this->type . '-' . $value ); ?>" id="<?php echo esc_attr( $this->id . '_' . $value ); ?>" class="<?php echo esc_attr( $this->type ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> /> 
						<?php echo esc_html( $label ); ?>
					</label>
				</li>

			<?php endforeach; ?>
			</ul>

			<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?> class="<?php echo esc_attr( $this->type . '-hidden' ); ?>" value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
	<?php 
		}
	}
}

//end
