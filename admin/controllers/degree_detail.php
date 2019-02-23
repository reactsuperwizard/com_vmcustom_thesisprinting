<?php
 /**
* @package   com_actionlist
* @copyright Copyright (C) 2016 - 2017 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/ 

defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.controller' );
jimport( 'joomla.filesystem.file' );

class vmcustom_ThesisPrintingControllerdegree_detail extends JControllerLegacy {

	
	function __construct($default = array()) {
		
		parent::__construct ( $default );
		$this->_table_prefix = '#__';
	
	
	}
	
	function edit() {
		JRequest::setVar ( 'view', 'degree_detail' );
		JRequest::setVar ( 'layout', 'default' );
		JRequest::setVar ( 'hidemainmenu', 1 );
		parent::display ();
	
	}
	function save() 
	{
		$app	= JFactory::getApplication();
		$post = JRequest::get ( 'post' );
		//echo '<pre>';print_r($post);exit;
		$option = JRequest::getVar('option','','request','string');
		$model = $this->getModel ( 'degree_detail' );
		$user 		= clone(JFactory::getUser());
		
		$id=JRequest::getVar('cid','','request','array');
		$post['id']=$id[0];
		$id = $model->store($post);
		
		if($id)
		{
			$msg = JText::_ ( 'Save successfullly' );
		}	
		else 
		{
			$msg = JText::_ ( 'Save successfullly' );
		}
		//$msg = JText::_ ( 'degree_detail_SAVED' );				
		$this->setRedirect('index.php?option='.$option.'&view=degreelist', $msg);
		
	}

	function cancel($key = NULL) {
		$option = JRequest::getVar('option','','request','string');
		$msg = JText::_ ( 'EDITING_CANCELLED' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=degreelist',$msg );
	}
	
	function remove() {
		
		$option = JRequest::getVar('option','','request','string');
		
	 $cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
	
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_DELETE' ) );
		}
		
		$model = $this->getModel ( 'degree_detail' );
		if (! $model->delete ( $cid )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'DELETED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=degreelist',$msg );
	}
	
}
?>