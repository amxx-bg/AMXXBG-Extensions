<?php
/**
 *
 * Example. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, example
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace Example\example\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['example_example_goodbye']);
	}

	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('example_example_goodbye', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_EXAMPLE_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_EXAMPLE_TITLE',
				array(
					'module_basename'	=> '\Example\example\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
