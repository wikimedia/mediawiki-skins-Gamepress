jQuery( function( $ ) {
	/**
	 * Scrolling to top of page
	 */
	$( '.scrollup' ).on( 'click', function() {
		$( 'html, body' ).animate( { scrollTop: 0 }, 1000, 'easeOutQuint' );
		return false;
	} );

	/**
	 * Make the top menu usable on touchscreen devices so that it's possible to
	 * open up a menu and tap on the sub-menu items
	 */
	$( '#primary-nav li.page_item_has_children > a' ).on( 'touchstart', function() {
		$( this ).off( 'touchstart' ).on( 'click', function( e ) {
			e.preventDefault();
		} );
		e.preventDefault();
	} );

	/**
	 * Fallback for browsers without CSS transitions
	 */
	if ( !Modernizr.csstransitions ) {
		/**
		 * Main menu - second level
		 */
		$( '#primary-nav ul' ).css( 'visibility', 'hidden' );
		$( '#primary-nav ul' ).hide();

		$( '#primary-nav > li' ).on( 'mouseover', function( e ) {
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().show().css( 'visibility', 'visible' ).animate( {
				top: '38',
				opacity: 1
			}, 200, 'easeInOutSine' );
		} ).on( 'mouseout', function( e ) {
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().animate( {
				top: '50',
				opacity: 0
			}, 200, 'easeInOutSine', function() {
				$( e.delegateTarget ).find( '> ul' ).css( 'visibility', 'hidden' );
			} );
		} );

		/**
		 * Main menu - 3rd level
		 */
		$( '#primary-nav > li > ul > li' ).on( 'mouseover', function( e ) {
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().show().css( 'visibility', 'visible' ).animate( {
				left: '163',
				opacity: 1
			}, 200, 'easeInOutSine' );
		} ).on( 'mouseout', function( e ) {
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().animate( {
				left: '173',
				opacity: 0
			}, 200, 'easeInOutSine', function() {
				$( e.delegateTarget ).find( '> ul' ).css( 'visibility', 'hidden' );
			} );
		} );
	};
} );
