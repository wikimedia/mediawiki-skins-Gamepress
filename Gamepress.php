<?php
/**
 * MediaWiki port of the WordPress theme Gamepress
 *
 * @file
 * @ingroup Skins
 * @author Aleksandra Łączek
 * @author Jack Phoenix <jack@countervandalism.net> -- MediaWiki port
 * @date 16 January 2014
 * @see http://wordpress.org/themes/gamepress
 * @see http://wp-themes.com/gamepress/
 *
 * To install, place the Gamepress folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * require_once("$IP/skins/Gamepress/Gamepress.php");
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point.' );
}

// Skin credits that will show up on Special:Version
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Gamepress',
	'version' => '1.0.5',
	'author' => array( '[http://webtuts.pl/themes/ Aleksandra Łączek]', 'Jack Phoenix' ),
	'description' => 'Easy-to-use gaming-oriented skin',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Gamepress',
);

// The first instance must be strtolower()ed so that useskin=gamepress works and
// so that it does *not* force an initial capital (i.e. we do NOT want
// useskin=Gamepress) and the second instance is used to determine the name of
// *this* file.
$wgValidSkinNames['gamepress'] = 'Gamepress';

// Autoload the skin class, make it a valid skin, set up i18n, set up CSS & JS
// (via ResourceLoader)
$wgAutoloadClasses['SkinGamepress'] = __DIR__ . '/Gamepress.skin.php';
$wgMessagesDirs['SkinGamepress'] = __DIR__ . '/i18n';
$wgResourceModules['skins.gamepress'] = array(
	'styles' => array(
		'skins/Gamepress/resources/css/reset.css' => array( 'media' => 'screen' ),
		// MonoBook also loads these
		'skins/common/commonElements.css' => array( 'media' => 'screen' ),
		'skins/common/commonContent.css' => array( 'media' => 'screen' ),
		'skins/common/commonInterface.css' => array( 'media' => 'screen' ),
		// Styles custom to the Gamepress skin
		'skins/Gamepress/resources/css/style.css' => array( 'media' => 'screen' ),
		'skins/Gamepress/resources/css/dark.css' => array( 'media' => 'screen' )
	),
	'scripts' => array(
		// gamepress.js depends on a fuckload of other stuff :-(
		'/skins/Gamepress/resources/js/jquery.easing.1.3.js', // for the "Back to top" link
		'/skins/Gamepress/resources/js/modernizr-custom.js',
		'/skins/Gamepress/resources/js/jquery.tools.min.js',
		'/skins/Gamepress/resources/js/gamepress.js'
	),
	'position' => 'top'
);

// Themes
$wgResourceModules['themeloader.skins.gamepress.blue'] = array(
	'styles' => array(
		'skins/Gamepress/resources/images/blue/style.css' => array( 'media' => 'screen' ),
	)
);

$wgResourceModules['themeloader.skins.gamepress.green'] = array(
	'styles' => array(
		'skins/Gamepress/resources/images/green/style.css' => array( 'media' => 'screen' ),
	)
);

$wgResourceModules['themeloader.skins.gamepress.orange'] = array(
	'styles' => array(
		'skins/Gamepress/resources/images/orange/style.css' => array( 'media' => 'screen' ),
	)
);