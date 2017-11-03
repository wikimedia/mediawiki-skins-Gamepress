<?php

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinGamepress extends SkinTemplate {
	public $skinname = 'gamepress', $stylename = 'gamepress',
		$template = 'GamepressTemplate', $useHeadElement = true;

	/**
	 * Initializes OutputPage and sets up skin-specific parameters
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width;' );
	}

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		// Load CSS via ResourceLoader
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.gamepress'
		) );

		// CSS fixes for older Internet Explorers
		$out->addStyle( 'Gamepress/resources/css/style_ie.css', 'screen', 'IE' );

		// And JS too!
		$out->addModuleScripts( 'skins.gamepress' );
	}
}
