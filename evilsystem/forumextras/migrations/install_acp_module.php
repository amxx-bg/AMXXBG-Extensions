<?php
/**
 *
 * Forum Extras. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil, http://github.com/stfkolev
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\forumextras\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{

    public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'acp'
				AND module_langname = 'ACP_FORUMEXTRAS_COOLDOWN_MENUITEM'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

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
				'ACP_FORUMEXTRAS_COOLDOWN_MENUITEM'
			)),
			array('module.add', array(
				'acp',
				'ACP_FORUMEXTRAS_COOLDOWN_MENUITEM',
				array(
					'module_basename'	=> '\evilsystem\forumextras\acp\main_module',
					'modes'				=> array('cooldowns'),
				),
			)),
		);
	}
}
