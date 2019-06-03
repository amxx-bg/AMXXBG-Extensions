<?php
/**
 *
 * Example. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, example
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace Example\example\acp;

/**
 * Example ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\Example\example\acp\main_module',
			'title'		=> 'ACP_EXAMPLE_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_EXAMPLE',
					'auth'	=> 'ext_Example/example && acl_a_new_Example_example',
					'cat'	=> array('ACP_EXAMPLE_TITLE')
				),
			),
		);
	}
}
