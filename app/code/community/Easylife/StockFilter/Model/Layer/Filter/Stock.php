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
class Easylife_StockFilter_Model_Layer_Filter_Stock extends Mage_Catalog_Model_Layer_Filter_Abstract
{
    const DEFAULT_REQUEST_VAR   = 'in-stock';
    const REQUEST_VAR_PATH  = 'url_param';
    const STATE_LABEL       = 'label';
    /**
     * @var Easylife_StockFilter_Helper_Data
     */
    protected $_helper;
    /**
     * @var bool
     */
    protected $_activeFilter = false;
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_helper = Mage::helper('easylife_stockfilter');
        $requestVar = trim($this->_helper->getConfigValue(self::REQUEST_VAR_PATH));
        if (!$requestVar) {
            $requestVar = self::DEFAULT_REQUEST_VAR;
        }
        $this->_requestVar = $requestVar;
    }

    /**
     * Apply stock  filter to layer
     *
     * @param   Zend_Controller_Request_Abstract $request
     * @param   Mage_Core_Block_Abstract $filterBlock
     * @return  $this
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
        $filter = $request->getParam($this->getRequestVar(), null);
        if (is_null($filter)) {
            return $this;
        }
        $this->_activeFilter = true;
        $filter = (int)(bool)$filter;
        $collection = $this->getLayer()->getProductCollection();
        $collection->getSelect()->where('stock_status.stock_status = ?', $filter);
        $this->getLayer()->getState()->addFilter(
            $this->_createItem($this->getLabel($filter), $filter)
        );
        return $this;
    }

    /**
     * Get filter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_helper->getConfigValue(self::STATE_LABEL);
    }

    /**
     * Get data array for building status filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        if ($this->_activeFilter) {
            return array();
        }
        $key = $this->getLayer()->getStateKey().'_STOCK';
        $data = $this->getLayer()->getAggregator()->getCacheData($key);

        if ($data === null) {
            $data = array();
            foreach ($this->getStatuses() as $status) {
                $data[] = array(
                    'label' => $this->getLabel($status),
                    'value' => $status,
                    'count' => $this->getProductsCount($status)
                );
            }

            $tags = $this->getLayer()->getStateTags();
            $this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags);
        }
        return $data;
    }

    /**
     * get available statuses
     * @return array
     */
    public function getStatuses() {
        return array(
            Mage_CatalogInventory_Model_Stock::STOCK_IN_STOCK,
            Mage_CatalogInventory_Model_Stock::STOCK_OUT_OF_STOCK
        );
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return array(
            Mage_CatalogInventory_Model_Stock::STOCK_IN_STOCK => Mage::helper('easylife_stockfilter')->__('In Stock'),
            Mage_CatalogInventory_Model_Stock::STOCK_OUT_OF_STOCK => Mage::helper('easylife_stockfilter')->__('Out of stock'),
        );
    }

    /**
     * @param $value
     * @return string
     */
    public function getLabel($value)
    {
        $labels = $this->getLabels();
        if (isset($labels[$value])) {
            return $labels[$value];
        }
        return '';
    }
    public function getProductsCount($value)
    {
        $collection = $this->getLayer()->getProductCollection();
        $select = clone $collection->getSelect();
        // reset columns, order and limitation conditions
        $select->reset(Zend_Db_Select::COLUMNS);
        $select->reset(Zend_Db_Select::ORDER);
        $select->reset(Zend_Db_Select::LIMIT_COUNT);
        $select->reset(Zend_Db_Select::LIMIT_OFFSET);
        $select->where('stock_status.stock_status = ?', $value);
        $select->columns(array('count' => new Zend_Db_Expr("COUNT(e.entity_id)")));
        return $collection->getConnection()->fetchOne($select);
    }
}
