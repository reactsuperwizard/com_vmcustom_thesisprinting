<?php
/**
* @package   com_actionlist
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
JHTML::_('behavior.calendar');
JHTML::_('behavior.modal');
$uri =JURI::getInstance();
$url= $uri->root();

$option = JRequest::getVar('option','','request','string');
$doc =JFactory::getDocument();
$doc->addStyleSheet("components/".$option."/assets/css/style.css");
$image_path	= JPATH_ADMINISTRATOR."/components/".$option."/assets/university_logo/";
$image_url	= $url."/administrator/components/".$option."/assets/university_logo/";
$user 		= clone(JFactory::getUser());

if (!class_exists('JFormFieldColor'))
	require JPATH_SITE.'/libraries/joomla/form/fields/color.php';
class vmctpJFormFieldColor extends JFormFieldColor{
		function __construct($name, $value){
				parent::__construct();
				if (!$value) $value = '#111111';
				$this->setup(new SimpleXMLElement('<field/>'), $value);
				$this->name = $this->id = $name;
				echo $this->getInput();
		}
}

?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		
		else if(form.name.value=="")
		{
			alert("<?php echo JText::_( 'PLEASE_ENTER_ACCOUNT_NAME' ); ?>");
			return false;
		}else if(form.calias.value==""){
			alert("<?php echo JText::_( 'ENTER_ALIAS' ); ?>");
			return false;
		}
	
			submitform( pressbutton );
		
	}


</script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'ADD_UNIVERSITY' ); ?></legend>

		<table class="admintable" border="0">
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'UNIVERSITY_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="university_name" id="university_name" value="<?php echo $this->details->university_name;?>"/>
			</td>
		</tr>
		
		

		<tr>
			<td width="100" align="right" class="key">
				<label for="image">
					<?php echo JText::_( 'LOGO_1' ); ?>
				</label>
			</td>

			<td>
				<input class="text_area"  type="file" name="logo1" id="logo1" value="" />
		    	<input type="hidden" name="oldphoto_logo1" id="oldphoto_logo1" value="<?php echo $this->details->logo1;?>">
		
				<?php if(!empty($this->details->logo1)) 
				{
				   if(file_exists($image_path.'small_'.$this->details->logo1))
		           { 
		        ?>
				    <a href="<?php echo $image_url.$this->details->logo1;?>" class="modal"><img src="<?php echo $image_url.'small_'.$this->details->logo1;?>" style="height:150px;width:auto;"/></a>
		       <?php 
		           }	
		           elseif(file_exists($image_path.'noimage.png'))
		           {
			   ?>
				    <img src="<?php echo $image_url.'noimage.png'; ?>" style="height:150px;width:auto;"/>
				<?php
				   }
				 } 
				?>
			</td>
		</tr>   
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="image">
					<?php echo JText::_( 'LOGO_2' ); ?>
				</label>
			</td>

			<td>
				<input class="text_area"  type="file" name="logo2" id="logo2" value="" />
		    	<input type="hidden" name="oldphoto_logo2" id="oldphoto_logo2" value="<?php echo $this->details->logo2;?>">
		
				<?php if(!empty($this->details->logo2)) 
				{
				   if(file_exists($image_path.'small_'.$this->details->logo2))
		           { 
		        ?>
				    <a href="<?php echo $image_url.$this->details->logo2;?>" class="modal"><img src="<?php echo $image_url.'small_'.$this->details->logo2;?>" style="height:150px;width:auto;"/></a>
		       <?php 
		           }	
		           elseif(file_exists($image_path.'noimage.png'))
		           {
			   ?>
				    <img src="<?php echo $image_url.'noimage.png'; ?>" style="height:150px;width:auto;"/>
				<?php
				   }
				 } 
				?>
			</td>
		</tr>   
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'COLOR1' ); ?>:
				</label>
			</td>
			<td>
				<?php new vmctpJFormFieldColor('color1', $this->details->color1); ?>
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'COLOR2' ); ?>:
				</label>
			</td>
			<td>
				<?php new vmctpJFormFieldColor('color2', $this->details->color2); ?>
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'NAME_FORMAT' ); ?>:
				</label>
			</td>
			<td>
				<select class="text_area" name="name_format" id="name_format">
				<?php
					foreach($this->lists['name_formats'] as $name_format) {
						echo('<option value="'.$name_format['id'].'"');
						if ($this->details->name_format == $name_format['id'])
							echo(' selected="selected"');
						echo('>'.$name_format['name_format'].'</option>');
					}
				?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'SPINE_DIRECTION' ); ?>:
				</label>
			</td>
			<td>
				<select class="text_area" name="spine_format" id="spine_format">
				<?php
					foreach($this->lists['spine_formats'] as $spine_format) {
						echo('<option value="'.$spine_format['id'].'"');
						if ($this->details->spine_format == $spine_format['id'])
							echo(' selected="selected"');
						echo('>'.$spine_format['spine_format'].'</option>');
					}
				?>
				</select>
			</td>
		</tr>
		
	</table>
	
	</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="id" value="<?php echo $this->details->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="university_detail" />
</form>

