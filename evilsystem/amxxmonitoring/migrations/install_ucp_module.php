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

class install_ucp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'ucp'
				AND module_langname = 'UCP_AMXXMONITORING_TITLE'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

	public static function depends_on()
	{
		return array('\evilsystem\amxxmonitoring\migrations\install_sample_schema');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'ucp',
				0,
				'UCP_AMXXMONITORING_TITLE'
			)),
			array('module.add', array(
				'ucp',
				'UCP_AMXXMONITORING_TITLE',
				array(
					'module_basename'	=> '\evilsystem\amxxmonitoring\ucp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
