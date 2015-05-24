<?php
/**
 * MediaWiki port of the WordPress theme Gamepress
 *
 * @file
 * @ingroup Skins
 * @author Aleksandra Łączek
 * @author Jack Phoenix <jack@countervandalism.net> -- MediaWiki port
 * @date 30 November 2014
 * @see http://wordpress.org/themes/gamepress
 * @see http://wp-themes.com/gamepress/
 *
 * To install, place the Gamepress folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * wfLoadSkin( 'Gamepress' );
 */

if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'Gamepress' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Gamepress'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for Gamepress skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the Gamepress skin requires MediaWiki 1.25+' );
}
