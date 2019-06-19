<?php
/**
 *
 * Trouble 1337. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Test
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace evilsystem\amxxmonitoring\cron\task;

use xPaw\SourceQuery\SourceQuery;

/**
 * Refresh servers cron task.
 */
class servers extends \phpbb\cron\task\base
{
	/**
	 * How often we run the cron (in seconds).
	 * @var int
	 */
	protected $cron_frequency = 300;

	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config $config Config object
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return void
	 */
	public function run()
	{
        // Run your cron actions here...
		global $db, $phpbb_container;
		
		$servers_table = $phpbb_container->getParameter('evilsystem.amxxmonitoring.table.evilsystem_amxxmonitoring_table');

        $query = new SourceQuery();

        $sql = 'SELECT * FROM ' . $servers_table;

        $result = $db->sql_query($sql);
        
        while($row = $db->sql_fetchrow($result)) {
            $query->Connect($row['amxxmonitoring_ip'], $row['amxxmonitoring_port'], 1, SourceQuery::GOLDSOURCE);

            $serverInfo = $query->GetInfo();

            if($serverInfo) {
                $data = array(
                    'amxxmonitoring_name'		=> $serverInfo['HostName'],
                    'amxxmonitoring_map'		=> $serverInfo['Map'],
                    'amxxmonitoring_players'	=> $serverInfo['Players'],
                    'amxxmonitoring_slots'		=> $serverInfo['MaxPlayers']
                );

                $sql = 'UPDATE'. $servers_table .' SET ' . $db->sql_build_array('UPDATE', $data);

                $db->sql_query($sql);
            }
        }

        $db->sql_freeresult($result);


		// Update the cron task run time here if it hasn't
		// already been done by your cron actions.
		$this->config->set('amxxmonitoring_cron_last_run', time(), false);
	}

	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * For example, a cron task that prunes forums can only run when
	 * forum pruning is enabled.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return true;
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run.
	 *
	 * @return bool
	 */
	public function should_run()
	{
		return $this->config['amxxmonitoring_cron_last_run'] < time() - $this->cron_frequency;
	}
}
