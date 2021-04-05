<?php
namespace Jeff\SimpleNews\Block\Adminhtml\News\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Jeff\SimpleNews\Model\System\Config\Status;

class Info extends Generic implements TabInterface {
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

        $fieldset->addField('title', 'text', ['name'=>'title', 'label' => __('Feed Name'), 'required' => true ]);
        $fieldset->addField('file_name', 'text', ['name'=>'file_name', 'label' => __('Feed File Name'), 'required' => true ]);
		$fieldset->addField(
			'status',
			'select',
			[
				'name' => 'status',
				'label' => __('status'),
				'title' => __('Status'),
				'class' => 'main_acount',
				'values' => [
					['label' => __('Enable'), 'value' => '1'],
					['label' => __('Disable'), 'value' => '0']
				]
			]
		);
		$fieldset->addField('begins_with', 'textarea', ['name'=>'begins_with', 'label' => __('Product Name Beginning with(Seperated by commas)')]);
		$fieldset->addField('contains_with', 'textarea', ['name'=>'contains_with', 'label' => __('Product Name Containing with(Seperated by commas)')]);
		$fieldset->addField(
			'feedprice',
			'select',
			[
				'name' => 'feedprice',
				'label' => __('Price Type'),
				'title' => __('Price Type'),
				'class' => 'main_acount',
				'values' => [
					['label' => __('All'), 'value' => 'all'],
					['label' => __('Actual Price'), 'value' => 'Actual Price'],
					['label' => __('Special Price'), 'value' => 'Special Price']
				]
			]
		);
		$fieldset->addField(
			'pricerange',
			'select',
			[
				'name' => 'pricerange',
				'label' => __('Price Range Option'),
				'title' => __('Price Range Option'),
				'class' => 'main_acount',
				'values' => [
					['label' => __('All'), 'value' => 'all'],
					['label' => __('Less Than'), 'value' => 'lt'],
					['label' => __('Greater Than'), 'value' => 'gt'],
					['label' => __('Less than or equal'), 'value' => 'le'],
					['label' => __('Greater than or equal'), 'value' => 'ge'],
					['label' => __('Price Range Between (Ex: from-to)'), 'value' => 'bt']
				]
			]
		);
		$fieldset->addField('pricevalue', 'text', ['name'=>'pricevalue', 'label' => __('Price Range Value') ]);
		
				
		$fieldset->addField(
			'stock_availability',
			'select',
			[
				'name' => 'stock_availability',
				'label' => __('Stock Availability'),
				'title' => __('Stock Availability'),
				'class' => 'main_acount',
				'values' => [
					['label' => __('All'), 'value' => 'all'],
					['label' => __('In Stock'), 'value' => '1'],
					['label' => __('Out of Stock'), 'value' => '0']
				]
			]
		);
		$fieldset->addField(
			'stock_range',
			'select',
			[
				'name' => 'stock_range',
				'label' => __('Stock Range Option'),
				'title' => __('Stock Range Option'),
				'class' => 'main_acount',
				'values' => [
					['label' => __('All'), 'value' => 'all'],
					['label' => __('Less Than'), 'value' => 'lt'],
					['label' => __('Greater Than'), 'value' => 'gt']
				]
			]
		);
		$fieldset->addField('stock_value', 'text', ['name'=>'stock_value', 'label' => __('Stock Range Value') ]);
		
		
         /*$fieldset->addField('status', 'select', ['name'=>'status', 'label' => __('Status'), 'options' => $this->_newsStatus->toOptionArray() ]);
        $wysiwygConfig = $this->_wysiwygConfig->getConfig();
        $fieldset->addField('description', 'editor', ['name'=>'description', 'label' => __('Description'), 'required' => true, 'config' => $wysiwygConfig ]);*/
    
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