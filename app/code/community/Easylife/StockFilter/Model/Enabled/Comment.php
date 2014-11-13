<?php
/**
 * Easylife_StockFilter extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE_EASYLIFE_STOCK_FILTER.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   	Easylife
 * @package	    Easylife_StockFilter
 * @copyright   Copyright (c) 2014 Marius Strajeru
 * @license	    http://opensource.org/licenses/mit-license.php MIT License
 */
class Easylife_StockFilter_Model_Enabled_Comment
{
    public function getCommentText()
    {
        if (!Mage::helper('cataloginventory')->isShowOutOfStock()) {
            return Mage::helper('easylife_stockfilter')->__('Your store does not display out of stock products so enabling this extension is useless. You have to show the out of stock products for this extension to make sense. You can do that from <a href="%s">System->Configuration->Inventory->Stock Options</a>. Set the field "Display Out of Stock Products" to "Yes"', Mage::helper('adminhtml')->getUrl('adminhtml/system_config/edit', array('section'=>'cataloginventory')));
        } else {
            return Mage::helper('easylife_stockfilter')->__('Enabling this makes sense only if you choose to display out of stock products in your store. This setting is currently enabled.');
        }
    }
}