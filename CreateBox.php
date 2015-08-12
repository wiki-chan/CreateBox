<?php
/*

 CreateBox v1.7 -- Specialized Inputbox for page creation

 Author: Ross McClure
 http://www.mediawiki.org/wiki/User:Algorithm

 Inputbox written by Erik Moeller <moeller@scireview.de>

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 http://www.gnu.org/copyleft/gpl.html

 To install, add following to LocalSettings.php
   require_once("extensions/CreateBox/CreateBox.php");
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

$wgHooks['ParserFirstCallInit'][] = 'CreateBox::wfCreateBox';

$wgHooks['UnknownAction'][] = 'CreateBox::actionCreate';
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'CreateBox',
	'author' => array('Ross McClure', '페네트-'),
	'version' => '1.7',
	'url' => 'https://github.com/wiki-chan/CreateBox',
	'license-name' => 'GPL-2.0',
	'descriptionmsg' => 'createbox-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['CreateBox'] = $dir . 'CreateBox.i18n.php';
$wgAutoloadClasses['CreateBox'] = $dir . 'CreateBox.class.php';
