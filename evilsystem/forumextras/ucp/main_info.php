<?php
/**
 *
 * Forum Extras. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil, http://github.com/stfkolev
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\forumextras\ucp;

/**
 * Forum Extras UCP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\evilsystem\forumextras\ucp\main_module',
			'title'		=> 'UCP_FORUMEXTRAS',
			'modes'		=> array(
				'addpoints'	=> array(
					'title'	=> 'UCP_FORUMEXTRAS_ADDPOINTS',
					'auth'	=> 'ext_evilsystem/forumextras',
					'cat'	=> array('UCP_FORUMEXTRAS_ADDPOINTS')
				),
				'changerank'	=> array(
					'title'	=> 'UCP_FORUMEXTRAS_CHANGERANK',
					'auth'	=> 'ext_evilsystem/forumextras',
					'cat'	=> array('UCP_FORUMEXTRAS_CHANGERANK')
				),
				'changeusername'	=> array(
					'title'	=> 'UCP_FORUMEXTRAS_CHANGENICK',
					'auth'	=> 'ext_evilsystem/forumextras',
					'cat'	=> array('UCP_FORUMEXTRAS_CHANGENICK')
				),
			),
		);
	}
}
