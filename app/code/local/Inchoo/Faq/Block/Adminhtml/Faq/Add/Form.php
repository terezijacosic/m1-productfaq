<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 15.12.17.
 * Time: 14:56
 */

class Inchoo_Faq_Block_Adminhtml_Faq_Add_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('inchoo_faq_add');
        $this->setTitle($this->__('Inchoo FAQ new question form'));

//        echo "</br>Add/Form.php";
    }

    /**
     * Setup form fields for inserts/updates
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'add_form',
            'action' => $this->getUrl('*/faq/save', array(
                    'ret' => Mage::registry('ret'),
                    'id' => $this->getRequest()->getParam('id')
                )
            ),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('faq_new_question', array(
            'legend' => $this->__('New Question'),
            'class' => 'fieldset-wide'
        ));

        $fieldset->addField('new_question', 'text', array(
            'label' => Mage::helper('inchoo_faq')->__('New Question'),
            'required' => true,
            'name' => 'question'
        ));

        $fieldset->addField('new_answer', 'textarea', array(
            'label' => Mage::helper('inchoo_faq')->__('Answer'),
            'required' => false,
            'name' => 'answer',
            'style' => 'height:12em;',
        ));

        $form->setUseContainer(true);
//        $form->setValues();
        $this->setForm($form);

//        echo "_prepareForm()";

        return parent::_prepareForm();


    }
}