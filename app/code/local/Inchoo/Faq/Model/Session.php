<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 01.12.17.
 * Time: 11:25
 */

class Inchoo_Faq_Model_Session extends Mage_Core_Model_Session_Abstract
{
    public function __construct()
    {
        $this->init('faq');
    }
}