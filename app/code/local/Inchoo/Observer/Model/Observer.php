<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 19.12.17.
 * Time: 12:08
 */

class Inchoo_Observer_Model_Observer
{
    public function intercept($observer)
    {
        $event = $observer->getEvent();
        $question = $event->getQuestion();
        $product = $event->getProductId();
        $customer = $event->getCustomerId();

        Mage::log("OBSERVER LOG ", null, 'observer_log.log', true);

        $file = 'event_observer_test.txt';
        $current = file_get_contents($file);
        $current .= "[" . date('d-m-Y H:i:s', time()) . "] OBSERVER LOG \nQuestion " . $question . "\nProduct " . $product . "\nCustomer " . $customer . "\n";
        file_put_contents($file, $current);

        /*
         * Loads the html file named 'custom_email_template1.html' from
         * app/locale/en_US/template/email/activecodeline_custom_email1.html
         */
        $emailTemplate = Mage::getModel('core/email_template')
            ->loadDefault('inchoo_faq_submitted_email_template');

        //Create an array of variables to assign to template
        $emailTemplateVariables = array();
        $emailTemplateVariables['question'] = $question;
        $emailTemplateVariables['product'] = $product;
        $emailTemplateVariables['customer'] = $customer;

        /**
         * The best part 🙂
         * Opens the activecodeline_custom_email1.html, throws in the variable array
         * and returns the 'parsed' content that you can use as body of email
         */
        $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

        /*
         * Or you can send the email directly,
         * note getProcessedTemplate is called inside send()
         */
        $mail = Mage::getModel('core/email')
            ->setToName('Pink Panther')
            ->setToEmail('pink.panther@inchoo.net')
            ->setBody($processedTemplate)
            ->setSubject('New product question submitted')
            ->setFromEmail('admin@magento.com')
            ->setFromName('Magento Admin')
            ->setType('html');

        try {

//            $mail->send('pink.panther@inchoo.net', 'Pink Panther', $emailTemplateVariables);
            $mail->send();

//            Mage::getSingleton('core/session')->addSuccess(Mage::helper('inchoo_observer')->__('Email was succesfully sent.'));

        } catch (Exception $e) {
            $file = 'event_observer_test.txt';
            $current = file_get_contents($file);
            $current .= "[" . date('d-m-Y H:i:s', time()) . "] OBSERVER LOG ERROR " . $e->getMessage() . "\n";
            file_put_contents($file, $current);

//            throw new Exception($e->getMessage());

            Mage::getSingleton('core/session')->addError($e->getMessage());
        }

    }
}