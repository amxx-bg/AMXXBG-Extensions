<?php
/**
 *
 * Server Monitoring. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Evil
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\amxxmonitoring\migrations;

class install_sample_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('evilsystem_amxxmonitoring_sample_int');
	}

	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	/**
	 * Add, update or delete data stored in the database during extension installation.
	 *
	 * https://area51.phpbb.com/docs/dev/3.2.x/migrations/data_changes.html
	 *  config.add: Add config data.
	 *  config.update: Update config data.
	 *  config.remove: Remove config.
	 *  config_text.add: Add config_text data.
	 *  config_text.update: Update config_text data.
	 *  config_text.remove: Remove config_text.
	 *  module.add: Add a new CP module.
	 *  module.remove: Remove a CP module.
	 *  permission.add: Add a new permission.
	 *  permission.remove: Remove a permission.
	 *  permission.role_add: Add a new permission role.
	 *  permission.role_update: Update a permission role.
	 *  permission.role_remove: Remove a permission role.
	 *  permission.permission_set: Set a permission to Yes or Never.
	 *  permission.permission_unset: Set a permission to No.
	 *  custom: Run a callable function to perform more complex operations.
	 *
	 * @return array Array of data update instructions
	 */
	public function update_data()
	{
		return array(
			// Add new permissions
			array('permission.add', array('a_new_evilsystem_amxxmonitoring')), // New admin permission
			array('permission.add', array('m_new_evilsystem_amxxmonitoring')), // New moderator permission
			array('permission.add', array('u_new_evilsystem_amxxmonitoring')), // New user permission

			// array('permission.add', array('a_copy', true, 'a_existing')), // New admin permission a_copy, copies permission settings from a_existing

			// Set our new permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_new_evilsystem_amxxmonitoring')), // Give ROLE_ADMIN_FULL a_new_evilsystem_amxxmonitoring permission
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_new_evilsystem_amxxmonitoring')), // Give ROLE_USER_FULL u_new_evilsystem_amxxmonitoring permission
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_new_evilsystem_amxxmonitoring')), // Give ROLE_USER_STANDARD u_new_evilsystem_amxxmonitoring permission
			array('permission.permission_set', array('REGISTERED', 'u_new_evilsystem_amxxmonitoring', 'group')), // Give REGISTERED group u_new_evilsystem_amxxmonitoring permission
			array('permission.permission_set', array('REGISTERED_COPPA', 'u_new_evilsystem_amxxmonitoring', 'group', false)), // Set u_new_evilsystem_amxxmonitoring to never for REGISTERED_COPPA

			// Add new permission roles
			array('permission.role_add', array('amxxmonitoring admin role', 'a_', 'a new role for admins')), // New role "amxxmonitoring admin role"
			array('permission.role_add', array('amxxmonitoring moderator role', 'm_', 'a new role for moderators')), // New role "amxxmonitoring moderator role"
			array('permission.role_add', array('amxxmonitoring user role', 'u_', 'a new role for users')), // New role "amxxmonitoring user role"

			// Call a custom callable function to perform more complex operations.
			array('custom', array(array($this, 'sample_callable_install'))),
		);
	}

	/**
	 * Add, update or delete data stored in the database during extension un-installation (purge step).
	 *
	 * IMPORTANT: Under normal circumstances, the changes performed in update_data will
	 * automatically be reverted during un-installation. This revert_data method is optional
	 * and only needs to be used to perform custom un-installation changes, such as to revert
	 * changes made by custom functions called in update_data.
	 *
	 * https://area51.phpbb.com/docs/dev/3.2.x/migrations/data_changes.html
	 *  config.add: Add config data.
	 *  config.update: Update config data.
	 *  config.remove: Remove config.
	 *  config_text.add: Add config_text data.
	 *  config_text.update: Update config_text data.
	 *  config_text.remove: Remove config_text.
	 *  module.add: Add a new CP module.
	 *  module.remove: Remove a CP module.
	 *  permission.add: Add a new permission.
	 *  permission.remove: Remove a permission.
	 *  permission.role_add: Add a new permission role.
	 *  permission.role_update: Update a permission role.
	 *  permission.role_remove: Remove a permission role.
	 *  permission.permission_set: Set a permission to Yes or Never.
	 *  permission.permission_unset: Set a permission to No.
	 *  custom: Run a callable function to perform more complex operations.
	 *
	 * @return array Array of data update instructions
	 */
	public function revert_data()
	{
		return array(
			array('custom', array(array($this, 'sample_callable_uninstall'))),
		);
	}

	/**
	 * A custom function for making more complex database changes
	 * during extension installation. Must be declared as public.
	 */
	public function sample_callable_install()
	{
		// Run some SQL queries on the database
	}

	/**
	 * A custom function for making more complex database changes
	 * during extension un-installation. Must be declared as public.
	 */
	public function sample_callable_uninstall()
	{
		// Run some SQL queries on the database
	}
}
