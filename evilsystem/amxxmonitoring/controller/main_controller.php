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

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config		$config		Config object
	 * @param \phpbb\controller\helper	$helper		Controller helper object
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\language\language	$language	Language object
	 */
	public function __construct(
		\phpbb\config\config $config, 
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template, 
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\user $user
		)
	{
		$this->config		= $config;
		$this->helper		= $helper;
		$this->template		= $template;
		$this->language		= $language;
		$this->request 		= $request;
		$this->db 			= $db;
		$this->user			= $user;
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
		global $db;
		$renderer = null;

		switch($name) {
			case 'all': {

				$sql = 'SELECT * FROM `phpbb_evilsystem_amxxmonitoring_table`';
				
				$result = $db->sql_query($sql);
				$counter = 0;

				while($row = $db->sql_fetchrow($result)) {
					$sql = 'SELECT mod_name FROM phpbb_evilsystem_amxxmonitoring_mods WHERE mod_id = '. $row['amxxmonitoring_mod_id'];   
					$mod = $db->sql_fetchrow($db->sql_query($sql));


					$this->template->assign_block_vars('server', array(
						'SERVER_NAME'		=> $db->sql_escape($row['amxxmonitoring_name']),
						'SERVER_IP'			=> $row['amxxmonitoring_ip'],
						'SERVER_PORT'		=> $row['amxxmonitoring_port'],
						'SERVER_MAP'		=> $db->sql_escape($row['amxxmonitoring_map']),
						'SERVER_PLAYERS'	=> $db->sql_escape($row['amxxmonitoring_players']),
						'SERVER_SLOTS'		=> $db->sql_escape($row['amxxmonitoring_slots']),
						'SERVER_MOD'		=> $mod['mod_name'],
					));

					$counter++;
				}

				$this->template->assign_vars(array(
					'SERVERS_COUNT' 	=> $counter,
				));

				$renderer = $this->helper->render('amxxmonitoring_body.html', $name);
				break;
			}

			case 'add': {	

				add_form_key('amxxmonitoring_add');

				$errors = array();

				$sql = 'SELECT * FROM phpbb_evilsystem_amxxmonitoring_mods';

				$result = $db->sql_query($sql);

				
				while($row = $db->sql_fetchrow($result)) {
					$this->template->assign_block_vars('mods', array(
						'MOD_NAME'	=> $row['mod_name'],
					));
				}
				
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

					$sql = 'SELECT * FROM phpbb_evilsystem_amxxmonitoring_table WHERE '. $db->sql_build_array('SELECT', $check);

					/*! Execute Query */
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);

					/*! Check if the server exists in db */
					if($row) {
						$errors[] = $this->language->lang('SERVER_ALREADY_IN_DB', $row['amxxmonitoring_ip'], $row['amxxmonitoring_port']);
					}
					
					/*! Release */
					$db->sql_freeresult($result);

					/*! Get mod ID */
					$sql = 'SELECT mod_id FROM phpbb_evilsystem_amxxmonitoring_mods WHERE '. $db->sql_build_array('SELECT', $find);

					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);

					/*! Get Mod ID */
					$mod_id = $row['mod_id'];

					/*! Release */

					$db->sql_freeresult($result);
					
					if(filter_var($this->request->variable('server_ip', ''), FILTER_VALIDATE_IP)) {
						/*! Try connecting to the server */
						$query = new SourceQuery();

						$query->Connect($this->request->variable('server_ip', ''), $this->request->variable('server_port', ''), 1, SourceQuery::GOLDSOURCE);
						$serverInfo = $query->GetInfo();

						if(!$serverInfo)
							$errors[] = $this->language->lang('SERVER_CANNOT_CONNECT', $row['amxxmonitoring_ip'], $row['amxxmonitoring_port']);
						
					} else
						$errors[] = $this->language->lang('FORM_INVALID');

					if(empty($errors)) {
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

						$sql = 'INSERT INTO phpbb_evilsystem_amxxmonitoring_table ' . $db->sql_build_array('INSERT', $data);

						$result = $db->sql_query($sql);

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

				$renderer = $this->helper->render('amxxmonitoring_add.html', $name);
				break;
			}
		}

		return $renderer;
	}
}
