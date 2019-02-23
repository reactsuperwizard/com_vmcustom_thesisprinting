<?php
/**
* @package   com_actionlist
* @copyright Copyright (C) 2009-2010 Joomlaextensions.co.in All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');

class Tableuniversity extends JTable
{
		var	$id					= null;
		var	$university_name			= null;
		var	$logo1			= null;
		var	$logo2 		= null;
		var	$color1			= null;
		var	$color2 		= null;
		var	$name_format			= null;
		var	$spine_format 		= null;
		
		
	function Tableuniversity(& $db)
	{
	  	$this->_table_prefix = '#__vmcustom_thesisprinting_';
		parent::__construct($this->_table_prefix.'universities', 'id', $db);
        }

	function bind($array, $ignore = '')
	{	//echo '<pre>';print_r($array);exit;
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}
		return parent::bind($array,$ignore);
	}
}
?>
