<?php

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinGamepress extends SkinTemplate {
	/**
	 * Initializes OutputPage and sets up skin-specific parameters
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		global $wgVersion;
		parent::initPage( $out );
		// CSS fixes for older Internet Explorers
		$out->addStyle( __DIR__ . '/resources/css/style_ie.css', 'screen', 'IE' );

		// Option `responsive` is not supported before 1.35.
		// Option `template` is not supported before 1.35.
		if ( version_compare( $wgVersion, '1.36', '<' ) ) {
			$this->template = 'GamepressTemplate';
			$out->addMeta( 'viewport', 'width=device-width;' );
		}
		// Option `styles`is not supported before 1.35.
		if ( version_compare( $wgVersion, '1.35', '<' ) ) {
			$out->addModuleStyles( [
				'mediawiki.skinning.interface',
				'mediawiki.skinning.content.externallinks',
				'skins.gamepress.styles'
			] );
		}
	}
}
