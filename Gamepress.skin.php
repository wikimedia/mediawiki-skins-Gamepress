<?php
/**
 * MediaWiki port of the WordPress theme Gamepress
 *
 * @file
 * @author Aleksandra Łączek
 * @author Jack Phoenix <jack@countervandalism.net> -- MediaWiki port
 * @see http://wordpress.org/themes/gamepress
 * @see http://wp-themes.com/gamepress/
 */

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

class GamepressTemplate extends BaseTemplate {
	/**
	 * Template filter callback for the Gamepress skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		global $wgSitename;

		$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();

		$tagline = '';
		if ( !$this->getMsg( 'tagline' )->isDisabled() ) {
			// We explicitly *need* the <p> tags here!
			$tagline = $this->getMsg( 'tagline' )->parseAsBlock();
		}

		$this->html( 'headelement' );
?>
<!-- PAGE -->
<div id="page">
	<!-- HEADER -->
	<header id="header">
		<div id="header-inner">
			<div id="logo">
				<h1 id="site-title"><?php echo Html::element( 'a', array(
					'href' => $this->data['nav_urls']['mainpage']['href'], 'rel' => 'home' )
					+ Linker::tooltipAndAccesskeyAttribs( 'p-logo' ), $wgSitename ); ?></h1><?php echo $tagline ?>
			</div>
			<div class="clear"></div>
			<nav class="nosearch noprint">
				<ul class="nav" id="primary-nav">
					<?php
						// This is such a fucking clusterfuck.
						// I'd *want* to use $this->makeListItem() here, as
						// usually, but that'd mean unsetting depth, original
						// and parentindex keys for each item and apparently it
						// still wouldn't add the class to the <li> correctly.
						//
						// tl,dr: ugly clusterfuck, but mostly works as intended
						$service = new GamepressSkinNavigationService();
						$menuNodes = $service->parseMessage(
							'gamepress-navigation',
							array( 10, 10, 10, 10, 10, 10 ),
							60 * 60 * 3 // 3 hours
						);

						if ( is_array( $menuNodes ) && isset( $menuNodes[0] ) ) {
							$counter = 0;
							foreach ( $menuNodes[0]['children'] as $level0 ) {
								$hasChildren = isset( $menuNodes[$level0]['children'] );
					?>
					<li class="page_item<?php echo ( $hasChildren ? ' page_item_has_children' : '' ) ?>">
						<a class="nav<?php echo $counter ?>_link" href="<?php echo htmlspecialchars( $menuNodes[$level0]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level0]['text'], ENT_QUOTES ) ?></a>
						<?php if ( $hasChildren ) { ?>
						<ul class="children">
<?php
							foreach ( $menuNodes[$level0]['children'] as $level1 ) {
?>
							<li class="page_item">
								<a href="<?php echo htmlspecialchars( $menuNodes[$level1]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level1]['text'], ENT_QUOTES ) ?></a>
<?php
								if ( isset( $menuNodes[$level1]['children'] ) ) {
									echo '<ul class="children">';
									foreach ( $menuNodes[$level1]['children'] as $level2 ) {
?>
									<li class="page_item">
										<a href="<?php echo htmlspecialchars( $menuNodes[$level2]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level2]['text'], ENT_QUOTES ) ?></a>
									</li>
<?php
									}
									echo '</ul>';
									$counter++;
								}
?>
							</li>
<?php
							}
							echo '</ul>';
							$counter++;
						} // hasChildren
						echo '</li>';
							} // top-level foreach
						} // is_array( $menuNodes )
?>
				</ul>
			</nav>
		</div>
		<!-- END HEADER-INNER -->
	</header>
	<div id="content-wrapper">
		<div id="content-inner">
		<!-- CONTENT -->
		<div id="content">
			<div id="hilariously-bad-hack-for-responsiveness" style="height: 0; visibility: hidden;">You shouldn't even be seeing this. Bizzeebeever told me to add this here so that we can get responsiveness working for all screens.</div>
			<section id="main-content" role="main">
				<article class="post hentry list-big-thumb">
					<div id="jump-to-nav" class="mw-jump"><?php $this->msg( 'jumpto' ) ?> <a href="#content"><?php $this->msg( 'jumptonavigation' ) ?></a><?php $this->msg( 'comma-separator' ) ?><a href="#searchInput"><?php $this->msg( 'jumptosearch' ) ?></a></div>
					<div class="noimage">
						<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div><?php } ?>
						<?php
						// In WordPress, this displays the date when the blog
						// post was published:
						//<div class="entry-date"><span class="day">17</span><span class="month">Oct</span></div>
						// For MediaWiki, it doesn't really work for various
						// reasons, so I just took it off [[for now]].
						?>
						<div class="entry-header">
							<h1 id="firstHeading" class="firstHeading" lang="<?php $this->text( 'pageLanguage' ); ?>"><?php $this->html( 'title' ) ?></h1>
						</div>
					</div>
					<div class="entry-content mw-body">
						<?php if ( $this->data['undelete'] ) { ?><div id="contentSub2"><?php $this->html( 'undelete' ) ?></div><?php } ?>
						<?php if ( $this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html( 'newtalk' ) ?></div><?php } ?>
						<!-- start content -->
						<?php
						$this->html( 'bodytext' );
						if ( $this->data['catlinks'] ) {
							$this->html( 'catlinks' );
						}
						?>
						<!-- end content -->
						<?php
						if ( $this->data['dataAfterContent'] ) {
							$this->html( 'dataAfterContent' );
						}
						?>
					</div>
				</article>
			</section>
		</div><!-- END CONTENT -->

		<!-- SIDEBAR -->
		<aside id="sidebar" class="noprint" role="complementary">
		<?php
			$this->renderPortals( $this->data['sidebar'] );
			$this->renderPersonalTools();
			$this->cactions();
		?>
		</aside>
		<!-- END SIDEBAR -->
		<div class="clear"></div>
		</div><!-- END #CONTENT-INNER -->
	</div><!-- END #CONTENT-WRAPPER -->
	<?php
		$prefooterFirst = $this->getMsg( 'gamepress-prefooter-1' );
		$prefooterSecond = $this->getMsg( 'gamepress-prefooter-2' );
		$prefooterThird = $this->getMsg( 'gamepress-prefooter-3' );

		// If at least one of these messages has some content, show the
		// prefooter area
		if (
			!$prefooterFirst->isDisabled() ||
			!$prefooterSecond->isDisabled() ||
			!$prefooterThird->isDisabled()
		)
		{
	?>
	<!-- PREFOOTER -->
	<aside id="prefooter" class="noprint">
		<div id="prefooter-inner">
			<div class="grid">
				<div class="one-third">
					<div class="widget">
						<?php echo $prefooterFirst->parse() ?>
					</div>
				</div><!-- .one-third -->
				<div class="one-third">
					<div class="widget">
						<?php echo $prefooterSecond->parse() ?>
					</div>
				</div><!-- .one-third -->
				<div class="one-third">
					<?php echo $prefooterThird->parse() ?>
				</div><!-- .one-third -->
			</div>
		</div><!-- END #PREFOOTER-INNER -->
		<!-- END HEADER -->
	</aside>
	<!-- END #PREFOOTER -->
	<?php } ?>
	<?php
		$validFooterIcons = $this->getFooterIcons( 'icononly' );
		$validFooterLinks = $this->getFooterLinks( 'flat' ); // Additional footer links

		if ( count( $validFooterIcons ) + count( $validFooterLinks ) > 0 ) { ?>
<!-- FOOTER -->
<footer class="noprint" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
	<div id="footer-border"></div>
		<div id="footer-inner">
<?php
			$footerEnd = '<span class="alignright"><a href="#" class="scrollup">' .
				$this->getMsg( 'gamepress-back-to-top' )->parse() . '</a></span>';
			$footerEnd .= '</div><!-- #footer-inner --></footer><!-- END FOOTER -->';
		} else {
			$footerEnd = '';
		}

		echo '<span class="alignleft">';

		foreach ( $validFooterIcons as $blockName => $footerIcons ) { ?>
	<div id="f-<?php echo htmlspecialchars( $blockName ); ?>ico">
<?php
			foreach ( $footerIcons as $icon ) {
				echo $this->getSkin()->makeFooterIcon( $icon );
			}
?>
	</div>
<?php
		}


		$i = 0;
		$footerLen = count( $validFooterLinks );
		if ( $footerLen > 0 ) {
			foreach ( $validFooterLinks as $aLink ) {
				$this->html( $aLink );
				// Output the separator for all items, save for the
				// last one
				if ( $i !== ( $footerLen - 1 ) ) {
					echo '<span class="sep"> | </span>';
				}
				$i++;
			}
		}
		echo '</span>';

		echo $footerEnd;
?>
</div><!-- END #PAGE -->
<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
	} // end of execute() method

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {
		if ( !isset( $sidebar['SEARCH'] ) ) {
			$sidebar['SEARCH'] = true;
		}
		if ( !isset( $sidebar['TOOLBOX'] ) ) {
			$sidebar['TOOLBOX'] = true;
		}
		if ( !isset( $sidebar['LANGUAGES'] ) ) {
			$sidebar['LANGUAGES'] = true;
		}

		foreach ( $sidebar as $boxName => $content ) {
			if ( $content === false ) {
				continue;
			}

			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $content );
			}
		}
	}

	function renderPersonalTools() {
		$this->customBox( 'personal', $this->getPersonalTools() );
	}

	function searchBox() {
		global $wgUseTwoButtonsSearchForm;
?>
		<div class="widget">
			<form role="search" method="get" id="searchform" class="searchform" action="<?php $this->text( 'wgScript' ) ?>">
				<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
				<?php
					echo $this->makeSearchInput( array( 'id' => 'searchInput' ) );
					echo $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton' ) );
					if ( $wgUseTwoButtonsSearchForm ) {
						echo '&#160;';
						echo $this->makeSearchButton( 'fulltext', array( 'id' => 'mw-searchButton', 'class' => 'searchButton' ) );
					} else { ?>
						<div><a href="<?php $this->text( 'searchaction' ) ?>" rel="search"><?php $this->msg( 'powersearch-legend' ) ?></a></div><?php
					} ?>
			</form>
		</div>
<?php
	}

	/**
	 * Prints the content actions bar.
	 */
	function cactions() {
?>
	<div id="p-cactions" class="portlet widget" role="navigation">
		<h3 class="widget-title"><?php $this->msg( 'views' ) ?></h3>
			<ul><?php
				foreach ( $this->data['content_actions'] as $key => $tab ) {
					echo '
				' . $this->makeListItem( $key, $tab );
				} ?>
			</ul>
	</div>
<?php
	}

	function toolbox() {
?>
	<div class="portlet widget" id="p-tb" role="navigation">
		<h3 class="widget-title"><?php $this->msg( 'toolbox' ) ?></h3>
		<ul>
<?php
		foreach ( $this->getToolbox() as $key => $tbItem ) {
			echo $this->makeListItem( $key, $tbItem );
		}

		Hooks::run( 'SkinTemplateToolboxEnd', array( &$this, true ) );
?>
		</ul>
	</div>
<?php
	}

	function languageBox() {
		if ( $this->data['language_urls'] ) {
?>
	<div id="p-lang" class="portlet widget" role="navigation">
		<h3 class="widget-title"<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h3>
		<ul>
<?php		foreach ( $this->data['language_urls'] as $key => $langLink ) {
				echo $this->makeListItem( $key, $langLink );
			}
?>
		</ul>
	</div>
<?php
		}
	}

	/**
	 * Render a sidebar box from user-supplied data (a portion of MediaWiki:Sidebar)
	 *
	 * @param $bar string
	 * @param $cont array|string
	 */
	function customBox( $bar, $cont ) {
		$portletAttribs = array(
			'class' => 'generated-sidebar widget',
			'id' => Sanitizer::escapeId( "p-$bar" ),
			'role' => 'navigation'
		);
		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		echo '	' . Html::openElement( 'div', $portletAttribs );

		$msgObj = wfMessage( $bar );
?>

		<h3 class="widget-title"><?php echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $bar ); ?></h3>
<?php	if ( is_array( $cont ) ) { ?>
			<ul>
<?php 			foreach ( $cont as $key => $val ) {
					echo $this->makeListItem( $key, $val );
				}
?>
			</ul>
<?php	} else {
			// allow raw HTML block to be defined by extensions (such as NewsBox)
			echo $cont;
		}
?>
	</div>
<?php
	}
}

/**
 * A fork of Oasis' NavigationService with some changes.
 * Namely the name was changed and "magic word" handling was removed from
 * parseMessage() and some (related) unused functions were also removed.
 */
class GamepressSkinNavigationService {

	const version = '0.01';

	/**
	 * Parses a system message by exploding along newlines.
	 *
	 * @param $messageName String: name of the MediaWiki message to parse
	 * @param $maxChildrenAtLevel Array:
	 * @param $duration Integer: cache duration for memcached calls
	 * @param $forContent Boolean: is the message we're supposed to parse in
	 *								the wiki's content language (true) or not?
	 * @return Array
	 */
	public function parseMessage( $messageName, $maxChildrenAtLevel = array(), $duration, $forContent = false ) {
		global $wgLang, $wgContLang, $wgMemc;

		$this->forContent = $forContent;

		$useCache = $wgLang->getCode() == $wgContLang->getCode();

		if ( $useCache || $this->forContent ) {
			$cacheKey = wfMemcKey( $messageName, self::version );
			$nodes = $wgMemc->get( $cacheKey );
		}

		if ( empty( $nodes ) ) {
			if ( $this->forContent ) {
				$lines = explode( "\n", wfMessage( $messageName )->inContentLanguage()->text() );
			} else {
				$lines = explode( "\n", wfMessage( $messageName )->text() );
			}
			$nodes = $this->parseLines( $lines, $maxChildrenAtLevel );

			if ( $useCache || $this->forContent ) {
				$wgMemc->set( $cacheKey, $nodes, $duration );
			}
		}

		return $nodes;
	}

	/**
	 * Function used by parseMessage() above.
	 *
	 * @param $lines String: newline-separated lines from the supplied MW: msg
	 * @param $maxChildrenAtLevel Array:
	 * @return Array
	 */
	private function parseLines( $lines, $maxChildrenAtLevel = array() ) {
		$nodes = array();

		if ( is_array( $lines ) && count( $lines ) > 0 ) {
			$lastDepth = 0;
			$i = 0;
			$lastSkip = null;

			foreach ( $lines as $line ) {
				// we are interested only in lines that are not empty and start with asterisk
				if ( trim( $line ) != '' && $line{0} == '*' ) {
					$depth = strrpos( $line, '*' ) + 1;

					if ( $lastSkip !== null && $depth >= $lastSkip ) {
						continue;
					} else {
						$lastSkip = null;
					}

					if ( $depth == $lastDepth + 1 ) {
						$parentIndex = $i;
					} elseif ( $depth == $lastDepth ) {
						$parentIndex = $nodes[$i]['parentIndex'];
					} else {
						for ( $x = $i; $x >= 0; $x-- ) {
							if ( $x == 0 ) {
								$parentIndex = 0;
								break;
							}
							if ( $nodes[$x]['depth'] <= $depth - 1 ) {
								$parentIndex = $x;
								break;
							}
						}
					}

					if ( isset( $maxChildrenAtLevel[$depth - 1] ) ) {
						if ( isset( $nodes[$parentIndex]['children'] ) ) {
							if ( count( $nodes[$parentIndex]['children'] ) >= $maxChildrenAtLevel[$depth - 1] ) {
								$lastSkip = $depth;
								continue;
							}
						}
					}

					$node = $this->parseOneLine( $line );
					$node['parentIndex'] = $parentIndex;
					$node['depth'] = $depth;

					$nodes[$node['parentIndex']]['children'][] = $i + 1;
					$nodes[$i + 1] = $node;
					$lastDepth = $node['depth'];
					$i++;
				}
			}
		}

		return $nodes;
	}

	/**
	 * @param $line String: line to parse
	 * @return Array
	 */
	private function parseOneLine( $line ) {
		// trim spaces and asterisks from line and then split it to maximum two chunks
		$lineArr = explode( '|', trim( $line, '* ' ), 2 );

		// trim [ and ] from line to have just http://en.wikipedia.org instead of [http://en.wikipedia.org] for external links
		$lineArr[0] = trim( $lineArr[0], '[]' );

		if ( count( $lineArr ) == 2 && $lineArr[1] != '' ) {
			$link = trim( wfMessage( $lineArr[0] )->inContentLanguage()->text() );
			$desc = trim( $lineArr[1] );
		} else {
			$link = $desc = trim( $lineArr[0] );
		}

		$text = $this->forContent ? wfMessage( $desc )->inContentLanguage() : wfMessage( $desc );
		if ( $text->isDisabled() ) {
			$text = $desc;
		}

		if ( wfMessage( $lineArr[0] )->isDisabled() ) {
			$link = $lineArr[0];
		}

		if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
			$href = $link;
		} else {
			if ( empty( $link ) ) {
				$href = '#';
			} elseif ( $link{0} == '#' ) {
				$href = '#';
			} else {
				$title = Title::newFromText( $link );
				if ( is_object( $title ) ) {
					$href = $title->fixSpecialName()->getLocalURL();
				} else {
					$href = '#';
				}
			}
		}

		return array(
			'original' => $lineArr[0],
			'text' => $text,
			'href' => $href
		);
	}

} // end of the GamepressSkinNavigationService class
