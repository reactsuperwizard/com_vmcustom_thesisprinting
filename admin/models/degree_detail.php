<?php
/**
* @package   com_actionlist
* @copyright Copyright (C) 2016 - 2017 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/  

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');

class  vmcustom_thesisprintingModeldegree_detail extends JModelLegacy
{
	var $_id = null;
	var $_data = null;
	var $_region = null;
	var $_table_prefix = null;
	var $_copydata	=	null;

	function __construct()
	{
		parent::__construct();
		$this->_table_prefix = '#__vmcustom_thesisprinting_';		
	  	$cid = JRequest::getVar('cid',  '', 'request', 'string');
		$this->setId($cid);
		
	}

	
	function setId($id)
	{
		$this->_id		= $id;
		$this->_data	= null;
	}
	function getData()
	{
	
		if ($this->_loadData())
		{
			
		}else  $this->_initData();
		return $this->_data;
	}
	 
	
	function _loadData()
	{	
		$cid = JRequest::getVar('cid','');
		
		if($cid != '')
		{
			if (empty($this->_data))
			{
				$query = 'SELECT * FROM '.$this->_table_prefix.'degrees where id='.$cid[0]; 
				$this->_db->setQuery($query);
				$this->_data = $this->_db->loadObject();
				//$this->_data=NULL;
				return (boolean) $this->_data;
			}
			return true;
		}
	}
	
	
	function _initData()
	{
		if (empty($this->_data))
		{
			$detail = new stdClass();
			
			$detail->id= 0;
			$detail->degree_name= null;
			
			
			
			$this->_data = $detail;
			return (boolean) $this->_data;
		}
		return true;
	}
	
  	function store($data)
	{ 
		//echo '<pre>';print_r($data);exit;
		$row =$this->getTable('degree');
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $row->id;
	}
	
	function delete($cid = array())
	{
		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			
			 $query = 'DELETE FROM '.$this->_table_prefix.'degrees WHERE id IN ( '.$cids.' )';
		
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}	

	
}
?>
