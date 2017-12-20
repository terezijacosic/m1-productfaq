<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 18.12.17.
 * Time: 14:00
 */

class Inchoo_Faq_Block_Adminhtml_Faq_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    public function __construct()
    {
        parent::__construct();
//        $this->setRowClickCallback('review.gridRowClick');
        $this->setUseAjax(true);
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('review')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('review')->__('Name'),
            'index'     => 'name',
        ));

        if ((int)$this->getRequest()->getParam('store', 0)) {
            $this->addColumn('custom_name', array(
                'header'    => Mage::helper('review')->__('Name in Store'),
                'index'     => 'custom_name'
            ));
        }

        $this->addColumn('sku', array(
            'header'    => Mage::helper('review')->__('SKU'),
            'width'     => '80px',
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('review')->__('Price'),
            'type'      => 'currency',
            'index'     => 'price'
        ));

        $this->addColumn('qty', array(
            'header'    => Mage::helper('review')->__('Qty'),
            'width'     => '130px',
            'type'      => 'number',
            'index'     => 'qty'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('review')->__('Status'),
            'width'     => '90px',
            'index'     => 'status',
            'type'      => 'options',
            'source'    => 'catalog/product_status',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('websites',
                array(
                    'header'=> Mage::helper('review')->__('Websites'),
                    'width' => '100px',
                    'sortable'  => false,
                    'index'     => 'websites',
                    'type'      => 'options',
                    'options'   => Mage::getModel('core/website')->getCollection()->toOptionHash(),
                ));
        }
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/productGrid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId(), 'is_new' => 1));
    }

    protected function _prepareMassaction()
    {
        return $this;
    }

}