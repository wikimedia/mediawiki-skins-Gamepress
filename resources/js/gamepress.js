jQuery( function( $ ) {
	/**
	 * Tabs & Accordion
	 */
	$( 'ul.tabs' ).tabs( '> .pane', {effect: 'fade'} );
	$( '.accordion' ).tabs( '.pane', {tabs: 'h4', effect: 'slide'} );
	$( '.accordion p:empty' ).remove();

	/**
	 * Adding placeholder support for input & textarea elements in older browsers
	 */
	// ashley 16 January 2014: not needed for MediaWiki
	//$('input[placeholder], textarea[placeholder]').placeholder();

	/**
	 * Adding transparent wmode to YouTube iframe
	 */
	$( '.video-embed iframe' ).each( function() {
		var url = $( this ).attr( 'src' );
		if ( url.indexOf( '?' ) == -1 ) {
			$( this ).attr( 'src', url + '?wmode=transparent' );
		} else {
			$( this ).attr("src",url+"&wmode=transparent");
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
		$( '#slider' ).not( '.thumbs' ).nivoSlider({
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
		$( '#slider.thumbs' ).nivoSlider({
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
	 * Fix menu hover on IE < 7.0
	 */
	if ( $.browser.msie && $.browser.version.substr( 0, 1 ) < 7 ) {
		/*$('li').has('ul').mouseover(function() {
			$(this).children('ul').css('visibility', 'visible');
		}).mouseout(function() {
			$(this).children('ul').css('visibility', 'hidden');
		})*/
	};

	/**
	 * Fallback for browsers without CSS transitions
	 */
	if ( !Modernizr.csstransitions ) {
		var to1, to2;

		/**
		 * Main menu - second level
		 */
		$( '#primary-nav ul' ).css( 'visibility', 'hidden' );
		$( '#primary-nav ul' ).hide();

		$( '#primary-nav > li' ).on( 'mouseover', function( e ) {
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().show().css( 'visibility', 'visible' ).animate({
				top: '38',
				opacity: 1
			}, 200, 'easeInOutSine' );
		}).on( 'mouseout', function( e ) {
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().animate({
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
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().show().css( 'visibility', 'visible' ).animate({
				left: '163',
				opacity: 1
			}, 200, 'easeInOutSine' );
		}).on( 'mouseout', function( e ) {
			$( e.delegateTarget ).find( '> ul' ).stop().clearQueue().animate({
				left: '173',
				opacity: 0
			}, 200, 'easeInOutSine', function(){
				$( e.delegateTarget ).find( '> ul' ).css( 'visibility', 'hidden' );
			} );
		} );
	};

	/**
	 * Fallback for browsers without content: css attribute
	 */
	if ( !Modernizr.generatedcontent || ( $.browser.msie && $.browser.version.substr( 0, 1 ) == '8' ) ) {
		$( '#primary-nav ul li:first-child > a, #primary-nav ul ul li:first-child > a' ).before( $( '<span/>' ).addClass( 'before' ) );
		$( '.img-bevel' ).before( '<span class="before-img-bevel-fix"></span>' );
	}
} );