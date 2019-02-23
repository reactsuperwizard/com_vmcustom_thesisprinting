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

defined ('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

abstract class vmcustom_thesisprintingViewModelBase extends JModelAdmin
{
	public function __construct()
	{
		parent::__construct();
		$this->dbo = JFactory::getDbo();
	}

	public function getForm($data = array(), $loadData = true)
	{
		return $this->loadForm();
	}
}
