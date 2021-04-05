<?php
namespace Jeff\SimpleNews\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class View extends Template {
    protected $_coreRegistry;

    public function __construct( Template\Context $context, Registry $coreRegistry, array $data =[]) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    public function getNewsInformation() {
        return $this->_coreRegistry->registry('newsData');
    }
}
