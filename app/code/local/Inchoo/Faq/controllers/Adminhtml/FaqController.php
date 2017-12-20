<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 04.12.17.
 * Time: 14:41
 */

class Inchoo_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('inchoo_faq/adminhtml_faq'));
        $this->renderLayout();
    }

    public function newAction()
    {
//        $this->_initAction();
//        $this->_addBreadcrumb($this->__('New question'), $this->__('New question'));
//        $this->_addContent($this->getLayout()->createBlock('inchoo_faq/adminhtml_faq_add'));
//        $this->renderLayout();

        $this->_initAction();
        $this->loadLayout();
        $this->_setActiveMenu('catalog/faq');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        //$this->_addContent($this->getLayout()->createBlock('inchoo_faq/adminhtml_faq_add'));
        $this->_addContent($this->getLayout()->createBlock('inchoo_faq/adminhtml_faq_product_grid'));

        $this->renderLayout();
    }

    public function editAction()
    {
        $model = Mage::getModel('inchoo_faq/faq');
        $is_new = $this->getRequest()->getParam('is_new');
        // if request comes from new faq form $id is entity_id of chosen product, otherwise $id is question_id from
        //inchoo_faq table
        $id = $this->getRequest()->getParam('id');

        $this->_title($this->__('New question'));
//        var_dump($this->getRequest()->getParams());

        if ($is_new) {
            $model->setProductId($id);
            $model->setCustomerId(143);
        } else {
            // Get id if available
            if ($id) {
                // Load record
                $model->load($id);

                // Check if record is loaded
                if (!$model->getId()) {
                    Mage::getSingleton('adminhtml/session')->addError($this->__('This question no longer exists.'));
                    $this->_redirect('*/*/');

                    return;
                }
            }

            $this->_title($model->getId() ? $model->getQuestion() : $this->__('New question'));
        }
        $data = Mage::getSingleton('adminhtml/session')->getData(true);
//        die(var_dump($data));
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('inchoo_faq', $model);

        $this->_initAction();
        $this->_addBreadcrumb($is_new ? $this->__('New Question') : $this->__('Edit Question'), $id ? $this->__('New question') : $this->__('Edit Question'));
        $this->_addContent($this->getLayout()->createBlock('inchoo_faq/adminhtml_faq_edit'));
        $this->renderLayout();

    }

    public function saveAction()
    {
//        die(var_dump($this->getFullActionName()));

        if ($postData = $this->getRequest()->getParams()) {
//            die(var_dump($postData));

            $model = Mage::getSingleton('inchoo_faq/faq');
            $model->setData($postData);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Your question has been saved.'));
                $this->_redirect('*/faq/index');
                return;
            } catch (Mage_Core_Exception $e) {
//                echo "Greška 1";
//                return;
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
//                echo "<br>Greška 2<br>" . $e->getMessage();
//                return;
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this question.'));
            }

            Mage::getSingleton('adminhtml/session')->setData($postData);
            $this->_redirectReferer();
        }
    }


    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $faq = Mage::getModel('inchoo_faq/faq');
                $faq->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess('successfully deleted');
                $this->_redirect('*/faq/index');
            } catch (Exception $e) {
                echo $e->getMessage();
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $question_ids = $this->getRequest()->getParam('question_id');
//        var_dump($question_ids);
//        die();

        if (!is_array($question_ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inchoo_faq')->__('Please select questions you want to delete.'));
        } else {
            try {
                $faq = Mage::getModel('inchoo_faq/faq');
                foreach ($question_ids as $question_id) {
                    try {
                        $faq->load($question_id)->delete();
                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    }
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('inchoo_faq')->__('Total of %d record(s) were deleted.', count($question_ids)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/faq/index');
    }

    public function messageAction()
    {
        $data = Mage::getModel('inchoo_faq/faq')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }

    public function productGridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock('inchoo_faq/adminhtml_faq_product_grid')->toHtml());
    }

    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/faq');
        $this->_title($this->__('Catalog'))->_title($this->__('FAQ'));

        return $this;
    }
}