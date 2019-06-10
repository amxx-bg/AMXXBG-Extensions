<?php
/**
 *
 * Forum Extras. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil, http://github.com/stfkolev
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\forumextras\acp;

/**
 * Forum Extras ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\evilsystem\forumextras\acp\main_module',
			'title'		=> 'ACP_FORUMEXTRAS_COOLDOWN_MENUITEM',
			'modes'		=> array(
				'cooldowns'	=> array(
					'title'	=> 'ACP_FORUMEXTRAS_COOLDOWN_MENUITEM',
					'auth'	=> 'ext_evilsystem/forumextras',
					'cat'	=> array('ACP_FORUMEXTRAS_COOLDOWN_MENUITEM')
				),
			),
		);
	}
}
