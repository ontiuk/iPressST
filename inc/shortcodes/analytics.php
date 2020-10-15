<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Google Analytics shortcodes.
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
//	Google Analytics Shortcodes
//	'ipress_analytics'
//	
//	- cutting edge browsers with IE degradation 
//	- preloads analytics
//---------------------------------------------

/**
 * Insert Google Analytics Code - place above </body> tag
 * <?php echo do_shortcode('[ipress_analytics code="UA-xxxx" ecommerce]'); ?>
 *
 * @param	array|string $atts 
 * @return	string
 */
function ipress_analytics_shortcode( $atts ) {

	// Get defaults and attributes
	$defaults 	= [ 'code' => '' ];
	$atts 		= shortcode_atts( $defaults, $atts, 'ipress_analytics' );

	// No code? Sanitize
	if ( empty( $atts['code'] ) || false === stripos( $atts['code'], 'UA' ) ) { return; }
	$ga_code = sanitize_text_field( $atts['code'] );
	
	// Start data
	ob_start();
?>
	<!-- Google Analytics -->
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php echo esc_attr( $ga_code ); ?>', 'auto');
	<?php if ( isset( $atts['ecommerce'] ) ) : ?>
	ga('require', 'ec');
	<?php endif; ?>
	ga('send', 'pageview');

	</script>
	<!-- End Google Analytics -->
<?php

	// Store data
	$output = ob_get_clean();
	$output = (string) apply_filters( 'ipress_analytics_shortcode', $output, $atts );

	return trim( $output );
}

// Get current user - should be used via do_shortcode
add_shortcode( 'ipress_analytics', 'ipress_analytics_shortcode' ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_add_shortcode

//end
