<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 23.11.17.
 * Time: 15:02
 */

class Inchoo_Faq_Model_Faq extends Mage_Core_Model_Abstract
{
    const STATUS_PENDING        = 0;
    const STATUS_APPROVED       = 1;
    const STATUS_NOT_APPROVED   = 2;

    protected function _construct()
    {
        $this->_init('inchoo_faq/faq');
    }

    /**
     * @return Inchoo_Faq_Model_Resource_Faq|Object
     */
    public function getProductCollection()
    {
        return Mage::getResourceModel('inchoo_faq/faq');
    }

}