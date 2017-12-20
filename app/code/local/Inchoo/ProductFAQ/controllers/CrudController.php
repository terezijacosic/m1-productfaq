<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 27.11.17.
 * Time: 12:37
 */

class Inchoo_ProductFaq_CrudController extends Mage_Core_Controller_Front_Action
{
    public function saveQuestionAction()
    {
        $question = Mage::getModel('inchoo_productfaq/question');
        $question->setQuestion('Test question 2');
        /* or: $user->setData('question', 'Test question 1'); */
        $question->setProductId(231);
        $question->setCustomerId(141);
        try {
            $question->save();
            echo 'Successfully saved user.';
        } catch (Exception $e) {
            echo $e->getMessage();
            Mage::logException($e);
            /* oror: Mage::log($e->getTraceAsString(), null, 'exception.log',
            true); */
        }
    }

}