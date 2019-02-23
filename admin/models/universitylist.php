<?php
/**
* @package   com_actionlist
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined ('_JEXEC') or die ('Restricted access');

 
jimport('joomla.application.component.model');

class Vmcustom_thesisprintingModeluniversitylist extends JModelLegacy
{
	var $_data = null;
	var $_total = null;
	var $_pagination = null;
	var $_table_prefix = null;
	
	function __construct()
	{
		parent::__construct();

		global $mainframe, $context; 
		$app = JFactory::getApplication();
		//print_r ($context);
		$context='clientid';
	  	$this->_table_prefix = '#__vmcustom_thesisprinting_';
					
		$limit			= $app->getUserStateFromRequest( $context.'limit', 'limit', $app->getCfg('list_limit'), 0);
		$limitstart = $app->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
		
		$state     = $app->getUserStateFromRequest( $context.'state','state',0);
		$filter     = $app->getUserStateFromRequest( $context.'filter','filter',0);
		
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		$this->setState('state', $state);
		$this->setState('filter', $filter);

	}
	function getData()
	{		
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}

		return $this->_data;
}
	function getTotal()
	{
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
  	
	function _buildQuery()
	{
	    $orderby	= $this->_buildContentOrderBy();
		$query = ' SELECT * FROM '.$this->_table_prefix.'universities'.$orderby;
		return $query;
	}
	
	function _buildContentOrderBy()
	{
		global $mainframe, $context;
		$app = JFactory::getApplication();
		$filter_order     = $app->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'ordering' );
		$filter_order_Dir = $app->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );		
					
		$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir;			
		 		
		return $orderby;
	}
	
	function getPersonname($uid)
	{
		$db = JFactory::getDbo();
		if($uid)
		{
			$query = "Select `fullName` from ".$this->_table_prefix.'userform where id='.$uid;
			$db->setQuery($query);
			return $name = $db->loadResult();
		}
	}
	
	function getparent($catid)
	{
		$db=  JFactory :: getDBO();
		
		$query = 'SELECT * FROM '.$this->_table_prefix.'account WHERE id='.$catid;
		
		$db->setQuery($query);
	
		return $db->loadObject();
	}
		// ================================= Ordering Function =======================================================//
		function saveorder(){
			$mainframe = JFactory::getApplication();
			$db = JFactory::getDBO();
			$cid = JRequest::getVar('cid', array(0), 'post', 'array');
			$total = count($cid);
			$order = JRequest::getVar('order', array(0), 'post', 'array');
			JArrayHelper::toInteger($order, array(0));
			$row = JTable::getInstance('account', 'Table');
			$groupings = array();
			for ($i = 0; $i < $total; $i++){
				$row->load((int)$cid[$i]);
				$groupings[] = $row->name;
				if ($row->ordering != $order[$i]){
					$row->ordering = $order[$i];
					if (!$row->store()){
						JError::raiseError(500, $db->getErrorMsg());
					}
				}
			}
		   
			$groupings = array_unique($groupings);
			foreach ($groupings as $group){
				$row->reorder('id = '.(int)$group);
			}
			$cache = JFactory::getCache('com_actionlist');
			$cache->clean();
			return true;
		}
	// ================================= End Ordering Function =======================================================//
}	

