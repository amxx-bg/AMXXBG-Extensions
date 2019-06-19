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

use xPaw\SourceQuery\SourceQuery;

/**
 * Server Monitoring main controller.
 */
class main_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var string Custom string for servers table */
	protected $servers_table;

	/** @var string Custom string for mods table */
	protected $mods_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config						$config				Config object
	 * @param \phpbb\controller\helper					$helper				Controller helper object
	 * @param \phpbb\template\template					$template			Template object
	 * @param \phpbb\language\language					$language			Language object
	 * @param \phpbb\db\driver\driver_interface 		$db					Database object
	 * @param \phpbb\user								$user				User object
	 * @param \evilsystem\amxxmonitoring\table			$mods_table			String
	 * @param \evilsystem\amxxmonitoring\table			$servers_table		String
	 */
	public function __construct(
		\phpbb\config\config $config, 
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template, 
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\user $user,
		$mods_table,
		$servers_table
	)
	{
		$this->config			= $config;
		$this->helper			= $helper;
		$this->template			= $template;
		$this->language			= $language;
		$this->request 			= $request;
		$this->db 				= $db;
		$this->user				= $user;
		$this->mods_table		= $mods_table;
		$this->servers_table	= $servers_table;
	}

	/**
	 * Controller handler for route /demo/{name}
	 *
	 * @param string $name
	 *
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function handle($name)
	{
		$renderer = null;

		switch($name) {
			case 'all': {

				/*! Prepare query */
				$sql = 'SELECT * FROM ' . $this->servers_table;
				
				/*! Execute query */
				$result = $this->db->sql_query($sql);
				$counter = 0;

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

				/*! Render the template */
				$renderer = $this->helper->render('amxxmonitoring_body.html', $name);
				break;
			}

			case 'add': {

				/*! If is user registered */	
				if($this->user->data['is_registered']) {
					/*! Add CSRF */
					add_form_key('amxxmonitoring_add');

					$errors = array();

					/*! Query for getting modifications */
					$sql = 'SELECT * FROM ' . $this->mods_table;

					$result = $this->db->sql_query($sql);

					/*! Get every mod into block var */
					while($row = $this->db->sql_fetchrow($result)) {
						$this->template->assign_block_vars('mods', array(
							'MOD_NAME'	=> $row['mod_name'],
						));
					}
					
					/*! Check if request is post */
					if($this->request->is_set_post('submit')) {

						$find = array(
							'mod_name' => $this->request->variable('server_mod', ''),
						);

						$check = array(
							'amxxmonitoring_ip' 	=> $this->request->variable('server_ip', ''),
							'amxxmonitoring_port' 	=> $this->request->variable('server_port', ''),
						);
						
						// Test if the submitted form is valid
						if (!check_form_key('amxxmonitoring_add'))
						{
							$errors[] = $this->language->lang('FORM_INVALID');
						}

						$sql = 'SELECT * FROM '. $this->servers_table .' WHERE '. $this->db->sql_build_array('SELECT', $check);

						/*! Execute Query */
						$result = $this->db->sql_query($sql);
						$row = $this->db->sql_fetchrow($result);

						/*! Check if the server exists in db */
						if($row) {
							$errors[] = $this->language->lang('SERVER_ALREADY_IN_DB', $row['amxxmonitoring_ip'], $row['amxxmonitoring_port']);
						}
						
						/*! Release */
						$this->db->sql_freeresult($result);

						/*! Get mod ID */
						$sql = 'SELECT mod_id FROM ' . $this->mods_table . ' WHERE '. $this->db->sql_build_array('SELECT', $find);

						$result = $this->db->sql_query($sql);
						$row = $this->db->sql_fetchrow($result);

						/*! Get Mod ID */
						$mod_id = $row['mod_id'];

						/*! Release */

						$this->db->sql_freeresult($result);
						
						if(filter_var($this->request->variable('server_ip', ''), FILTER_VALIDATE_IP)) {
							/*! Try connecting to the server */
							$query = new SourceQuery();

							$query->Connect($this->request->variable('server_ip', ''), $this->request->variable('server_port', ''), 1, SourceQuery::GOLDSOURCE);
							$serverInfo = $query->GetInfo();

							if(!$serverInfo)
								$errors[] = $this->language->lang('SERVER_CANNOT_CONNECT', $row['amxxmonitoring_ip'], $row['amxxmonitoring_port']);
							
						} else
							$errors[] = $this->language->lang('FORM_INVALID');

						/*! Check if no errors are met */
						if(empty($errors)) {

							/*! Prepare Data */
							$data = array(
								'amxxmonitoring_ip' 		=> $this->request->variable('server_ip', ''),
								'amxxmonitoring_port' 		=> $this->request->variable('server_port', ''),
								'amxxmonitoring_mod_id'		=> $mod_id,
								'amxxmonitoring_user_id'	=> $this->user->data['user_id'],
								'amxxmonitoring_name'		=> $serverInfo['HostName'],
								'amxxmonitoring_map'		=> $serverInfo['Map'],
								'amxxmonitoring_players'	=> $serverInfo['Players'],
								'amxxmonitoring_slots'		=> $serverInfo['MaxPlayers']
							);

							/*! Form query */
							$sql = 'INSERT INTO '. $this->servers_table .' ' . $this->db->sql_build_array('INSERT', $data);

							/*! Execute Query */
							$result = $this->db->sql_query($sql);

							/*! Redirect after 3 seconds if no action is taken */
							meta_refresh(3, $this->helper->route('evilsystem_amxxmonitoring_controller', array('name' => 'all', 'server_ip' => $this->request->variable('server_ip', ''))));
							$message = $this->language->lang('AMXXMONITORING_SERVER_ADDED') . '<br /><br />' . $this->language->lang('AMXXMONITORING_RETURN', '<a href="' . $this->helper->route('evilsystem_amxxmonitoring_controller', array('name' => 'all')) . '">', '</a>');
							trigger_error($message);
						}

						$s_errors = !empty($errors);
						
						$this->template->assign_vars(array(
							'S_ERROR'		=> $s_errors,
							'ERROR_MSG'		=> $s_errors ? implode('<br />', $errors) : '',
						));
					}

					/*! Render Page */
					$renderer = $this->helper->render('amxxmonitoring_add.html', $name);
				} else

					/*! User is not registered, redirect to all servers if he attempts to get to /servers/add by url */
					redirect($this->helper->route('evilsystem_amxxmonitoring_controller', array('name' => 'all')));
	
				break;
			}
		}

		/*! Return the page */
		return $renderer;
	}
}
