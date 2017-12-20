<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 15.12.17.
 * Time: 10:58
 */

class Inchoo_Faq_Block_Adminhtml_Faq_Filter_Type extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    protected function _getOptions()
    {
        return array(
            array('label' => '', 'value' => ''),
            array('label' => Mage::helper('inchoo_faq')->__('Pending'), 'value' => 0),
            array('label' => Mage::helper('inchoo_faq')->__('Approved'), 'value' => 1),
            array('label' => Mage::helper('inchoo_faq')->__('Not Approved'), 'value' => 2)
        );
    }

    public function getCondition()
    {
        if ($this->getValue() == 0) {
            return 0;
        } elseif ($this->getValue() == 1) {
            return 1;
        } else {
            return 2;
        }
    }
}