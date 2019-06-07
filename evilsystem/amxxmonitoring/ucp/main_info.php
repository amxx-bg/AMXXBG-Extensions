<?php
/**
 *
 * Server Monitoring. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\amxxmonitoring\ucp;

/**
 * Server Monitoring UCP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\evilsystem\amxxmonitoring\ucp\main_module',
			'title'		=> 'UCP_AMXXMONITORING_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'UCP_AMXXMONITORING',
					'auth'	=> 'ext_evilsystem/amxxmonitoring',
					'cat'	=> array('UCP_AMXXMONITORING_TITLE')
				),
			),
		);
	}
}
