<?php
/**
 *
 * Server Monitoring. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil
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

	'ACP_AMXXMONITORING_ADD_TITLE'				=> 'Add your server',
	'ACP_AMXXMONITORING_SETTING_SAVED'			=> 'Settings have been saved successfully!',

	'AMXXMONITORING_PAGE'						=> 'Servers',
	'VIEWING_EVILSYSTEM_AMXXMONITORING'			=> 'Viewing Server Monitoring page',

	'AMXXMONITORING_SERVER_IP'					=> 'Server IP Address',
	'AMXXMONITORING_SERVER_IP_DESC'				=> 'Get it from <a href="http://whatismyip.com" target="_blank"><strong>WhatIsMyIP</strong></a> and paste it here',

	'AMXXMONITORING_SERVER_PORT'				=> 'Server Port',
	'AMXXMONITORING_SERVER_PORT_DESC'			=> 'Your opened port for the server',

	'AMXXMONITORING_SERVER_MOD'					=> 'Server Mod',
	'AMXXMONITORING_SERVER_MOD_DESC'			=> 'Your server modification',

	'AMXXMONITORING_SERVER_ADDED'				=> 'Your server has been added to our database successfully!',
	'AMXXMONITORING_RETURN'						=> '%sReturn to all servers%s',

	/** ACP */
	'ACP_AMXXMONITORING_MOD_NAME'				=> 'Mod name',

	/*! Errors */
	'SERVER_ALREADY_IN_DB'						=> 'The server with IP %s and port %s is already in our database!',
	'SERVER_CANNOT_CONNECT'						=> 'Could not connect to server with IP %s and port %s!',
	'NO_SERVERS_ATM'							=> 'Currently there are no servers in our database!',

	/*! Page Language */
	'AMXXMONITORING_SERVERS_COUNT'				=> '%d servers',
	'AMXXMONITORING_ADD_SERVER'					=> 'Add Server',
	'AMXXMONITORING_PAGINATION'					=> 'Page <strong>%d</strong> of <strong>%d</strong>',

	/*! Servers Table (Main Page) */
	'AMXXMONITORING_TABLE_SERVERNAME'			=> 'Server Name',
	'AMXXMONITORING_TABLE_IP_PORT'				=> 'IP:Port',
	'AMXXMONITORING_TABLE_PLAYERS'				=> 'Players',
	'AMXXMONITORING_TABLE_MAP'					=> 'Current Map',
	'AMXXMONITORING_TABLE_MOD'					=> 'Mod',
));
