<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 12.12.17.
 * Time: 09:15
 */

class Inchoo_Faq_Block_Adminhtml_Faq_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();

        $this->setId('inchoo_faq_form');
        $this->setTitle($this->__('Inchoo FAQ edit form'));

//        echo "</br>EDIT FORM";
    }

    /**
     * Setup form fields for inserts/updates
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $faq = Mage::registry('inchoo_faq');
        $product = Mage::getModel('catalog/product')->load($faq->getProductId());
        $customer = Mage::getModel('customer/customer')->load($faq->getCustomerId());

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/faq/save', array(
                    'id' => $this->getRequest()->getParam('question_id'),
                    'ret' => Mage::registry('ret'),
                    'question_id' => $faq->getQuestionId(),
                    'customer_id' => $faq->getCustomerId(),
                    'product_id' => $faq->getProductId())
            ),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('faq_details_edit', array(
            'legend' => $this->__('Question Details'),
            'class' => 'fieldset-wide'
        ));

        $fieldset->addField('product_name', 'note', array(
            'label' => Mage::helper('review')->__('Product'),
            'text' => '<a href="' . $this->getUrl('*/catalog_product/edit', array('id' => $product->getId())) . '" onclick="this.target=\'blank\'">' . $product->getName() . '</a>'
        ));

        if ($customer->getId()) {
            $customerText = Mage::helper('review')->__('<a href="%1$s" onclick="this.target=\'blank\'">%2$s</a> <a href="mailto:%3$s">(%3$s)</a>', $this->getUrl('*/customer/edit', array('id' => $customer->getId(), 'active_tab' => 'review')), $this->escapeHtml($customer->getName()), $this->escapeHtml($customer->getEmail()));
        } else {
            if (is_null($faq->getCustomerId())) {
                $customerText = Mage::helper('review')->__('Guest');
            } elseif ($faq->getCustomerId() == 0) {
                $customerText = Mage::helper('review')->__('Administrator');
            }
        }

        $fieldset->addField('customer', 'note', array(
            'label' => Mage::helper('review')->__('Posted By'),
            'text' => $customerText,
        ));

//       die(Mage::helper('inchoo_faq')->getFaqStatuses()[$faq->getIsVisible()]);
        $fieldset->addField('status_id', 'select', array(
            'label' => Mage::helper('inchoo_faq')->__('Status'),
            'required' => true,
            'name' => 'is_visible',
            'values' => Mage::helper('inchoo_faq')->getFaqStatusesOptionArray(),
            'value' => 2
        ));


        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('store_id', 'select', array(
                'label' => Mage::helper('inchoo_faq')->__('Visible In'),
                'required' => true,
                'name' => 'store_id',
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
                'value' => $faq->getStoreId()
            ));
//            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
//            $field->setRenderer($renderer);

        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'store_id',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $faq->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('question', 'text', array(
            'label' => Mage::helper('inchoo_faq')->__('Question'),
            'required' => true,
            'name' => 'question'
        ));

        $fieldset->addField('answer', 'textarea', array(
            'label' => Mage::helper('inchoo_faq')->__('Answer'),
            'required' => false,
            'name' => 'answer',
            'style' => 'height:12em;',
        ));

        $form->setUseContainer(true);
        $form->setValues($faq->getData());
        $this->setForm($form);

//        Mage::register('inchoo_faq_form', array('question_id' => $faq->getQuestionId(), 'customer_id' => $faq->getCustomerId()));

        return parent::_prepareForm();
    }
}