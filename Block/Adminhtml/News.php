<?php
namespace Jeff\SimpleNews\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class News extends Container {
    protected function _construct() {
        $this->_controller = 'adminhtml_news'; //controller name
        $this->_blockGroup = 'Jeff_SimpleNews'; //Module name
        $this->_headerText = __('Manage Feed');
        $this->_addButtonLabel = __('Add Feed');
        parent::_construct();
    }
}
