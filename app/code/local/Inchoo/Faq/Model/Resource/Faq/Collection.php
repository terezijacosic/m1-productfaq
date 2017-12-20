<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 27.11.17.
 * Time: 08:17
 */

class Inchoo_Faq_Model_Resource_Faq_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @param null $resource
     */
    public function _construct($resource = null)
    {
        $this->_init('inchoo_faq/faq');
    }

    /**
     * @param null $storeId
     * @return $this
     */
    public function addStoreFilter($storeId = null)
    {
        if (is_null($storeId)) {
            $storeId = $this->getStoreId();
        }
        return $this->addFilter('store_id', $storeId);
    }

    /**
     * @param $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addAdminStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        if (!is_array($store)) {
            $store = array($store);
        }

        $this->addFilter('store_id', array('in' => $store));

        return $this;
    }

    /**
     * @param $customerId
     * @return $this
     */
    public function addCustomerFilter($customerId)
    {
        return $this->addFilter('customer_id', $customerId);
    }

    /**
     * @param $productId
     * @return Varien_Data_Collection_Db
     */
    public function addProductFilter($productId)
    {
        return $this->addFilter('product_id', $productId);
    }

    /**
     * @return $this
     */
    public function addIsVisibleFilter()
    {
        return $this->addFilter('is_visible', 1);
    }

    public function addHasAnswerFilter()
    {
        return $this->addFilter('answer', 'NOT NULL');
    }

    /**
     * @param string $dir
     * @return Varien_Data_Collection_Db
     */
    public function setDateOrder($dir = 'DESC')
    {
        return $this->setOrder('created_at', $dir);
    }

    protected function _joinFields()
    {
        $faqTable = Mage::getSingleton('inchoo_faq/faq')->getTableName('inchoo_faq/faq');
        $productTable = Mage::getSingleton('core/resource')->getTableName('catalog/product');

        $this->addAttributeToSelect('name')
            ->addAttributeToSelect('sku');

        $this->getSelect()
            ->join(array('rt' => $faqTable),
                'rt.product_id = e.entity_id',
                array('rt.review_id', 'review_created_at' => 'rt.created_at', 'rt.entity_pk_value', 'rt.status_id'))
            ->join(array('rdt' => $productTable),
                'rdt.review_id = rt.review_id',
                array('rdt.title', 'rdt.nickname', 'rdt.detail', 'rdt.customer_id', 'rdt.store_id'));
        return $this;
    }

}