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
class Easylife_StockFilter_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CONFIG_PREFIX = 'easylife_stock_filter/settings/';
    const CATALOG_AREA = 'catalog';
    const SEARCH_AREA = 'search';
    protected $_selects = array();
    /**
     * @param $value
     * @param bool $asBool
     * @return bool|mixed
     */
    public function getConfigValue($value, $asBool = false) {
        if ($asBool) {
            return Mage::getStoreConfigFlag(self::CONFIG_PREFIX.$value);
        }
        return Mage::getStoreConfig(self::CONFIG_PREFIX.$value);
    }

    /**
     * @return bool|mixed
     */
    public function isEnabled()
    {
        //if show out of stock products is set to no, this extension is useless.
        if (!Mage::helper('cataloginventory')->isShowOutOfStock()) {
            return false;
        }
        return $this->getConfigValue('enabled', true);
    }

    /**
     * @param $area
     * @return bool|mixed
     */
    public function isEnabledForArea($area)
    {
        if (!$this->isEnabled()) {
            return false;
        }
        return $this->getConfigValue($area);
    }

    /**
     * prevent adding a correlation twice
     * @param Varien_Db_Select $select
     * @param null $website
     * @return $this
     */
    public function addStockToSelect(Varien_Db_Select $select, $website = null)
    {
        if (!($website instanceof Mage_Core_Model_Website)) {
            /** @var Mage_Core_Model_Website $website */
            $website = Mage::app()->getWebsite();
        }
        //check if the correlation was already added
        $from = $select->getPart(Zend_Db_Select::FROM);
        if (isset($from['stock_status'])) {
            return $this;
        }
        /** @var Mage_CatalogInventory_Model_Stock_Status $stockStatusModel */
        $stockStatusModel = Mage::getModel('cataloginventory/stock_status');
        $stockStatusModel->addStockStatusToSelect($select, $website);
        return $this;
    }

    /**
     * @param Varien_Db_Select $select
     * @return string
     */
    public function hashSelect(Varien_Db_Select $select)
    {
        return md5($select->__toString());
    }
}