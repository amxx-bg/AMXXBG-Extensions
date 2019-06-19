<?php
/**
 *
 * Server Monitoring. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\amxxmonitoring\controller;

/**
 * Server Monitoring UCP controller.
 */
class ucp_controller
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string Custom form action */
	protected $u_action;

	/** @var string Custom string for servers table */
	protected $servers_table;

	/** @var string Custom string for mods table */
	protected $mods_table;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\db\driver\driver_interface			$db					Database object
 	 * @param \phpbb\language\language					$language			Language object
 	 * @param \phpbb\request\request					$request			Request object
	 * @param \phpbb\template\template					$template			Template object
	 * @param \phpbb\user								$user				User object
	 * @param \evilsystem\amxxmonitoring\table			$mods_table			String
	 * @param \evilsystem\amxxmonitoring\table			$servers_table		String
	 */
	public function __construct(
		\phpbb\db\driver\driver_interface $db, 
		\phpbb\language\language $language, 
		\phpbb\request\request $request, 
		\phpbb\template\template $template, 
		\phpbb\user $user,
		$mods_table,
		$servers_table
	)
	{
		$this->db				= $db;
		$this->language			= $language;
		$this->request			= $request;
		$this->template			= $template;
		$this->user				= $user;
		$this->mods_table		= $mods_table;
		$this->servers_table 	= $servers_table;
	}

	/**
	 * Display the options a user can configure for this extension.
	 *
	 * @return void
	 */
	public function display_options()
	{
		// Request the options the user can configure
		$data = array(
			'amxxmonitoring_user_id' => $this->user->data['user_id'],
		);

		$sql = 'SELECT * FROM ' . $this->servers_table . ' WHERE ' . $this->db->sql_build_array('SELECT', $data);

		$result = $this->db->sql_query($sql);

		/*! Create blockvar */
		while($row = $this->db->sql_fetchrow($result)) {
			$sql = 'SELECT mod_name FROM '. $this->mods_table .' WHERE mod_id = '. $row['amxxmonitoring_mod_id'];   
			$mod = $this->db->sql_fetchrow($this->db->sql_query($sql));

			/*! Assign data to template */
			$this->template->assign_block_vars('server', array(
				'SERVER_NAME'		=> $this->db->sql_escape($row['amxxmonitoring_name']),
				'SERVER_IP'			=> $row['amxxmonitoring_ip'],
				'SERVER_PORT'		=> $row['amxxmonitoring_port'],
				'SERVER_MAP'		=> $this->db->sql_escape($row['amxxmonitoring_map']),
				'SERVER_PLAYERS'	=> $this->db->sql_escape($row['amxxmonitoring_players']),
				'SERVER_SLOTS'		=> $this->db->sql_escape($row['amxxmonitoring_slots']),
				'SERVER_MOD'		=> $mod['mod_name'],
			));

			/*! Servers counter */
			$counter++;
		}

		/*! Assing counter to template */
		$this->template->assign_vars(array(
			'SERVERS_COUNT' 	=> $counter,
		));
	}

	/**
	 * Set custom form action.
	 *
	 * @param string	$u_action	Custom form action
	 * @return void
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
