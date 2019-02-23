<?php
/*
 * @title		com_vmcustom_thesisprinting
 * @version		1.0
 * @package		Joomla
 * @author		ekerner@ekerner.com
 * @website		http://www.ekerner.com
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * @copyright		Copyright (C) 2019 Creative Momentum All rights reserved.
 */

defined('_JEXEC') or die('Restricted access!'); 

//ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// redirect to view if requested ...
$input = JFactory::getApplication()->input;
$view = $input->get('view');
if ($view) {
	require_once (JPATH_COMPONENT.'/'.'helpers/thumbnail.php');
	jimport('joomla.application.component.controller');
	$task = $input->get('task', '');
	if ($task && strpos($task, '.') === false)
		$input->set('task', $view.'.'.$task); 
	$controller = JControllerLegacy::getInstance('vmcustom_thesisprinting');
	$controller->execute($input->get('task')); // task may have been updated by JControllerLegacy::getInstance()
	$controller->redirect();
	return;
}

// draw the menus ...
if (!class_exists('vmcustom_thesisprintingHelper')) require(JPATH_COMPONENT . '/helpers/vmcustom_thesisprintingHelper.php');
vmcustom_thesisprintingHelper::addSubmenu();
vmcustom_thesisprintingHelper::addToolbar();

// draw the About info ...
echo(vmcustom_thesisprintingHelper::getComponentDesc());
echo("<h3>License Info</h3>\n<pre>");
include(dirname(__FILE__).'/LICENSE.txt');
echo('</pre>');
