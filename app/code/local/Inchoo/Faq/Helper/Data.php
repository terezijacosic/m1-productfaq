<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 04.12.17.
 * Time: 11:57
 */

class Inchoo_Faq_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getFaqStatuses()
    {
        return array(
            Inchoo_Faq_Model_Faq::STATUS_PENDING => $this->__('Pending'),
            Inchoo_Faq_Model_Faq::STATUS_APPROVED => $this->__('Approved'),
            Inchoo_Faq_Model_Faq::STATUS_NOT_APPROVED => $this->__('Not Approved')
        );
    }

    /**
     * Get faq statuses as option array
     *
     * @return array
     */
    public function getFaqStatusesOptionArray()
    {
        $result = array();
        foreach ($this->getFaqStatuses() as $k => $v) {
            $result[] = array('value' => $k, 'label' => $v);
        }

        return $result;
    }
}