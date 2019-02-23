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

defined('_JEXEC') or die('Restricted access!');

class vmcustom_thesisprintingHelper
{
	protected static $admin_url;
	public static function admin_url()
	{
		if (!self::$admin_url)
			self::$admin_url = JRoute::_(JURI::root() . 'administrator/');
		return self::$admin_url;
	}

	protected static $dbo;
	public static function getDbo($dbo = null)
	{
		if ($dbo)
			return $dbo;
		if (!self::$dbo)
			self::$dbo = JFactory::getDbo();
		return self::$dbo;
	}

	public static $dbErrorMessage = '';

	public static function stupidJ3CatchDatabaseExecute($db, $cmd, $report = false) {
		self::$dbErrorMessage = '';
		try {
			$res = $db->$cmd();
			// legacy db error support
			if (method_exists($db, 'getErrorNum') && $db->getErrorNum())
				throw new Exception($db->getErrorMsg());
			return $res;
		} catch(Exception $e) {
			self::$dbErrorMessage = $e->getMessage();
			if ($report)
				self::reportIfDbError();
			return false;
		}
	}

	public static function reportIfDbError()
	{
		if (self::$dbErrorMessage) {
			JFactory::getApplication()->enqueueMessage(self::$dbErrorMessage, 'error');
			return true;
		}
	}

	public static function addSubmenu($selected = '')
	{
		$menuitems = array('ABOUT' => '', 'ADDUNIVERSITY' => 'universitylist', 'ADDDEGREE' => 'degreelist');
		foreach ($menuitems as $name => $type) {
			JSubMenuHelper::addEntry(
				JText::_('COM_VMCUSTOM_THESISPRINTING_' . $name . '_TITLE'),
				JRoute::_(JURI::root() . 'administrator/index.php?option=com_vmcustom_thesisprinting' . (!$type ? '' : '&view=' . $type)),
				$type == $selected
			);
		}
		/*JSubMenuHelper::addEntry(
			JText::_('COM_VMCUSTOM_THESISPRINTING_PLUGIN_MANUAL_TITLE'),
			JURI::root().'/plugins/vmcustom/thesisprinting/thesisprinting_manual.php',
			false
		);*/
	}

	public static function addToolbar($type = '')
	{
		$classtag = 'vmcustom_thesisprinting' . $type;
		$document = JFactory::getDocument();
		$helpurl = self::admin_url() . '/components/com_vmcustom_thesisprinting/include/manual-en_gb.php';

		// page title ...
		$title = JText::_('COM_VMCUSTOM_THESISPRINTING');
		JToolBarHelper::title($title, $classtag);
		//$document->addStyleDeclaration('.icon-48-' . $classtag . ' {background-image: url(../media/com_vmcustom_thesisprinting/vmcustom_thesisprinting_icon48.png);}');

		// toolbar buttons ...
		if ($type == 'adduniversity') {
			JToolbarHelper::title($title.' - '.JText::_('COM_VMCUSTOM_THESISPRINTING_ADDCITY_TITLE'), 'adduniversity');
			JToolbarHelper::apply('adduniversity.apply');
			JToolbarHelper::save('adduniversity.save');
			JToolBarHelper::divider();
			JToolbarHelper::cancel('adduniversity.cancel', 'JTOOLBAR_CLOSE');
			JToolBarHelper::help('', false, $helpurl);
		}
		elseif ($type == 'adddegree') {
			JToolbarHelper::title($title.' - '.JText::_('COM_VMCUSTOM_THESISPRINTING_SHIPMENTCOSTS_TITLE'), 'adddegree');
			JToolbarHelper::apply('adddegree.apply');
			JToolbarHelper::save('adddegree.save');
			JToolBarHelper::divider();
			JToolbarHelper::cancel('adddegree.cancel', 'JTOOLBAR_CLOSE');
			JToolBarHelper::help('', false, $helpurl);
		}
		elseif ($type == 'manual') {
			JToolbarHelper::title($title.' - '.JText::_('COM_VMCUSTOM_THESISPRINTING_MANUAL_TITLE'), 'manual');
			JToolBarHelper::back();
		}
		else
			JToolBarHelper::help('', false, $helpurl);
		if (self::isSuperAdminUser()) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_vmcustom_thesisprinting');
		}
	}

	public static function getComponentDesc()
	{
		$db = self::getDbo();
		$manifest = $db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = \'com_vmcustom_thesisprinting\' LIMIT 1')->loadResult();
		$manifest = json_decode($manifest, true);
		return $manifest['description'];
	}

	public static function isSuperAdminUser($user_id = null)
	{
		if (!($user = JFactory::getUser($user_id)))
			return false;
		return $user->authorise('core.admin');
	}

	public static function getSubmitbuttonJs()
	{
		return "
			Joomla.submitbutton = function(t){
				//var f = document.getElementById('adminForm');
				var f = jQuery('#adminForm');
				if (t) {
					var i = t.indexOf('.');
					//f.view.value = t.substr(0, i);
					f.find('input[name=\"view\"]').val(t.substr(0, i));
					//f.task.value = t.substr(++i);
					f.find('input[name=\"task\"]').val(t.substr(++i));
				}
				f.submit();
			};
		";
	}

}
?>
