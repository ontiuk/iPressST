/**
 * File customizer.js
 *
 * Theme Customizer enhancements for a better user experience
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously
 */

( function( $, api, undefined ) {
	'use strict';

	// Trigger when DOM ready
	$( function() {

		//-------------------------------------------------------------------
		// Multiple Checkboxes
		// - Add the values of the checked checkboxes to the hidden input
		//-------------------------------------------------------------------
		$( '.customize-control-checkbox-multiple' ).live( 'change', 'input:checkbox', function(e) {
			e.preventDefault();

			var that	 = $( this ),
				hidden	 = that.find( '.checkbox-multiple-hidden' ).prop( 'id' ),	
				chx_val  = that.find( 'input:checkbox:checked' ).map( function() {
					return this.value;
				} ).get().join( ',' );

			var chx_str = api.instance( hidden ).get();
			api.instance( hidden ).set( chx_val );
			return;
		});

	} );
	
} ) ( jQuery, wp.customize );
