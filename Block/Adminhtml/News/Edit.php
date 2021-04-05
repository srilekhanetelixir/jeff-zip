<?php
namespace Jeff\SimpleNews\Block\Adminhtml\News;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

/* This is the block file of form container */
class Edit extends Container {
    protected $_coreRegistry = null;

    public function __construct(Context $context, Registry $registry, array $data = []) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct() {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_news';
        $this->_blockGroup = 'Jeff_SimpleNews';

        parent::_construct();

        //$this->buttonList->update('delete', 'label', __('Delete'));
		$this->buttonList->update('save', 'label', __('Save'));
		/* $this->buttonList->add(
            'generateincsv',
            [
                'label' => __('Generate in CSV'),
                'class' => 'save',
                 'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'generateincsv', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        ); */
		
		$feedid= $this->_request->getParam('id');
		if ($feedid!='')
		{
			$this->addButton(
				'generateincsv', [
				'label' => __('Generate CSV Feed'),
				'class' => 'send-email',
				'onclick' => 'confirmSetLocation(\'' . __(
						'Are you sure you want to generate CSV feed?'
				) . '\', \'' . $this->getEmailUrl() . '\')'
					]
			);	 
			$this->addButton(
					'generateinxml', [
				'label' => __('Generate XML Feed'),
				'class' => 'send-email',
				'onclick' => 'confirmSetLocation(\'' . __(
						'Are you sure you want to generate XML feed?'
				) . '\', \'' . $this->getEmailUrls() . '\')'
					]
			);
		}
		
		/* $this->buttonList->add(
            'generateinxml',
            [
                'label' => __('Generate in XML'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'generateinxml', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        ); */
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );
        //$this->buttonList->remove('delete');
    }

    public function getHeaderText() {
        $newsRegistry = $this->_coreRegistry->registry('simplenews_news');

        if($newsRegistry->getId()) {
            $newsTitle = $this->escapeHtml($newsRegistry->getTitle());
            return __("Edit Feed '%1'", $newsTitle);
        }
        else {
            return __('Add Feed');
        }
    }
	protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

	protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('simplenews/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }
	protected function _getGenerateincsvUrl()
    {
        return $this->getUrl('simplenews/*/generatecsv', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }
	protected function _getGenerateinxmlUrl()
    {
        return $this->getUrl('simplenews/*/generatexml', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }
	
	public function getEmailUrl() {
		$newsRegistry = $this->_coreRegistry->registry('simplenews_news');
        return $this->getUrl('simplenews/*/generatecsv', ['id' => $this->_request->getParam('id')]);
    }
	public function getEmailUrls() { 
		$newsRegistry = $this->_coreRegistry->registry('simplenews_news');
        return $this->getUrl('simplenews/*/generatexml', ['id' => $this->_request->getParam('id')]);
    }
	

    protected function _prepareLayout() {
        $this->_formScripts[] = "
            function toggleEditor() {
                if(tinyMCE.getInstanceById('post_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'post_content');
                }
                else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'post_content');
                }
            };
        ";

        return parent::_prepareLayout();
    }
}