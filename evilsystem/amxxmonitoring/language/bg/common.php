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

	'ACP_AMXXMONITORING_ADD_TITLE'				=> 'Добави твоят сървър',
	'ACP_AMXXMONITORING_SETTING_SAVED'			=> 'Настройките са запазени успешно!',

	'AMXXMONITORING_PAGE'						=> 'Сървъри',
	'VIEWING_EVILSYSTEM_AMXXMONITORING'			=> 'Разглежда страницата Сървъри',

	'AMXXMONITORING_SERVER_IP'					=> 'IP Адрес на сървъра',
	'AMXXMONITORING_SERVER_IP_DESC'				=> 'Вземи го от <a href="http://whatismyip.com" target="_blank"><strong>WhatIsMyIP</strong></a> и го постави тук',

	'AMXXMONITORING_SERVER_PORT'				=> 'Порт на сървъра',
	'AMXXMONITORING_SERVER_PORT_DESC'			=> 'Портът, на който работи вашият сървър',

	'AMXXMONITORING_SERVER_MOD'					=> 'Сървърна Модификация',
	'AMXXMONITORING_SERVER_MOD_DESC'			=> 'Сървърната модификация',

	'AMXXMONITORING_SERVER_ADDED'				=> 'Вашият сървър бе добавен към базата ни от данни!',
	'AMXXMONITORING_RETURN'						=> '%sВърнете се при всички сървъри%s',

	/** ACP */
	'ACP_AMXXMONITORING_MOD_NAME'				=> 'Име на модификацията',

	/*! Errors */
	'SERVER_ALREADY_IN_DB'						=> 'Сървърът, който е с IP адрес %s и порт %s е вече в базата ни от данни!',
	'SERVER_CANNOT_CONNECT'						=> 'Не можахме да се свържем към сървъра с IP адрес %s и порт %s!',
	'NO_SERVERS_ATM'							=> 'В момента няма сървъри добавени в базата ни от данни!',

	/*! Page Language */
	'AMXXMONITORING_SERVERS_COUNT'				=> '%d сървъра',
	'AMXXMONITORING_ADD_SERVER'					=> 'Добави сървър',
	'AMXXMONITORING_PAGINATION'					=> 'Страница <strong>%d</strong> от <strong>%d</strong>',

	/*! Servers Table (Main Page) */
	'AMXXMONITORING_TABLE_SERVERNAME'			=> 'Име на сървъра',
	'AMXXMONITORING_TABLE_IP_PORT'				=> 'IP:Порт',
	'AMXXMONITORING_TABLE_PLAYERS'				=> 'Играчи',
	'AMXXMONITORING_TABLE_MAP'					=> 'Текуща карта',
	'AMXXMONITORING_TABLE_MOD'					=> 'Модификация',
));
