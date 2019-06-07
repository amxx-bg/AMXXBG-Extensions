<?php
/**
 *
 * Server Monitoring. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\amxxmonitoring\acp;

/**
 * Server Monitoring ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\evilsystem\amxxmonitoring\acp\main_module',
			'title'		=> 'ACP_AMXXMONITORING_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_AMXXMONITORING_ADD_MOD',
					'auth'	=> 'ext_evilsystem/amxxmonitoring && acl_a_board',
					'cat'	=> array('ACP_AMXXMONITORING_TITLE')
				),
			),
		);
	}
}
