<?php
namespace Jeff\SimpleNews\Block;

use Magento\Framework\View\Element\Template;
use Jeff\SimpleNews\Helper\Data;
use Jeff\SimpleNews\Model\NewsFactory;

class NewsList extends \Magento\Framework\View\Element\Template
{
    protected $_newsFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context, 
        NewsFactory $newsFactory, 
        array $data = []
    ) {
        $this->_newsFactory = $newsFactory;
        parent::__construct($context, $data);
    }

    protected function _construct() {
        parent::_construct();
        $collection = $this->_newsFactory->create()->getCollection()->setOrder('id', 'DESC');
        $this->setCollection($collection);
    }

    protected function _prepareLayout(){
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'simplenews.news.list.pager');

        $pager->setLimit(5)->setShowAmount(false)->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();

        return $this;
    }

    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }
}