<?php
/*
 * @title		com_vmcustom_thesisprinting
 * @version		1.0
 * @package		Joomla
 * @author		ekerner@ekerner.com
 * @website		http://www.ekerner.com
 * @license		Copyright (C) 2018 Gold Creative Services All rights reserved.
 * @copyright		Copyright (C) 2018 Gold Creative Services All rights reserved.
 */

defined('_JEXEC') or die('Restricted access');

$cwdpath = dirname(__FILE__);
$compath = is_dir($cwdpath . '/admin/helpers') ? $cwdpath . '/admin' : 
	JPATH_ADMINISTRATOR . '/components/com_vmcustom_thesisprinting';
require_once $compath . '/helpers/vmcustom_thesisprintingHelper.php';
require_once $compath . '/helpers/File_CSV_DataSource.php';

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
		// create institutes db table ...
		/*$institutes_table = "{$this->dbprefix}vmcustom_thesisprinting_institutes";
		if (!$this->tableExists($institutes_table)) {
			echo("Creating {$institutes_table} database table:<br>\n");
			$this->db->setQuery("
				CREATE TABLE {$institutes_table} (
					institute_id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
					logo1_id INT(1) UNSIGNED,
					FOREIGN KEY (logo1_id) REFERENCES {$this->dbprefix}virtuemart_medias(virtuemart_media_id) ON DELETE SET NULL,
					logo2_id INT(1) UNSIGNED,
					FOREIGN KEY (logo2_id) REFERENCES {$this->dbprefix}virtuemart_medias(virtuemart_media_id) ON DELETE SET NULL,
					institute VARCHAR(256) NOT NULL,
					CONSTRAINT UNIQUE (institute),
					color1 VARCHAR(32) DEFAULT '#000000',
					color2 VARCHAR(32) DEFAULT '#111111',
					spine_layout TINYINT DEFAULT 1
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci
			");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query');
			if (vmcustom_thesisprintingHelper::reportIfDbError()) {
				echo("Failed!<br><br>\n");
				return false;
			}
			echo("OK!<br><br>\n");
		}
*/
		// create courses db table ...
		/*$courses_table = "{$this->dbprefix}vmcustom_thesisprinting_courses";
		if (!$this->tableExists($courses_table)) {
			echo("Creating {$courses_table} database table:<br>\n");
			$this->db->setQuery("
				CREATE TABLE {$courses_table} (
					course_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
					course_title VARCHAR(256) NOT NULL,
					CONSTRAINT UNIQUE (course_title),
					course_desc VARCHAR(256)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci
			");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query');
			if (vmcustom_thesisprintingHelper::reportIfDbError()) {
				echo("Failed!<br><br>\n");
				return false;
			}
			echo("OK!<br><br>\n");
		}*/

		// TODO: create virtuemart products and variants if not exists - as per thesis printing requirements (specified)

		return true;
	}

	public function update($adapter)
	{
		return $this->install($adapter);
	}
 
	public function uninstall($adapter)
	{
		// drop tables ...
		/*$tables = array(
			'vmcustom_thesisprinting_courses',
			'vmcustom_thesisprinting_institutes'
		);
		foreach ($tables as $table) {
			echo("Removing {$this->dbprefix}{$table} database table:<br>\n");
			$this->db->setQuery("DELETE IGNORE FROM {$this->dbprefix}{$table}");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query', true);
			$this->db->setQuery("DROP TABLE IF EXISTS {$this->dbprefix}{$table}");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query', true);
			echo("OK!<br><br>\n");
		}*/
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
