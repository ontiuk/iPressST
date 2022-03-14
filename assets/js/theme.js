// Theme jQuery functionality
( function( $, t, undefined ) {
	'use strict';
	
	// Window & Document
	var body	= $( 'body' ),
		_window = $( window );
	
	// Clunky but useable mobile detection
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match( /Android|webOS/i );
		},
		BlackBerry: function() {
			return navigator.userAgent.match( /BlackBerry/i );
		},
		iOS: function() {
			return navigator.userAgent.match( /iPhone|iPad|iPod/i );
		},
		Opera: function() {
			return navigator.userAgent.match( /Opera Mini/i );
		},
		Windows: function() {
			return navigator.userAgent.match( /IEMobile/i );
		},
		any: function() {
			return ( isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows() );
		}
	};

	// On window load functions
	_window.on( 'load', function(){
		// Hide DOM loader: class 'loader hidden'
		var loader = $( '.loader' );
		loader.addClass( 'hidden' ); 
	});

	// Window scroll to top functions
    _window.on( 'scroll', function () {
        if ( _window.scrollTop() >= 800 ) {
            $( '#scrollTop' ).fadeIn();
        } else {
            $( '#scrollTop' ).fadeOut();
        }
    });
	
    // ------------------------------------------------------
    // Scrolling defaults
    // ------------------------------------------------------
    function scrollTo( full_url ) {
        var parts 	= full_url.split( '#' );
        var trgt 	= parts[1];
        var target_offset 	= $('#' + trgt).offset();
        var target_top 		= target_offset.top - 100;
        
		if ( target_top < 0 ) {
            target_top = 0;
        }

        $( 'html, body' ).animate( {
            scrollTop: target_top
        }, 1000 );
    }
	
	// Other jQuery
    $( '#scrollTop' ).hide();

	// Document Ready DOM
	$( function() {

		// scroll body to top on click
		$( '#scrollTop' ).on( 'click', function () {
			$( 'body,html' ).animate({
				scrollTop: 0
			}, 800);
			return false;
		} );

        // Animated scrolling
        $( '.scroll-to, .scroll-to-top' ).click( function( event ) {
            event.preventDefault();

            var full_url = this.href,
                parts = full_url.split( '#' );
    
            if ( parts.length > 1 ) {
                scrollTo( full_url );
            }
        });

        // -----------------------------------------------------
        // Cart Increase/Reduce product amount
        // -----------------------------------------------------
    
        $(document).on('click', '.dec-btn', function () {
            var siblings = $(this).siblings('input.qty'),
                val  = parseInt(siblings.val(), 10),
                step = parseInt(siblings.data('step'), 10),
                min  = parseInt(siblings.data('min'), 10),
                max  = parseInt(siblings.data('max'), 10);

            // Min qty...
            if ( val === min || ( val - step <= 0 ) ) { return; }
            siblings.val(val - step);
            siblings.trigger('change');
        });

        $(document).on('click', '.inc-btn', function () {
            var siblings = $(this).siblings('input.qty'),
                val  = parseInt(siblings.val(), 10),
                step = parseInt(siblings.data('step'), 10),
                min  = parseInt(siblings.data('min'), 10),
                max  = parseInt(siblings.data('max'), 10);

            // Max qty...
            if ( val === max || ( val + step > max ) ) { return; }
            siblings.val(val + step);
            siblings.trigger('change');
        });
	});

} )( jQuery, theme );

//end
