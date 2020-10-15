/**
 * File customize.js
 *
 * Theme Customizer enhancements for a better user experience
 */

( function( $, api, undefined ) {
	'use strict';

	// Trigger when DOM ready
	$( function() {

		//----------------------------------
		// General Customize functionality
		//----------------------------------
		
		// Turn on / off hero section via setting
		api.control( 'ipress_hero' ).setting.bind( function( active ) { 
			var heroSection = api.section( 'ipress_hero' );

			if ( active ) {
				heroSection.activate({ duration: 600 });
			} else {
				heroSection.deactivate({ duration: 400 });
			} 
		} );
	} );
	
} ) ( jQuery, wp.customize );
