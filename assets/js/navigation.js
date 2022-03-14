// Theme navigation functionality
( function() {
	'use strict';

	// eslint-disable-next-line @wordpress/no-global-event-listener
	document.addEventListener( 'DOMContentLoaded', function () {
		
		// Get the main navigation element ID, if available
		const container = document.getElementById( 'site-navigation' );
		if ( ! container ) {
			return;
		}

		// Get the menu toggle button, normally hidden on non-mobile
		const button = container.querySelector( 'button' );
		if ( ! button ) {
			return;
		}

		// Get the top level menu wrapper list
		const menu = container.querySelector( 'ul' );

		// Hide menu toggle button if menu is empty and return early.
		if ( ! menu ) {
			button.style.display = 'none';
			return;
		}

		// Set default aria & class parameters
		button.setAttribute( 'aria-expanded', 'false' );
		menu.setAttribute( 'aria-expanded', 'false' );
		menu.classList.add( 'nav-menu' );

		// Click event to activate toggled menu
		button.addEventListener( 'click', function () {
			container.classList.toggle( 'toggled' );
			const expanded = container.classList.contains( 'toggled' )
				? 'true'
				: 'false';
			button.setAttribute( 'aria-expanded', expanded );
			menu.setAttribute( 'aria-expanded', expanded );
		} );

		// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
		document.addEventListener( 'click', function( event ) {
			const isClickInside = container.contains( event.target );

			if ( ! isClickInside ) {
				container.classList.remove( 'toggled' );
				button.setAttribute( 'aria-expanded', 'false' );
			}
		} );

		// Get all the link elements within the menu.
		const links = menu.getElementsByTagName( 'a' );

		// Get all the link elements with children within the menu.
		const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		// Toggle focus each time a menu link is focused or blurred.
		for ( const link of links ) {
			link.addEventListener( 'focus', toggleFocus, true );
			link.addEventListener( 'blur', toggleFocus, true );
		}

		// Toggle focus each time a menu link with children receive a touch event.
		for ( const link of linksWithChildren ) {
			link.addEventListener( 'touchstart', toggleFocus, false );
		}

		/**
		 * Sets or removes .focus class on an element.
		 */
		function toggleFocus() {
			if ( event.type === 'focus' || event.type === 'blur' ) {
				let self = this;
				// Move up through the ancestors of the current link until we hit .nav-menu.
				while ( ! self.classList.contains( 'nav-menu' ) ) {
					// On li elements toggle the class .focus.
					if ( 'li' === self.tagName.toLowerCase() ) {
						self.classList.toggle( 'focus' );
					}
					self = self.parentNode;
				}
			}

			if ( event.type === 'touchstart' ) {
				const menuItem = this.parentNode;
				event.preventDefault();
				for ( const link of menuItem.parentNode.children ) {
					if ( menuItem !== link ) {
						link.classList.remove( 'focus' );
					}
				}
				menuItem.classList.toggle( 'focus' );
			}
		}
	} );
}() );
