<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 28.11.17.
 * Time: 08:46
 */

class Inchoo_Faq_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
//        echo 'Hello FAQ!';

        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();

//        Zend_Debug::dump($this->getLayout()->getUpdate()->getHandles());
    }

//  http://magento1.loc/helloworld/index/sayHello
    public function sayHelloAction()
    {
        echo 'Hello FAQ one more time!';
    }

    public function testSaveAction()
    {
        $user = Mage::getModel('inchoo_faq/faq');
        $user->setQuestion('Test question 1');
        /* or: $user->setData('question', 'Test question 1'); */
        $user->setProductId(231);
        /* or: $user->setDatata('lastname', 'Doe'); */
        $user->setCustomerId(142);

        try {
            $user->save();
            echo 'Successfully saved question.';
        } catch (Exception $e) {
            echo $e->getMessage();
            Mage::logException($e);
            /* or: Mage::log($e->getTraceAsString(), null, 'exception.log',
            true); */
        }
    }

}