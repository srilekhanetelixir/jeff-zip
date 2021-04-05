<?php
namespace Jeff\SimpleNews\Block\Adminhtml\News\Edit\Tab;

class Child extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Backend\Block\Widget\Form\Renderer\Fieldset
     */
    protected $_rendererFieldset;
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    protected $_customerFactory;    
    protected $_resource;   

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Backend\Block\Widget\Form\Renderer\Fieldset $rendererFieldset,
        \Magento\Customer\Model\CustomerFactory $customerFactory,   
        \Magento\Framework\App\ResourceConnection $resource,  
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_rendererFieldset = $rendererFieldset;
        $this->_customerFactory = $customerFactory;  
        $this->_resource = $resource;  
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /* @var $model \Magefan\Blog\Model\Category */
        $model = $this->_coreRegistry->registry('current_model');

        /*
         * Checking if user have permissions to save information
         */
        $isElementDisabled = !$this->_isAllowedAction('Jeff_SimpleNews::child');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('child_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Add Your Child')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField(
            'html', 
            'text', 
            [
                'name' => 'html',
                'label' => __('Html Content'),
                'title' => __('Html Content'),
                'required' => true,
                'disabled' => $isElementDisabled                 
            ]
        )->setRenderer($this->_rendererFieldset->setTemplate('Jeff_SimpleNews::CategorisCollection.phtml'));   

        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '0' : '1');
        }                       
        $this->_eventManager->dispatch('Jeff_SimpleNews_edit_tab_main_prepare_form', ['form' => $form]);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Html Content');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Html Content');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}