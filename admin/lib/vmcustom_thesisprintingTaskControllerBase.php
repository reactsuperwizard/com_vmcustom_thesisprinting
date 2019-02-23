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

jimport('joomla.application.component.controlleradmin');

abstract class vmcustom_thesisprintingTaskControllerBase extends JControllerAdmin
{
	protected $model_prefix = 'vmcustom_thesisprintingModel';

	protected function _run_task($name, $viewName = null, $layout = 'default')
	{
		// viewName from request
		if (!$viewName)
			$viewName = JFactory::getApplication()->input->get('view');

		// Do the task if taskModel exists
		$taskModel = parent::getModel($viewName.'_'.$name, $this->model_prefix);
		if ($taskModel) {
			$taskModel->do_task();
			if (!empty($taskModel->report['displayView']))
				$viewName = $taskModel->report['displayView'];
			if (!empty($taskModel->report['displayLayout']))
				$layout = $taskModel->report['displayLayout'];
			$taskModel->report['task'] = $name;
		}
		
		// Create the view
		$viewModel = parent::getModel($viewName, $this->model_prefix);
		$view = $this->getView($viewName, 'html');
		$view->setModel($viewModel, true);
		if ($taskModel)
			$view->task_report = $taskModel->report;
		
		// Set the layout and display the view
		$view->setLayout($layout);
		$view->display();
	}
}
