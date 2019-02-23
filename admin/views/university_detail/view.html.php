<?php
/**
* @package   com_actionlist
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/defined( '_JEXEC' ) or die( 'Restricted access' );


jimport( 'joomla.application.component.view' );

class  vmcustom_thesisprintingViewuniversity_detail extends JViewLegacy
{
	function display($tpl = null)
	{
		$document =  JFactory::getDocument();
		$document->setTitle( JText::_('university_detail') );

		$uri 		= JFactory::getURI();
		
		$option = JRequest::getVar('option','','request','string');
		
		$this->setLayout('default');

		$db = JFactory::getDbo();
		$lists = [
			'name_formats' => $db->setQuery('SELECT * FROM #__vmcustom_thesisprinting_name_formats')->loadAssocList(),
			'spine_formats' => $db->setQuery('SELECT * FROM #__vmcustom_thesisprinting_spine_formats')->loadAssocList()
		];
		$detail	= $this->get('Data');
		$isNew		= ($detail->id < 1);

		$text = $isNew ? JText::_( 'NEW' ) : JText::_( 'EDIT' );
		JToolBarHelper::title(   JText::_( 'DETAIL_PAGE' ).': <small><small>[ ' . $text.' ]</small></small>' );
	
		 
		//JToolbarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
		
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		 
		$usertype = $this->get('usertype');
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('details',		$detail);
		//$this->assignRef('request_url',	$uri->toString());
		$requesturl = $uri->toString();
		$this->assignRef('request_url', $requesturl);

		parent::display($tpl);
	}
	
}
?>
