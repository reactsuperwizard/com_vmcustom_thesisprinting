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

defined('_JEXEC') or die('Restricted access');

$cwdpath = dirname(__FILE__);
$compath = is_dir($cwdpath . '/admin/helpers') ? $cwdpath . '/admin' : 
	JPATH_ADMINISTRATOR . '/components/com_vmcustom_thesisprinting';
require_once $compath . '/helpers/vmcustom_thesisprintingHelper.php';

class com_vmcustom_thesisprintingInstallerScript
{
	protected $dbname, $dbprefix, $db;

	public function __construct($adapter)
	{
		// set the db obect and prefix
		if (!class_exists('JConfig'))
			require(JPATH_CONFIGURATION . '/configuration.php');
		$cfg = new JConfig();
		$this->dbname = $cfg->db;
		$this->dbprefix = $cfg->dbprefix;
		$this->db = JFactory::getDbo();
	}

	public function install($adapter)
	{
		// TODO: create virtuemart products and variants if not exists - as per thesis printing requirements (specified)
		$sql  = "REPLACE INTO `{$this->dbprefix}virtuemart_customs` (`virtuemart_custom_id`, `custom_parent_id`, `virtuemart_vendor_id`, `custom_jplugin_id`, `custom_element`, `admin_only`, `custom_title`, `show_title`, `custom_tip`, `custom_value`, `custom_desc`, `field_type`, `is_list`, `is_hidden`, `is_cart_attribute`, `is_input`, `searchable`, `layout_pos`, `custom_params`, `shared`, `published`, `created_on`, `created_by`, `ordering`, `modified_on`, `modified_by`, `locked_on`, `locked_by`) VALUES
		(11, 0, 1, 0, '0', 0, 'BindOrientation', 1, '', '', '', 'S', 0, 0, 0, 0, 0, '', 'addEmpty=0|selectType=0|multiplyPrice=\"\"|transform=\"\"|', 0, 1, '2019-02-22 17:51:34', 280, 0, '2019-02-22 17:51:34', 280, '0000-00-00 00:00:00', 0),
		(12, 0, 1, 0, '0', 0, 'GSM', 1, '', '', '', 'S', 0, 0, 1, 0, 0, '', 'addEmpty=0|selectType=0|multiplyPrice=\"\"|transform=\"\"|', 0, 1, '2019-02-22 18:02:27', 280, 0, '2019-02-22 18:02:27', 280, '0000-00-00 00:00:00', 0),
		(13, 0, 1, 0, '0', 0, 'Print-Color', 1, '', '', '', 'S', 0, 0, 1, 1, 0, 'addtocart', 'addEmpty=\"0\"|selectType=\"0\"|multiplyPrice=\"\"|transform=\"\"|', 0, 1, '2019-02-22 18:03:00', 280, 0, '2019-02-22 18:07:22', 280, '0000-00-00 00:00:00', 0),
		(14, 0, 1, 0, '0', 0, 'Gold-Silver', 1, '', '', '', 'S', 0, 0, 1, 1, 0, 'addtocart', 'addEmpty=\"0\"|selectType=\"0\"|multiplyPrice=\"\"|transform=\"\"|', 0, 1, '2019-02-22 18:16:29', 280, 0, '2019-02-22 18:19:55', 280, '0000-00-00 00:00:00', 0),
		(15, 0, 1, 0, '0', 0, 'university', 1, '', '', '', 'S', 0, 0, 0, 0, 0, '', 'addEmpty=\"0\"|selectType=\"0\"|multiplyPrice=\"\"|transform=\"\"|', 0, 1, '2019-02-22 18:18:11', 280, 0, '2019-02-22 18:18:18', 280, '0000-00-00 00:00:00', 0),
		(16, 0, 1, 0, '0', 0, 'degree', 1, '', '', '', 'S', 0, 0, 0, 0, 0, '', 'addEmpty=0|selectType=0|multiplyPrice=\"\"|transform=\"\"|', 0, 1, '2019-02-22 18:18:34', 280, 0, '2019-02-22 18:18:34', 280, '0000-00-00 00:00:00', 0),
		(10, 0, 1, 0, '0', 0, 'BindingType', 1, '', '', '', 'S', 0, 0, 1, 1, 0, 'addtocart', 'addEmpty=0|selectType=0|multiplyPrice=\"\"|transform=\"\"|', 0, 1, '2019-02-22 17:49:56', 280, 0, '2019-02-22 17:49:56', 280, '0000-00-00 00:00:00', 0)";
		$this->db->setQuery($sql);

		$sql = "REPLACE INTO `{$this->dbprefix}virtuemart_products` (`virtuemart_product_id`, `virtuemart_vendor_id`, `product_parent_id`, `product_sku`, `product_gtin`, `product_mpn`, `product_weight`, `product_weight_uom`, `product_length`, `product_width`, `product_height`, `product_lwh_uom`, `product_url`, `product_in_stock`, `product_ordered`, `product_stockhandle`, `low_stock_notification`, `product_available_date`, `product_availability`, `product_special`, `product_discontinued`, `product_sales`, `product_unit`, `product_packaging`, `product_params`, `product_canon_category_id`, `hits`, `intnotes`, `metarobot`, `metaauthor`, `layout`, `published`, `pordering`, `created_on`, `created_by`, `modified_on`, `modified_by`, `locked_on`, `locked_by`) VALUES
			(10, 1, 0, '', '', '', NULL, 'KG', NULL, NULL, NULL, 'M', '', 0, 0, '0', 0, '2019-02-22 00:00:00', '', 1, 0, 0, 'KG', NULL, 'min_order_level=\"\"|max_order_level=\"\"|step_order_level=\"\"|product_box=\"\"|', NULL, NULL, '', '', '', '', 1, 0, '2019-02-22 18:13:49', 280, '2019-02-22 18:30:33', 280, '0000-00-00 00:00:00', 0),
			(9, 1, 0, '', '', '', NULL, 'KG', NULL, NULL, NULL, 'M', '', 0, 0, '0', 0, '2019-02-22 00:00:00', '', 1, 0, 0, 'KG', NULL, 'min_order_level=\"\"|max_order_level=\"\"|step_order_level=\"\"|product_box=\"\"|', NULL, NULL, '', '', '', '', 1, 0, '2019-02-22 17:33:21', 280, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0)";
		$this->db->setQuery($sql);

		$sql = "REPLACE INTO `{$this->dbprefix}virtuemart_products_en_gb` (`virtuemart_product_id`, `product_s_desc`, `product_desc`, `product_name`, `metadesc`, `metakey`, `customtitle`, `slug`) VALUES
				(9, '', '', 'print_papers', '', '', '', 'print_papers'),
				(10, '', '', 'hardCover', '', '', '', 'hardcover')";
		$this->db->setQuery($sql);

		$sql = "REPLACE INTO `{$this->dbprefix}virtuemart_product_customfields` (`virtuemart_customfield_id`, `virtuemart_product_id`, `virtuemart_custom_id`, `customfield_value`, `customfield_price`, `disabler`, `override`, `customfield_params`, `product_sku`, `product_gtin`, `product_mpn`, `published`, `created_on`, `created_by`, `modified_on`, `modified_by`, `locked_on`, `locked_by`, `ordering`) VALUES
		(4, 9, 11, 'bind-left', 0.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 0),
		(5, 9, 11, 'bind-rigtht', 0.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 1),
		(6, 9, 11, 'bind-top', 0.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 2),
		(7, 9, 11, 'bind-bottom', 0.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 3),
		(8, 9, 10, 'bind-type1', 30.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 4),
		(9, 9, 10, 'bind-type2', 10.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 5),
		(10, 9, 10, 'bind-type3', 15.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 6),
		(11, 9, 10, 'bind-type4', 20.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 7),
		(15, 9, 13, 'Color', 4.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 9),
		(14, 9, 13, 'Black-White', 1.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:29:57', 280, '0000-00-00 00:00:00', 0, 8),
		(16, 10, 16, 'bachelor', 0.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:30:33', 280, '0000-00-00 00:00:00', 0, 0),
		(17, 10, 15, 'beijing', 0.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:30:33', 280, '0000-00-00 00:00:00', 0, 1),
		(18, 10, 14, 'gold', 10.000000, 0, 0, '', NULL, NULL, NULL, 0, '0000-00-00 00:00:00', 0, '2019-02-22 18:30:33', 280, '0000-00-00 00:00:00', 0, 2)";
		$this->db->setQuery($sql);

		$sql = "REPLACE INTO `{$this->dbprefix}virtuemart_product_medias` (`id`, `virtuemart_product_id`, `virtuemart_media_id`, `ordering`) VALUES
		(10, 10, 10, 1),
		(9, 9, 9, 1)";
		$this->db->setQuery($sql);

		$sql = "REPLACE INTO `{$this->dbprefix}vmcustom_thesisprinting_universities` (`id`, `logo1`, `logo2`, `university_name`, `color1`, `color2`, `name_format`, `spine_format`, `published`, `ordering`) VALUES  
		(1, '1550755464_BeiJing.png', '1550755464_BeiJing.png', 'BeiDa', '#732626', '#1e4a36', 1, 1, 1, 1)";
		$this->db->setQuery($sql);

		return true;
	}

	public function update($adapter)
	{
		return $this->install($adapter);
	}
 
	public function uninstall($adapter)
	{
		$tables = [];
		foreach ($tables as $table) {
			echo("Removing {$this->dbprefix}{$table} database table:<br>\n");
			$this->db->setQuery("DELETE IGNORE FROM {$this->dbprefix}{$table}");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query', true);
			$this->db->setQuery("DROP TABLE IF EXISTS {$this->dbprefix}{$table}");
			vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'query', true);
			echo("OK!<br><br>\n");
		}
	}

	private function tableExists($table_name)
	{
		$this->db->setQuery("SELECT COUNT(*) AS n FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND TABLE_NAME = '{$table_name}' LIMIT 1");
		$res = vmcustom_thesisprintingHelper::stupidJ3CatchDatabaseExecute($this->db, 'loadResult');
		if (vmcustom_thesisprintingHelper::reportIfDbError())
			return true; // not continue if can query info schema
		return (int)$res;
	}

}
