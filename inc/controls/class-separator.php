<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Customizer control: separator
 *	
 * @package		iPress\Controls
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Load if in customizer
if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Separator customize control class
	 * 
	 * @package iPress\Controls
	 */
	class WP_Customize_Separator_Control extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered
		 * 
		 * @var string $type
		 */
		public $type = 'separator';

		/**
		 * Displays the control content
		 */
		public function render_content() {
			echo '<hr/>';
		}
	}
}

//end
