<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 27.11.17.
 * Time: 08:09
 */

class Inchoo_ProductFaq_Model_Resource_Question extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_productfaq/question', 'question_id');
    }

}