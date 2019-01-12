<?php

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinGamepress extends SkinTemplate {
	public $skinname = 'gamepress', $stylename = 'gamepress',
		$template = 'GamepressTemplate';

	/**
	 * Initializes OutputPage and sets up skin-specific parameters
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width;' );
		$out->addModules( 'skins.gamepress.site' );
	}

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		// Load CSS via ResourceLoader
		$out->addModuleStyles( [
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.gamepress.styles'
		] );

		// CSS fixes for older Internet Explorers
		$out->addStyle( 'Gamepress/resources/css/style_ie.css', 'screen', 'IE' );
	}
}
