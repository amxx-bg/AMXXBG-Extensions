<?php
/**
 *
 * Server Monitoring. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\amxxmonitoring\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_AMXXMONITORING_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_AMXXMONITORING_TITLE',
				array(
					'module_basename'	=> '\evilsystem\amxxmonitoring\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
