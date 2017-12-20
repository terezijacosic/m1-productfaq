<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 27.11.17.
 * Time: 08:17
 */

class Inchoo_ProductFaq_Model_Resource_Question_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct($resource = null)
    {
        $this->_init('inchoo_productfaq/question');
    }

}