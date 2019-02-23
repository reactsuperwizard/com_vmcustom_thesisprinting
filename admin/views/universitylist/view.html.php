<?php
/**
* @package   com_actionlist
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );


jimport( 'joomla.application.component.view' );
 
class vmcustom_thesisprintingViewuniversitylist extends JViewLegacy
{
	function __construct( $config = array())
	{
		 parent::__construct( $config );
	}
    
	function display($tpl = null)
	{	
	
		$mainframe = JFactory::getApplication();
		$context='';
		
		$document =  JFactory::getDocument();
		$document->setTitle( JText::_('universitylist') );
   		 
   		JToolBarHelper::title(   JText::_( 'UNIVERSITY_LIST' ) );   		
   		
 		JToolBarHelper::addNew();
 		JToolBarHelper::editList();
		JToolBarHelper::deleteList();		
		//JToolBarHelper::publishList();
		//JToolBarHelper::unpublishList();
	   
	   	
		$uri	= JFactory::getURI();
		
		$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order', 'filter_order',  'ordering' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );
		$plan = $mainframe->getUserStateFromRequest( $context.'category','category',0 );
	 
		$lists['order'] 		= $filter_order;  
		$lists['order_Dir'] = $filter_order_Dir;
		
		$universities =  $this->get('Data');

		$db = JFactory::getDbo();
		foreach ($universities as &$uni) {
			foreach (['name', 'spine'] as $t) {
				$rec = &$uni->{$t.'_format'};
				if ($rec)
					$rec = $db->setQuery('SELECT '.$t.'_format FROM #__vmcustom_thesisprinting_'.$t.'_formats WHERE id = '.$rec.' LIMIT 1')->loadResult();
			}
		}
		
		//echo '<pre>';print_r($client);exit;
		$total			=  $this->get( 'Total');
		
		$pagination =  $this->get( 'Pagination' );
		
	
     	$this->assignRef('lists',		$lists);    
  		$this->assignRef('universities',		$universities); 		
    	$this->assignRef('pagination',	$pagination);
    	//$this->assignRef('request_url',	$uri->toString());
		$requesturl = $uri->toString();
        $this->assignRef('request_url', $requesturl);
    	
    	parent::display($tpl);
  }
    // ================================= For Ordering =======================================================//
	  protected function getSortFields(){
			return array(
				'ordering' => JText::_('JGRID_HEADING_ORDERING'),
				'published' => JText::_('JSTATUS'),
				'catparent' => JText::_('JCATPARENT'),
				'name' => JText::_('JGLOBAL_TITLE')
			);
		}
   
   // ================================= For Ordering =======================================================//	
}
?>
