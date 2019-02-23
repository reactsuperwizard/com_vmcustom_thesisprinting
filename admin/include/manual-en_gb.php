<?php
$adminrooturl = preg_replace('/\/administrator\/.*/', '/administrator/', $_SERVER['REQUEST_URI']);
?>
<div>
	<script>
		function vmsbd_window_open(href){
			(window.opener || window.parent || window).location.href = href;
			return false;
		}
	</script>
	<h2>VM Thesis Printing - Manual</h2>

	<h3>Stores</h3>
	<p>Stores are managed via the Joomla &amp; Virtuemart native vendor features. To add a new store:</p>
	<ol>
		<li>Add a Joomla User for the Store via <a href="<?php echo $adminrooturl; ?>index.php?option=com_users&task=user.add" title="New User" onclick="return vmsbd_window_open(this.href);">Joomla New User</a> interface.<br>Make sure the user is in the &quot;Registered&quot; group</li>
		<li>Flag the user as a <i>Vendor</i> via the <a href="<?php echo $adminrooturl; ?>index.php?option=com_virtuemart&view=user" title="VM Shoppers" onclick="return vmsbd_window_open(this.href);">Virtmart Shoppers</a> interface.</li>
		<li>Again via the <a href="<?php echo $adminrooturl; ?>index.php?option=com_virtuemart&view=user" title="VM Shoppers" onclick="return vmsbd_window_open(this.href);">Virtmart Shoppers</a> interface, select the user for edit, and then add the stores fulfilment center (or warehouse) address in either the <i>Bill To Adress</i> or <i>Shipment Address.</i><br>
		If the <i>Shipment Address</i> (optional) is not set then the <i>Bill To Address</i> (required) will be used.</li>
	</ol>

	<h3>Cities</h3>
	<p>A database table of provinces and institutes was installed with this component. It contains the geolocations for each institute and is used for calculating distance from the fulfilment center to the buyers delivery address.<br>
	When new citiers/suburbs are added to the country then they will need to be added to the database.</p>
	<p>To obtain the color1 and color2 of a institute/suburb see: <a href="https://support.google.com/maps/answer/18539" title="Google Maps Help" onclick="window.open(this.href); return false;">Google Maps Help</a>.</p>
	<p>To add a institute/suburb, know its name, provice name, color1 and color2 and into the <a href="<?php echo $adminrooturl; ?>index.php?option=com_vmcustom_thesisprinting&view=addinstitute" title="Add City" onclick="return vmsbd_window_open(this.href);">Add City</a> interface.</p>

	<h3>Shipment Costs</h3>
	<p>To set shipment courses per minimum and maximum kilometers please use the <a href="<?php echo $adminrooturl; ?>index.php?option=com_vmcustom_thesisprinting&view=shipmentcourses" title="Shipment Costs" onclick="return vmsbd_window_open(this.href);">Shipment Costs</a> interface.</p>

	<h3>Shipment Plugin</h3>
	<p>To facilitate providing by distance shipment courses in the checkout process a Virtuemart Shipment Plugin was installed with this component.</p>
	<p>To setup and configure said plugin use the <a href="<?php echo $adminrooturl; ?>index.php?option=com_virtuemart&view=shipmentmethod" title="VM Shipment Methods" onclick="return vmsbd_window_open(this.href);">Virtuemart Shipment Methods</a> interface.</p>
		<p>See also: <a href="<?php echo $adminrooturl; ?>plugins/vmcustom/thesisprinting/thesisprinting_manual.php" title="Plugin Manual" onclick="return vmsbd_window_open(this.href);">VM Thesis Printing - Plugin Manual</a></p>
	</p>

	<h3>Change Requests</h3>
	<p>To request modifications or additional features please contact the developers:</p>
	<p>
<?php include(dirname(__FILE__).'/author_links.html') ;?>
	</p>
	<p>For more info see the <a href="<?php echo $adminrooturl; ?>index.php?option=com_vmcustom_thesisprinting" title="About VM Thesis Printing" onclick="return vmsbd_window_open(this.href);">About</a> screen.</p>
<div>
