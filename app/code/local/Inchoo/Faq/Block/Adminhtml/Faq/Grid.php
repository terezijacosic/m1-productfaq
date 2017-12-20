<?php
/**
 * Created by PhpStorm.
 * User: terezija
 * Date: 08.12.17.
 * Time: 08:47
 */

class Inchoo_Faq_Block_Adminhtml_Faq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('inchoo_faq_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
//      ćć ZAŠTO KADA JE OVO POSTAVLJENO MI NE RADI FILTER i udvostruči se cijeli admin panel?
//      $this->setUseAjax(true);
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            echo "Nismo mogli dobiti vrijednost fitera!";
            die();
            return;
        }
        echo "Ide u getCollection()";
        die();
        $this->getCollection()->addAdminStoreFilter($value);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('inchoo_faq/faq_collection');
//            ->addCustomerNameToId();

        $collection->getSelect()
            ->join('catalog_product_entity_varchar',
                'main_table.product_id = catalog_product_entity_varchar.entity_id and catalog_product_entity_varchar.attribute_id = \'71\'', array(
                    'product_name' => 'value',
                )
            )
            ->join('customer_entity',
                'main_table.customer_id = customer_entity.entity_id', array(
                    'email' => 'email',
                )
            )
            ->join('core_store',
                'main_table.store_id = core_store.store_id', array(
                    'name' => 'name',
                )
            );

//        BAUHAUS primjer
//        $collection->getSelect()->join('sales_flat_shipment', 'main_table.entity_id = sales_flat_shipment.entity_id',array(
//            'komisionirano'=>'komisionirano',
//            'skladiste' =>'skladiste',
//            'stock_removal' =>'stock_removal',
//            'rffcr' =>'rffcr' )
//        );

        $this->setCollection($collection);

        return parent::_prepareCollection();

//        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('question_id', array(
            'header' => $this->__('ID'),
            'index' => 'question_id'
        ));

        $this->addColumn('created_at', array(
            'header' => $this->__('Created'),
            'index' => 'created_at',
            'type' => 'datetime'
        ));

//        $this->addColumn('product_id', array(
//            'header' => $this->__('Product'),
//            'index' => 'product_id',
//            'type' => 'number'
//        ));

        $this->addColumn('product_name', array(
            'header' => $this->__('Product Name'),
            'index' => 'product_name',
            'filter_index' => 'catalog_product_entity_varchar.value'
        ));

        $this->addColumn('question', array(
            'header' => $this->__('Question'),
            'index' => 'question',
            'type' => 'text'
        ));

        $this->addColumn('answer', array(
            'header' => $this->__('Answer'),
            'index' => 'answer',
            'type' => 'text'
        ));

//        $this->addColumn('customer_id', array(
//            'header' => $this->__('Customer'),
//            'index' => 'customer_id',
//        ));

        $this->addColumn('email', array(
            'header' => $this->__('Customer Email'),
            'index' => 'email',
            'filter_index' => 'customer_entity.email',
            'type' => 'text'
        ));

//        ćć options filter ??
        $this->addColumn('store_id', array(
            'header' => $this->__('Store'),
            'index' => 'store_id',
            'filter_index' => 'main_table.store_id',
            'type' => 'store',
            'store_view' => true,
//            'sortable' => true,
//            'filter_condition_fallback' => array($this, '_filterStoreCondition')
        ));

        $this->addColumn('is_visible', array(
            'header' => $this->__('Visible on Frontend'),
            'index' => 'is_visible',
            'renderer' => new Inchoo_Faq_Block_Faq_Renderer_Frontendvisibility(),
//            'filter' => 'adminhtml/widget_grid_column_filter_select'
//            'filter'    => 'adminhtml/faq_filter_type',
            'type' => 'options',
            'options' => Mage::helper('inchoo_faq')->getFaqStatuses(),

        ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('adminhtml')->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getQuestionId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('adminhtml')->__('Edit'),
                        'url' => array(
                            'base' => '*/faq/edit',
                            'params' => array(
                                'productId' => $this->getProductId(),
                                'customerId' => $this->getCustomerId()
                            )
                        ),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false
            ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('question_id');
        $this->getMassactionBlock()->setFormFieldName('question_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('inchoo_faq')->__('Delete'),
            'url'  => $this->getUrl('*/faq/massDelete', array('' => '')),
            'confirm' => Mage::helper('inchoo_faq')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($item)
    {
//        return parent::getRowUrl($item);
        $this->getUrl('*/*/edit', array('id' => $item->getId()));
    }

}