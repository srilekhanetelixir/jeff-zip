<?php
namespace Jeff\SimpleNews\Block\Adminhtml\News\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Jeff\SimpleNews\Model\System\Config\Status;

class Feedsettings extends Generic implements TabInterface {
    protected $_wysiwygConfig;

    protected $_newsStatus;

    public function __construct(
        Context $context, 
        Registry $registry, 
        FormFactory $formFactory, 
        Config $wysiwygConfig, 
        Status $newsStatus, 
		\Jeff\SimpleNews\Model\Myvalues $myvaluess,
        array $data = [])
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_newsStatus = $newsStatus;
		$this->_myvaluess = $myvaluess;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm() {
        $model = $this->_coreRegistry->registry('simplenews_news');

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('news_');
        $form->setFieldNameSuffix('news');

        $fieldset = $form->addFieldset('base_fieldset', ['legend'=>__('General')]);

        if($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name'=>'id']);
        }

        $fieldset->addField(
            'color',
            'select',
            [
                'name' => 'color',
                'label' => __('Color'),
                'id' => 'color',
                'title' => __('Color'),
				//'values' => array('-1'=>'None,'1' => $this->_myvaluess ->toOptionArray()),
               // 'values' => $this->_myvaluess ->toOptionArray(),
				 "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'tax',
            'select',
            [
                'name' => 'tax',
                'label' => __('Tax Class'),
                'id' => 'tax_class',
                'title' => __('Tax Class'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr1',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'upc',
            'select',
            [
                'name' => 'upc',
                'label' => __('UPC'),
                'id' => 'upc',
                'title' => __('UPC'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr2',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'mpn',
            'select',
            [
                'name' => 'mpn',
                'label' => __('MPN'),
                'id' => 'mpn',
                'title' => __('MPN'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr3',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'gtin',
            'select',
            [
                'name' => 'gtin',
                'label' => __('GTIN'),
                'id' => 'gtin',
                'title' => __('GTIN'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr4',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'brand',
            'select',
            [
                'name' => 'brand',
                'label' => __('Brand'),
                'id' => 'brand',
                'title' => __('Brand'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr5',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'shipweight',
            'select',
            [
                'name' => 'shipweight',
                'label' => __('Shipping Weight'),
                'id' => 'shipping_weight',
                'title' => __('Shipping Weight'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr6',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'adult',
            'select',
            [
                'name' => 'adult',
                'label' => __('Adult'),
                'id' => 'adult',
                'title' => __('Adult'),
                'values' => [
					['label' => __('No'), 'value' => 'No'],
					['label' => __('Yes'), 'value' => 'Yes']
				],
                'class' => 'attr7',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'gender',
            'select',
            [
                'name' => 'gender',
                'label' => __('Gender'),
                'id' => 'gender',
                'title' => __('Gender'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr8',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'size',
            'select',
            [
                'name' => 'size',
                'label' => __('Size'),
                'id' => 'size',
                'title' => __('Size'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr9',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'material',
            'select',
            [
                'name' => 'material',
                'label' => __('Material'),
                'id' => 'material',
                'title' => __('Material'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr10',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'pattern',
            'select',
            [
                'name' => 'pattern',
                'label' => __('Pattern'),
                'id' => 'pattern',
                'title' => __('Pattern'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr11',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'customlabelzero',
            'select',
            [
                'name' => 'customlabelzero',
                'label' => __('Custom Label Zero'),
                'id' => 'custom_label_zero',
                'title' => __('Custom Label Zero'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr12',
                'required' => true
            ]
        );
		$fieldset->addField(
            'content',
            'select',
            [
                'name' => 'content',
                'label' => __('Google Product Category'),
                'id' => 'custom_label_zero',
                'title' => __('Google Product Category'),
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr13',
                'required' => true
            ]
        );
		
		$fieldset->addField(
            'product',
            'select',
            [
                'name' => 'product',
                'label' => __('Age Group'),
                'id' => 'custom_label_zero',
                'title' => __('Age Group'),
				/* 'values' => [
					['label' => __('No'), 'value' => 'No'],
					['label' => __('Yes'), 'value' => 'Yes']
				], */
                "values"    =>      [
                    ["value" => "none","label" => __("None")],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr13',
                'required' => true
            ]
        );
		
				
		$fieldset->addField(
            'condition',
            'select',
            [
                'name' => 'condition',
                'label' => __('Condition'),
                'id' => 'condition',
                'title' => __('Condition'),
                'values' => [
					['label' => __('New'), 'value' => 'new'],
					['label' => __('Refurbished'), 'value' => 'refurbished'],
					['label' => __('Used'), 'value' => 'used'],
                    ["value" => $this->_myvaluess ->toOptionArray(),"label" => __("Product Attributes")],
                ],
                'class' => 'attr14',
                'required' => true
            ]
        );
		
        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();

    }

    public function getTabLabel() {
        return __('News Info');
    }

    public function getTabTitle() {
        return __('News Info');
    }

    public function canShowTab() {
        return true;
    }

    public function isHidden() {
        return false;
    }
}