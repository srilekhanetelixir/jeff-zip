<?php
namespace Jeff\SimpleNews\Block\Adminhtml\News\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

/** This file will declare tabs at left column of the editing page */
class Tabs extends WidgetTabs {
    protected function _construct() {
        parent::_construct();
        $this->setId('news_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Feed Information'));
    }

    protected function _beforeToHtml() {
        $this->addTab('news_info',
            [
                'label' => __('Product Filter'),
                'title' => __('Product Filter'),
                'content' => $this->getLayout()->createBlock('Jeff\SimpleNews\Block\Adminhtml\News\Edit\Tab\Info')->toHtml(),
                'active' => true
            ]
        );
		$this->addTab('news_info1',
            [
                'label' => __('Product Category Filter'),
                'title' => __('Product Category Filter'),
                'content' => $this->getLayout()->createBlock('Jeff\SimpleNews\Block\Adminhtml\News\Edit\Tab\Info1')->toHtml(),
                'active' => false
            ]
        );
		$this->addTab('feed_settings',
            [
                'label' => __('Feed Settings'),
                'title' => __('Feed Settings'),
                'content' => $this->getLayout()->createBlock('Jeff\SimpleNews\Block\Adminhtml\News\Edit\Tab\Feedsettings')->toHtml(),
                'active' => false
            ]
        );

        return parent::_beforeToHtml();
    }
}
