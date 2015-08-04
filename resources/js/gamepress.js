jQuery( function( $ ) {
	/**
	 * Tabs & Accordion
	 */
	$( 'ul.tabs' ).tabs( '> .pane', {effect: 'fade'} );
	$( '.accordion' ).tabs( '.pane', {tabs: 'h4', effect: 'slide'} );
	$( '.accordion p:empty' ).remove();

	/**
	 * Adding transparent wmode to YouTube iframe
	 */
	$( '.video-embed iframe' ).each( function() {
		var url = $( this ).attr( 'src' );
		if ( url.indexOf( '?' ) == -1 ) {
			$( this ).attr( 'src', url + '?wmode=transparent' );
		} else {
			$( this ).attr( 'src', url + '&wmode=transparent' );
		}
	} );

	/**
	 * Scrolling to top of page
	 */
	$( '.scrollup' ).on( 'click', function() {
		$( 'html, body' ).animate( { scrollTop: 0 }, 1000, 'easeOutQuint' );
		return false;
	} );

	$( '.archive-content .video-item:odd' ).addClass( 'l' );

	/**
	 * Notifications
	 */
	$( '.close' ).on( 'click', function() {
		$( this ).parent( '.message' ).fadeOut( 'normal' );
	} );

	/**
	 * Sliders
	 */
	if ( $( '#slider' ).not( '.thumbs' ).length > 0 ) {
		$( '#slider' ).not( '.thumbs' ).nivoSlider( {
			effect: 'random',
			slices: 15,
			boxCols: 8,
			boxRows: 4,
			animSpeed: 500,
			pauseTime: 5000,
			startSlide: 0,
			directionNav: true,
			manualAdvance: true,
			controlNav: true,
			controlNavThumbs: false,
			keyboardNav: true,
			pauseOnHover: true,
			manualAdvance: false
		} );
	}
	if ( $( '#slider.thumbs' ).length > 0 ) {
		$( '#slider.thumbs' ).nivoSlider( {
			effect: 'random',
			slices: 15,
			boxCols: 8,
			boxRows: 4,
			animSpeed: 500,
			pauseTime: 5000,
			startSlide: 0,
			controlNavThumbs: true
		} );
	}

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

	/**
	 * Fallback for browsers without content: css attribute
	 */
	var ieVersion = 0;
	var clientPC = navigator.userAgent.toLowerCase(); // Get client info
	if ( /msie (\d+\.\d+);/.test( clientPC ) ) { // test for MSIE x.x;
		ieVersion = ( new Number( RegExp.$1 ) ); // capture x.x portion and store as a number
	}

	if (
		!Modernizr.generatedcontent ||
		( /msie (\d+\.\d+);/.test( clientPC ) /* test for MSIE x.x */ && ieVersion == 8 ) ) {
		$( '#primary-nav ul li:first-child > a, #primary-nav ul ul li:first-child > a' ).before( $( '<span/>' ).addClass( 'before' ) );
		$( '.img-bevel' ).before( '<span class="before-img-bevel-fix"></span>' );
	}
} );