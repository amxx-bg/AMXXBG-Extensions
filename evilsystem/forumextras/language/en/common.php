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
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	//Basic
	'FORUMEXTRAS_USER_POINTS'					=> 'Points [ %.2f ]',

	// UCP
	'FORUM_EXTRAS_RANK_VIEWTOPIC'				=> 'Custom rank',
	'FORM_WAIT_X_DAYS'							=> 'Wait %s days before changing your title again!',

	'FORM_WAIT_X_DAYS_NICK'						=> 'Wait %s days before changing your username again!',
	'NICK_ALREADY_EXISTS'						=> 'The nickname %s is already in our database, try another one!',

	// ACP
	'ACP_FORUMEXTRAS_SETTINGS_TITLE'			=> 'Forum Extras\' Settings',
	
	// Cooldown
	'ACP_FORUMEXTRAS_COOLDOWN_LABEL'			=> 'Forum extras cooldown',
	'ACP_FORUMEXTRAS_COOLDOWN_DESCRIPTION'		=> 'Period in days that users must wait before using that extra again',
	'ACP_FORUMEXTRAS_COOLDOWN_MENUITEM'			=> 'Cooldowns',
));
