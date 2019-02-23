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

class vmcustom_ThesisPrintingControlleruniversity_detail extends JControllerLegacy {

	
	function __construct($default = array()) {
		
		parent::__construct ( $default );
		$this->_table_prefix = '#__';
	
	
	}
	
	function edit() {
		JRequest::setVar ( 'view', 'university_detail' );
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
		$model = $this->getModel ( 'university_detail' );
		$user 		= clone(JFactory::getUser());
		

		$file 	= JRequest::getVar ( 'logo1', '', 'files', 'array' );
		
		$file1 	= JRequest::getVar ( 'logo2', '', 'files', 'array' );
		
		$id=JRequest::getVar('cid','','request','array');
		$post['id']=$id[0];
		//echo '<pre>';print_r($file);exit;
	  	if($file['name']!='')
	   	{
	   		
			$filetype = strtolower(JFile::getExt($file['name']));	
			
			if($filetype=='jpg' || $filetype=='jpeg' || $filetype=='gif' || $filetype=='png' || $filetype='bmp' || $filetype=='tif')
			{
				$post['logo1']	= JPath::clean(time().'_'.$file['name']);
			
				$src	= $file['tmp_name'];
			$dest 	= JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/'.$post['logo1'] ;

				JFile::upload($src,$dest);	
				
				$dest1 	= JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/small_'.$post['logo1'];
				copy($dest,$dest1);
				$img 	= new Thumbnail();
				$thumboption 	= array('type'   => $filetype,'width' => "50",'height'  => "50",'method'  => THUMBNAIL_METHOD_SCALE_MAX);
				Thumbnail::output($dest, $dest1, $thumboption);
			
				if($post['oldphoto_logo1'])
				{
					$dest 	= JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/'.$post["oldphoto_logo1"];
					unlink($dest);
					$dest12 = JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/small_'.$post["oldphoto_logo1"];
					unlink($dest12);
				}		

				/*if($file["name"][$id]=="")
					$pname 	= $post['oldphoto'][$id];
				else
					$pname	= $file["name"][$id];*/
			}
		} 
		else
		{
		 
			$post['logo1']	= $post['oldphoto_logo1'];
		}
		
		if($file1['name']!='')
	   	{
	   		
			$filetype = strtolower(JFile::getExt($file1['name']));	
			
			if($filetype=='jpg' || $filetype=='jpeg' || $filetype=='gif' || $filetype=='png' || $filetype='bmp' || $filetype=='tif')
			{
				$post['logo2']	= JPath::clean(time().'_'.$file1['name']);
			
				$src	= $file1['tmp_name'];
			$dest 	= JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/'.$post['logo2'] ;

				JFile::upload($src,$dest);	
				
				$dest1 	= JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/small_'.$post['logo2'];
				copy($dest,$dest1);
				$img 	= new Thumbnail();
				$thumboption 	= array('type'   => $filetype,'width' => "50",'height'  => "50",'method'  => THUMBNAIL_METHOD_SCALE_MAX);
				Thumbnail::output($dest, $dest1, $thumboption);
			
				if($post['oldphoto_logo2'])
				{
					$dest 	= JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/'.$post["oldphoto_logo2"];
					unlink($dest);
					$dest12 = JPATH_ROOT.'/'.'administrator/components/com_vmcustom_thesisprinting/assets/university_logo/small_'.$post["oldphoto_logo2"];
					unlink($dest12);
				}		

				/*if($file["name"][$id]=="")
					$pname 	= $post['oldphoto'][$id];
				else
					$pname	= $file["name"][$id];*/
			}
		} 
		else
		{
			$post['logo2']	= $post['oldphoto_logo2'];
		}
		
		$id = $model->store($post);
		
		if($id)
		{
			$msg = JText::_ ( 'Save successfullly' );
		}	
		else 
		{
			$msg = JText::_ ( 'Error on saving' );
		}
		//$msg = JText::_ ( 'university_detail_SAVED' );				
		$this->setRedirect('index.php?option='.$option.'&view=universitylist', $msg);
		
	}

	function cancel($key = NULL) {
		$option = JRequest::getVar('option','','request','string');
		$msg = JText::_ ( 'EDITING_CANCELLED' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=universitylist',$msg );
	}
	
	function remove() {
		
		$option = JRequest::getVar('option','','request','string');
		
	 $cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
	
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_DELETE' ) );
		}
		
		$model = $this->getModel ( 'university_detail' );
		if (! $model->delete ( $cid )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'DELETED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=universitylist',$msg );
	}
}
?>