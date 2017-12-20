<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 12.12.17.
 * Time: 09:02
 */

class Inchoo_Faq_Block_Adminhtml_Faq_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function _construct()
    {
        $this->_blockGroup = 'inchoo_faq';
        $this->_controller = 'adminhtml_faq';
        $this->_mode = 'edit';

        parent::_construct();
    }

    public function getHeaderText()
    {
//        return parent::getHeaderText();

//        die(var_dump(Mage::registry('inchoo_faq')));
        if (Mage::registry('inchoo_faq')->getId()) {
            return $this->__('Edit question');
        } else {
            return $this->__('New question');
        }
//        return $this->__('Edit question');
    }
}