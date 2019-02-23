<?php
/*
 * @title		com_vmcustom_thesisprinting
 * @version		1.0
 * @package		Joomla
 * @author		ekerner@ekerner.com
 * @website		http://www.ekerner.com
 * @license		Copyright (C) 2019 Creative Momentum All rights reserved.
 * @copyright		Copyright (C) 2019 Creative Momentum All rights reserved.
 */

defined('_JEXEC') or die('Restricted access');

$cwdpath = dirname(__FILE__);
$compath = is_dir($cwdpath . '/admin/helpers') ? $cwdpath . '/admin' : 
	JPATH_ADMINISTRATOR . '/components/com_vmcustom_thesisprinting';
require_once $compath . '/helpers/vmcustom_thesisprintingHelper.php';

class com_vmcustom_thesisprintingInstallerScript
{
	protected $dbname, $dbprefix, $db;

	public function __construct($adapter)
	{
		// set the db obect and prefix
		if (!class_exists('JConfig'))
			require(JPATH_CONFIGURATION . '/configuration.php');
		$cfg = new JConfig();
		$this->dbname = $cfg->db;
		$this->dbprefix = $cfg->dbprefix;
		$this->db = JFactory::getDbo();
	}

	public function install($adapter)
	{
		// TODO: create virtuemart products and variants if not exists - as per thesis printing requirements (specified)

		return true;
	}

	public function update($adapter)
	{
		return $this->install($adapter);
	}
 
	public function uninstall($adapter)
	{
		$tables = [];
		foreach ($tables as $table) {
			echo("Removing {$this->dbprefix}{$table} database table:<br>\n");
			$this->db->setQuery("DELETE IGNORE FROM {$this->dbprefix}{$table}");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query', true);
			$this->db->setQuery("DROP TABLE IF EXISTS {$this->dbprefix}{$table}");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query', true);
			echo("OK!<br><br>\n");
		}
	}

	private function tableExists($table_name)
	{
		$this->db->setQuery("SELECT COUNT(*) AS n FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND TABLE_NAME = '{$table_name}' LIMIT 1");
		$res = vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'loadResult');
		if (vmcustom_thesisprintingHelper::reportIfDbError())
			return true; // not continue if can query info schema
		return (int)$res;
	}

}
