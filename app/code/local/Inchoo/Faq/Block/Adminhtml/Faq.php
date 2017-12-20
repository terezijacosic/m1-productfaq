<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 08.12.17.
 * Time: 08:47
 */

class Inchoo_Faq_Block_Adminhtml_Faq extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_faq';
        $this->_controller = 'adminhtml_faq';
        $this->_headerText = Mage::helper('inchoo_faq')->__('Frequently Asked Questions');

        parent::__construct();
//        $this->_removeButton('add');
    }
}