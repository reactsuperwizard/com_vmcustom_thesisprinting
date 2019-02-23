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
JHTMLBehavior::modal();
$uri =JURI::getInstance();
$url= $uri->root();

$option = JRequest::getVar('option','','request','string');
$doc =JFactory::getDocument();
$doc->addStyleSheet("components/".$option."/assets/css/style.css");
$user 		= clone(JFactory::getUser());


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
					<?php echo JText::_( 'DEGREE_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="degree_name" id="degree_name" value="<?php echo $this->details->degree_name;?>"/>
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'STATUS' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['published']; ?>
			</td>
		</tr>
		
		

	
	</table>
	
	</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="cid" value="<?php echo $this->details->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="degree_detail" />
</form>

