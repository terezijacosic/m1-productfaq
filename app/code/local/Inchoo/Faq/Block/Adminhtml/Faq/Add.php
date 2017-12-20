<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 15.12.17.
 * Time: 14:00
 */

class Inchoo_Faq_Block_Adminhtml_Faq_Add extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->hasData('template')) {
            $this->setTemplate('inchoo/widget/form/container-add.phtml');
        }

        $this->_blockGroup = 'inchoo_faq';
        $this->_controller = 'adminhtml_faq';
        $this->_mode = 'add';

        $this->_updateButton('save', 'label', 'Save Question');
        $this->_updateButton('save', 'onclick', "addForm.submit()");

//        $this->removeButton('save');
//
//        $this->_addButton('save_new_faq', array(
//            'label' => Mage::helper('inchoo_faq')->__('Save Question'),
//            'onclick' => "setLocation('{$this->getUrl('*/faq/save', array('new_question', 'new_answer'))}')",
//            'class' => 'save',
//        ));
    }

    public function getHeaderText()
    {
        return $this->__('New question');
    }
}