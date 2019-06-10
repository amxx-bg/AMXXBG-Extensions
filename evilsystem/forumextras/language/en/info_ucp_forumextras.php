<?php
/**
 *
 * Forum Extras. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil, http://github.com/stfkolev
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placehoCustom ranka,re used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'UCP_FORUMEXTRAS'							=> 'Forum Extras',
	'UCP_FORUMEXTRAS_TITLE'						=> 'Forum Extras',

	/*! Change Rank */
	'UCP_FORUMEXTRAS_CHANGERANK'				=> 'Change Rank',
	'UCP_FORUMEXTRAS_CHANGERANK_LABEL'			=> 'Change rank',
	'UCP_FORUMEXTRAS_CHANGERANK_DESCRIPTION'	=> 'This allows you to change your forum rank.',
	'UCP_FORUMEXTRAS_CHANGERANK_SAVED'			=> 'Your rank has been updated successfully!',

	/*! Change Username */
	'UCP_FORUMEXTRAS_CHANGENICK'				=> 'Change Username',
	'UCP_FORUMEXTRAS_CHANGENICK_LABEL'			=> 'Change username',
	'UCP_FORUMEXTRAS_CHANGENICK_DESCRIPTION'	=> 'This allows you to change your forum username.',
	'UCP_FORUMEXTRAS_CHANGENICK_SAVED'			=> 'Your username has been updated successfully!',

	/*! Points */
	'UCP_FORUMEXTRAS_ADDPOINTS'					=> 'Add points',
	'UCP_FORUMEXTRAS_ADDPOINTS_DESCRIPTION'		=> 'This allows you to add points to your account for real money. Can be used for forum extras.'

));
