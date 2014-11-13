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
class Easylife_StockFilter_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     * @param $area
     * @return $this
     */
    protected function _addStockFilterBlock(Varien_Event_Observer $observer, $area)
    {
        /** @var Easylife_StockFilter_Helper_Data $helper */
        $helper = Mage::helper('easylife_stockfilter');
        if (!$helper->isEnabledForArea($area)) {
            return $this;
        }
        $block = $observer->getEvent()->getBlock();
        if ($block && $stockBlockName = $block->getStockBlockName()) {
            $stockBlock = $block->getLayout()->createBlock($stockBlockName)
                ->setLayer($block->getLayer())
                ->init();
            $block->setChild('stock_filter', $stockBlock);
            /** @var Mage_Catalog_Model_Resource_Product_Collection  $collection */
            $collection = $block->getLayer()->getProductCollection();
            $helper->addStockToSelect($collection->getSelect());
        }
        return $this;
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function addStockFilterBlockCatalog(Varien_Event_Observer $observer)
    {
        return $this->_addStockFilterBlock($observer, Easylife_StockFilter_Helper_Data::CATALOG_AREA);
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function addStockFilterBlockSearch(Varien_Event_Observer $observer)
    {
        return $this->_addStockFilterBlock($observer, Easylife_StockFilter_Helper_Data::SEARCH_AREA);
    }

    /**
     * @param Varien_Event_Observer $observer
     * @param $area
     * @return $this
     */
    protected function _initStockFilterBlock(Varien_Event_Observer $observer, $area)
    {
        /** @var Easylife_StockFilter_Helper_Data $helper */
        $helper = Mage::helper('easylife_stockfilter');
        if (!$helper->isEnabledForArea($area)) {
            return $this;
        }
        $block = $observer->getEvent()->getBlock();
        if ($block) {
            $block->setStockBlockName('easylife_stockfilter/layer_filter_stock');
        }
        return $this;
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function initStockFilterBlockCatalog(Varien_Event_Observer $observer)
    {
        return $this->_initStockFilterBlock($observer, Easylife_StockFilter_Helper_Data::CATALOG_AREA);
    }
    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function initStockFilterBlockSearch(Varien_Event_Observer $observer)
    {
        return $this->_initStockFilterBlock($observer, Easylife_StockFilter_Helper_Data::SEARCH_AREA);
    }

    /**
     * @param Varien_Event_Observer $observer
     * @param $area
     * @return $this
     */
    protected function _addStockToFilters(Varien_Event_Observer $observer, $area)
    {
        /** @var Easylife_StockFilter_Helper_Data $helper */
        $helper = Mage::helper('easylife_stockfilter');
        if (!$helper->isEnabledForArea($area)) {
            return $this;
        }
        $block = $observer->getEvent()->getBlock();
        /** @var Varien_Object $filtersObject */
        $filtersObject = $observer->getEvent()->getFiltersObject();
        if ($filtersObject && $block && $filterBlock = $block->getChild('stock_filter')) {
            $filters = $filtersObject->getFilters();
            $filters[] = $filterBlock;
            $filtersObject->setFilters($filters);
        }
        return $this;
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function addStockToFiltersCatalog(Varien_Event_Observer $observer)
    {
        return $this->_addStockToFilters($observer, Easylife_StockFilter_Helper_Data::CATALOG_AREA);
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function addStockToFiltersSearch(Varien_Event_Observer $observer)
    {
        return $this->_addStockToFilters($observer, Easylife_StockFilter_Helper_Data::SEARCH_AREA);
    }
}
