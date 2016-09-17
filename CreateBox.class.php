<?php

class CreateBox {
	public static function wfCreateBox( $parser ) {
		$parser->setHook( 'createbox', 'CreateBox::acMakeBox' );
		return true;
	}

	public static function actionCreate( $action, $article ) {
		if( $action != 'create' ) {
			return true;
		}

		global $wgRequest;
		$prefix = $wgRequest->getVal( 'prefix' );
		$text = $wgRequest->getVal( 'title' );
		if( $prefix && strpos( $text, $prefix ) !== 0 ) {
			$title = Title::newFromText( $prefix . $text );
			if( is_null( $title ) ) {
				global $wgTitle;
				$wgTitle = SpecialPage::getTitleFor( 'Badtitle' );
				throw new ErrorPageError( 'badtitle', 'badtitletext' );
			} elseif( $title->getArticleID() == 0 ) {
				CreateBox::acRedirect( $title, 'edit' );
			} else {
				CreateBox::acRedirect( $title, 'create' );
			}
		} elseif( $wgRequest->getVal( 'section' ) == 'new' || $article->getID() == 0 ) {
			CreateBox::acRedirect( $article->getTitle(), 'edit' );
		} else {
			global $wgOut;
			$text = $article->getTitle()->getPrefixedText();
			$wgOut->setPageTitle( $text );
			$wgOut->setHTMLTitle( wfMessage( 'pagetitle', $text . ' - ' . wfMessage( 'createbox-create' )->text() )->text() );
			$wgOut->addWikiMsg( 'createbox-exists' );
		}
		return false;
	}

	public static function acGetOption( $input, $name, $value = null ) {
		if( preg_match( "/^\s*$name\s*=\s*(.*)/mi", $input, $matches ) ) {
			if( is_int( $value ) ) {
				return intval( $matches[1] );
			} else {
				return htmlspecialchars( $matches[1] );
			}
		}
		return $value;
	}

	public static function acMakeBox( $input, $argv, $parser ) {
		global $wgRequest, $wgScript;
		if( $wgRequest->getVal( 'action' ) == 'create' ) {
			$prefix = CreateBox::acGetOption( $input, 'prefix' );
			$preload = CreateBox::acGetOption( $input, 'preload' );
			$editintro = CreateBox::acGetOption( $input, 'editintro' ); 
			$placeholder = CreateBox::acGetOption( $input, 'placeholder' ); 
			$text = $parser->getTitle()->getPrefixedText();
			if( $prefix && strpos( $text, $prefix ) === 0 ) {
				$text = substr( $text, strlen( $prefix ) );
			}
		} else {
			$prefix = CreateBox::acGetOption( $input, 'prefix' );
			$preload = CreateBox::acGetOption( $input, 'preload' );
			$editintro = CreateBox::acGetOption( $input, 'editintro' );
			$placeholder = CreateBox::acGetOption( $input, 'placeholder' ); 
			$text = CreateBox::acGetOption( $input, 'default' );
		}
		$submit = htmlspecialchars( $wgScript );
		$width = CreateBox::acGetOption( $input, 'width', 0 );
		// $align = CreateBox::acGetOption( $input, 'align', 'center' );
		$br = ( ( CreateBox::acGetOption( $input, 'break', 'no' ) == 'no' ) ? '' : '<br />' );
		$label = CreateBox::acGetOption( $input, 'buttonlabel', wfMessage( 'createbox-create' )->escaped() );
		$output = <<<ENDFORM
<div class="createbox">
<form name="createbox" action="{$submit}" method="get" class="createboxForm">
<input type='hidden' name="action" value="create">
<input type="hidden" name="prefix" value="{$prefix}" />
<input type="hidden" name="preload" value="{$preload}" />
<input type="hidden" name="editintro" value="{$editintro}" />
<input class="createboxInput" name="title" type="text" value="{$text}" size="{$width}" placeholder="{$placeholder}"/>{$br}
<input type='submit' name="create" class="createboxButton" value="{$label}"/></form></div>
ENDFORM;
		return $parser->replaceVariables( $output );
	}

	public static function acRedirect( $title, $action ) {
		global $wgRequest, $wgOut;
		$query = "action={$action}&prefix=" . $wgRequest->getVal( 'prefix' ) .
			'&preload=' . $wgRequest->getVal( 'preload' ) .
			'&editintro=' . $wgRequest->getVal( 'editintro' ) .
			'&section=' . $wgRequest->getVal( 'section' );
		$wgOut->setSquidMaxage( 1200 );
		$wgOut->redirect( $title->getFullURL( $query ), '301' );
	}
}