<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 23.11.17.
 * Time: 13:47
 */

class Inchoo_HelloWorld_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        echo 'Hello world!';
    }

//  http://magento1.loc/helloworld/index/sayHello
    public function sayHelloAction()
    {
        echo 'Hello one more time!';
    }

}