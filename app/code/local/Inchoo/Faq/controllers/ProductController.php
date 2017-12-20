<?php
/**
 * Created by PhpStorm.
 * question: terezija
 * Date: 30.11.17.
 * Time: 14:38
 */

class Inchoo_Faq_ProductController extends Mage_Core_Controller_Front_Action
{
//    public function preDispatch()
//    {
//        parent::preDispatch();
//
//        $allowGuest = Mage::helper('review')->getIsGuestAllowToWrite();
//        if (!$this->getRequest()->isDispatched()) {
//            return;
//        }
//
//        $action = strtolower($this->getRequest()->getActionName());
//        if (!$allowGuest && $action == 'post' && $this->getRequest()->isPost()) {
//            if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
//                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
//                Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_current' => true)));
//                Mage::getSingleton('review/session')->setFormData($this->getRequest()->getPost())
//                    ->setRedirectUrl($this->_getRefererUrl());
//                $this->_redirectUrl(Mage::helper('customer')->getLoginUrl());
//            }
//        }
//
//        return $this;
//    }


    public function listAction()
    {
        echo "list action in product controller";
    }

    public function postAction()
    {
        if (!$this->_validateFormKey()) {
            // returns to the product item page
            $this->_redirectReferer();
            return;
        }

        $customerId = Mage::getSingleton('customer/session')->getCustomerId();

        if (!$customerId) {
            $this->_redirectReferer();
        }

        $params = $this->getRequest()->getParams();

        $question = Mage::getModel('inchoo_faq/faq');
        $question->setQuestion($params['question_text']);
        /* or: $question->setData('question', 'Test question 1'); */
        $question->setProductId($params['product_id']);
        $question->setCustomerId($customerId);
        $question->setStoreId(Mage::app()->getStore()->getId());

        try {
            $question->save();

            Mage::dispatchEvent('inchoo_faq_save_question', array(
                'message' => "Hello from dispatched event!",
                'question' => $params['question_text'],
                'product_id' => $params['product_id'],
                'customer_id' => $customerId
            ));

            $file = 'event_observer_test.txt';
            $current = file_get_contents($file);
            $current .= "[" . date('d-m-Y H:i:s', time()) . "] EVENT LOG \n";
            file_put_contents($file, $current);

            // echo 'Successfully saved question.';
            $session = Mage::getSingleton('core/session');
            $session->addSuccess($this->__('Your question has been accepted for moderation.'));

        } catch (Exception $e) {
//            echo $e->getMessage();
            Mage::logException($e);
            $session->addError($this->__('Unable to post the review.'));
        }
//        $this->_redirectUrl('catalog/product/view/id' . $params['product_id']);
        $this->_redirectReferer();
    }

}