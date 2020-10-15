<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Search form functionality shortcodes.
 *
 * @package		iPress\Shortcodes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

//---------------------------------------------
//	Search Form 
//
//	'ipress_search_form'
//---------------------------------------------

/**
 * Retrieve current user info
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_search_form_shortcode( $atts ) {

	// Capture output
	ob_start();
	get_search_form( );
	$html = ob_get_clean();
		
	return $html;
}

// Construct search form
add_shortcode( 'ipress_search_form', 'ipress_search_form_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

// Pre search form, for js validation etc
add_action( 'pre_get_search_form', function(){} );

//end
