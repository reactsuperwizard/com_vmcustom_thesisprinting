<?php
/*
 * @title		com_vm_ebay
 * @version		1.0
 * @package		Joomla
 * @author		ekerner@ekerner.com.au
 * @website		http://www.ekerner.com.au
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * @copyright		Copyright (C) 2019 Creative Momentum All rights reserved.
 */

defined('_JEXEC') or die('Restricted access!'); 

jimport('joomla.application.component.view');
if (!class_exists('vmcustom_thesisprintingHelper')) require JPATH_ADMINISTRATOR.'/components/com_vmcustom_thesisprinting/helpers/vmcustom_thesisprintingHelper.php';

abstract class vmcustom_thesisprintingViewBase extends JViewLegacy
{
	public $task_report = null;
	protected $app;

	public function __construct()
	{
		parent::__construct();
		$this->app = JFactory::getApplication();
		vmcustom_thesisprintingHelper::addSubmenu($this->getName());
		vmcustom_thesisprintingHelper::addToolbar($this->getName());
		if (!method_exists($this, 'display'))
			$this->app->enqueueMessage('Implement function display()', 'error');
	}

	public function display($tpl = null)
	{
		if ($this->task_report) {
			if($this->task_report['errors'])
				$this->app->enqueueMessage(implode('<br />', $this->task_report['errors']), 'error');
			if($this->task_report['warnings'])
				$this->app->enqueueMessage(implode('<br />', $this->task_report['warnings']), 'warning');
		}
		parent::display($tpl);
	}
}
