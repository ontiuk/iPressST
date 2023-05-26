// Theme jQuery functionality
( function( $, app, undefined ) {
	'use strict';
	
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

    // ------------------------------------------------------
    // Window Load functionality
    // ------------------------------------------------------

	// Set initial load stated
	const windowLoad = function() {

		// Hide DOM loader: class 'loader hidden'
		$('.loader').addClass('hidden');

		// Hide the back to top button, initial state
		$('.back-to-top-link').hide();
	};
	
	// On window load event
	$(window).on('load', windowLoad);

    // ------------------------------------------------------
    // Scrolling functionality
    // ------------------------------------------------------

	// Set the back to top button
	const btnTop = $('.back-to-top-link');
	
	// Track custom scroll point
	const trackScroll = function() {

		const scrollOffset = window.pageYOffset;
		const scrollStart = btnTop.data('scroll-start');

		if ( scrollOffset >= scrollStart ) { 
			btnTop.fadeIn();
		}

		if ( scrollOffset < scrollStart ) {
			btnTop.fadeOut();
		}
	};

	// Scroll to top functionality, override default click behaviour
	const scrollTop = function(event) {
		event.preventDefault();

		const scrollSpeed = btnTop.data('scroll-speed');
		$('html, body').animate({scrollTop : 0}, scrollSpeed);
	}

	// DOM Ready functionality
	$( function() {

        // -----------------------------------------------------
        // Back To Top click if active
        // -----------------------------------------------------
		if ( btnTop.length ) {

			// Show the button when scrolling down
			$(window).on('scroll',trackScroll);

			// Set click to reset browser offset
			btnTop.on('click', scrollTop);
		}

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

} )( jQuery, app );

//end
