<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 14.12.17.
 * Time: 14:39
 */

class Inchoo_Faq_Block_Faq_Renderer_Frontendvisibility extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $content = (string)$row->getData($this->getColumn()->getIndex());

        switch ($content) {
            case '0':
                return 'Pending';
            case '1':
                return 'Approved';
            default:
                return 'Not Approved';
        }
    }
}