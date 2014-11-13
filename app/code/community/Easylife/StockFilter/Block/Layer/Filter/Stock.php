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
class Easylife_StockFilter_Block_Layer_Filter_Stock extends Mage_Catalog_Block_Layer_Filter_Abstract
{
    /**
     * constructor
     * set the filter model name
     */
    public function __construct()
    {
        parent::__construct();
        $this->_filterModelName = 'easylife_stockfilter/layer_filter_stock';
    }
}