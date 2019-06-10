<?php
/**
 *
 * Forum Extras. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil, http://github.com/stfkolev
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\forumextras\controller;

/**
 * Forum Extras ACP controller.
 */
class acp_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\config\config		$config		Config object
	 * @param \phpbb\language\language	$language	Language object
	 * @param \phpbb\log\log			$log		Log object
	 * @param \phpbb\request\request	$request	Request object
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\user				$user		User object
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\language\language $language, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->config	= $config;
		$this->language	= $language;
		$this->log		= $log;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
	}

	/**
	 * Display the options a user can configure for this extension.
	 *
	 * @return void
	 */
	public function display_cooldowns()
	{
		// Add our common language file
		$this->language->add_lang('common', 'evilsystem/forumextras');

		// Create a form key for preventing CSRF attacks
		add_form_key('cooldown_acp');

		// Create an array to collect errors that will be output to the user
		$errors = array();

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			// Test if the submitted form cooldown_acp valid
			if (!check_form_key('cooldown_acp'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			// If no errors, process the form data
			if (empty($errors))
			{
				// Set the options the user configured
				$this->config->set('extras_cooldown', $this->request->variable('acp_cooldown', 0));

				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_FORUMEXTRAS_SETTINGS');

				// Option settings have been updated and logged
				// Confirm this to the user and provide link back to previous page
				trigger_error($this->language->lang('ACP_FORUMEXTRAS_SETTING_SAVED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);

		// Set output variables for display in the template
		$this->template->assign_vars(array(
			'S_ERROR'		=> $s_errors,
			'ERROR_MSG'		=> $s_errors ? implode('<br />', $errors) : '',

			'U_ACTION'		=> $this->u_action,
			'S_COOLDOWN'	=> $this->config->offsetGet('extras_cooldown'),
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
