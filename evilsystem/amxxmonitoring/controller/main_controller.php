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
		\phpbb\db\driver\driver_interface $db 
		)
	{
		$this->config	= $config;
		$this->helper	= $helper;
		$this->template	= $template;
		$this->language	= $language;
		$this->request = $request;
		$this->db = $db;
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

				var_dump(get_declared_classes());
				$query = new Query();
				$query->connect('45.76.9.20', 27022, 1, Query::SOURCE);

				var_dump($query->GetInfo());

				$sql = 'SELECT * FROM `phpbb_evilsystem_amxxmonitoring_table`';
				
				$result = $db->sql_query($sql);
				$counter = 0;

				while($row = $db->sql_fetchrow($result)) {
					$sql = 'SELECT mod_name FROM phpbb_evilsystem_amxxmonitoring_mods WHERE mod_id = '. $row['amxxmonitoring_mod_id'];   
					$mod = $db->sql_fetchrow($db->sql_query($sql));


					$this->template->assign_block_vars('server', array(
						'SERVER_NAME'	=> $db->sql_escape($row['amxxmonitoring_name']),
						'SERVER_IP'		=> $row['amxxmonitoring_ip'],
						'SERVER_PORT'	=> $row['amxxmonitoring_port'],
						'SERVER_MOD'	=> $mod['mod_name'],
					));

					$counter++;
				}

				$this->template->assign_vars(array(
					'SERVERS_COUNT' => $counter,
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

					$result = $db->sql_query($sql);

					$row = $db->sql_fetchrow($result);

					if($row) {
						$errors[] = $this->language->lang('SERVER_ALREADY_IN_DB', $row['amxxmonitoring_ip'], $row['amxxmonitoring_port']);
					}
					
					$db->sql_freeresult($result);

					/*! Get mod ID */
					$sql = 'SELECT mod_id FROM phpbb_evilsystem_amxxmonitoring_mods WHERE '. $db->sql_build_array('SELECT', $find);

					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);

					$mod_id = $row['mod_id'];

					$db->sql_freeresult($result);

					if(empty($errors)) {
						$data = array(
							'amxxmonitoring_ip' 		=> $this->request->variable('server_ip', ''),
							'amxxmonitoring_port' 		=> $this->request->variable('server_port', ''),
							'amxxmonitoring_mod_id'		=> $mod_id,
						);

						$sql = 'INSERT INTO phpbb_evilsystem_amxxmonitoring_table ' . $db->sql_build_array('INSERT', $data);

						$result = $db->sql_query($sql);
						
						var_dump($result);

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
