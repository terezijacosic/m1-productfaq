<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 30.11.17.
 * Time: 21:16
 */

class Inchoo_Faq_Block_Product_List extends Mage_Core_Block_Template
{
    protected $_collection;

    /**
     * Initializes collection
     */
    protected function _construct()
    {
        $this->_collection = Mage::getModel('inchoo_faq/faq')->getCollection();
        $this->_collection
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addProductFilter(Mage::registry('product')->getEntityId())
            ->addIsVisibleFilter()
            ->addHasAnswerFilter()
            ->setDateOrder();
    }

    /**
     * Gets collection items count
     *
     * @return int
     */
    public function count()
    {
        return $this->_collection->getSize();
    }

    /**
     * Get html code for toolbar
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    /**
     * Initializes toolbar
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $toolbar = $this->getLayout()->createBlock('page/html_pager', 'customer_review_list.toolbar')
            ->setCollection($this->getCollection());

        $this->setChild('toolbar', $toolbar);
        return parent::_prepareLayout();
    }

    /**
     * Get collection
     *
     * @return Mage_Review_Model_Resource_Review_Product_Collection
     */
    protected function _getCollection()
    {
        return $this->_collection;
    }

    /**
     * Get collection
     *
     * @return Mage_Review_Model_Resource_Review_Product_Collection
     */
    public function getCollection()
    {
        return $this->_getCollection();
    }

    /**
     * Get product link
     *
     * @return string
     */
    public function getProductLink()
    {
        return Mage::getUrl('catalog/product/view/');
    }

    /**
     * @return mixed
     */
    public function getCurrentProductId()
    {
        return Mage::registry('product')->getEntityId();
    }

    public function isCustomerLoggedIn()
    {
        return Mage::getSingleton('customer/session')->getCustomerId();
    }

    /**
     * @param $productId
     * @return string
     */
    public function getProductName($productId)
    {
        return Mage::getModel('catalog/product')->load($productId)->getName();
    }

    /**
     * Format date in short format
     *
     * @param $date
     * @return string
     */
    public function dateFormat($date)
    {
        return $this->formatDate($date, Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return Mage::getUrl('questions/product/post', array('product_id' => $this->getCurrentProductId(), '_secure' => true));
    }

}