<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 27.11.17.
 * Time: 08:09
 */

class Inchoo_Faq_Model_Resource_Faq extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_faq/faq', 'question_id');
    }
}