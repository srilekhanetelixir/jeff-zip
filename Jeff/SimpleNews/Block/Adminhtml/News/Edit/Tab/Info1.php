<?php
namespace Jeff\SimpleNews\Block\Adminhtml\News\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Jeff\SimpleNews\Model\System\Config\Status;

class Info1 extends Generic implements TabInterface {
    protected $_wysiwygConfig;

    protected $_newsStatus;

    public function __construct(
        Context $context, 
        Registry $registry, 
        FormFactory $formFactory, 
        Config $wysiwygConfig, 
        Status $newsStatus, 
		\Jeff\SimpleNews\Model\Price $poptions,
		\Jeff\SimpleNews\Model\Myvalues $myvaluess,
		\Jeff\SimpleNews\Model\Categories $allcategories,
        array $data = [])
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_newsStatus = $newsStatus;
		$this->_poptions = $poptions;
		$this->_myvaluess = $myvaluess;
		$this->_allcategories = $allcategories;
        parent::__construct($context, $registry, $formFactory, $data);
    }
/* protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('Jeff_Example::CategorisCollection.phtml');
    } */
	public function getFormHtml()
    {
       // get the current form as html content.
        $html = parent::getFormHtml();
        //Append the phtml file after the form content.
        $html .= $this->setTemplate('Jeff_SimpleNews::demo/demo.phtml')->toHtml(); 
        return $html;
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

        //$fieldset->addField('title', 'text', ['name'=>'title', 'label' => __('Titles'), 'required' => true ]);
		
		$optionArrayss = $this->_allcategories->toOptionArray();
		
		$fieldset->addField(
            'product_categories',
            'multiselect',
            [
                'name' => 'product_categories[]',
                'label' => __('Product categories'),
                'id' => 'product_categories',
                'title' => __('Product categories'),
                'values' => $optionArrayss,
                'class' => 'attr',
                'required' => true
            ]
        );
        //$fieldset->addField('summary', 'textarea', ['name'=>'summary', 'label' => __('Summary'), 'required' => true ]);

        //$wysiwygConfig = $this->_wysiwygConfig->getConfig();
        //$fieldset->addField('description1', 'editor', ['name'=>'description1', 'label' => __('Description1'), 'required' => true, 'config' => $wysiwygConfig ]);
    
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