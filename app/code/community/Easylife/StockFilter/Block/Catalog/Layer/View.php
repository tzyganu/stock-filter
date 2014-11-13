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
class Easylife_StockFilter_Block_Catalog_Layer_View extends Mage_Catalog_Block_Layer_View
{
    /**
     * @var string
     */
    protected $_stockBlockName;

    /**
     * init filter blocks
     * just do what the parent method does and dispatch an event
     */
    protected function _initBlocks()
    {
        parent::_initBlocks();
        Mage::dispatchEvent('catalog_layer_view_init_blocks', array('block' => $this));
    }

    /**
     * prepare the layout
     * just do what the parent method does and dispatch an event
     *
     * @return Mage_Catalog_Block_Layer_View|void
     */
    protected function _prepareLayout()
    {
        Mage::dispatchEvent('catalog_layer_view_prepare_layout', array('block' => $this));
        parent::_prepareLayout();
    }

    /**
     * get the filters
     * just do what the parent method does and dispatch an event
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = parent::getFilters();
        $object = new Varien_Object(array('filters' => $filters));
        Mage::dispatchEvent(
            'catalog_layer_view_get_filters_before',
            array(
                'block' => $this,
                'filters_object' => $object
            )
        );
        $filters = $object->getFilters();
        return $filters;
    }

    /**
     * set the stock block name
     * @return string
     */
    public function getStockBlockName()
    {
        return $this->_stockBlockName;
    }

    /**
     * get the stock block name
     * @param $stockBlockName
     * @return $this;
     */
    public function setStockBlockName($stockBlockName)
    {
        $this->_stockBlockName = $stockBlockName;
        return $this;
    }
}
