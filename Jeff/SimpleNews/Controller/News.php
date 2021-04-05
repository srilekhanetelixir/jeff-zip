<?php
namespace Jeff\SimpleNews\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Jeff\SimpleNews\Helper\Data;
use Jeff\SimpleNews\Model\NewsFactory;

abstract class News extends Action 
{
    protected $_pageFactory;
    protected $_dataHelper;
    protected $_newsFactory;

    /*
        The order is always based on the parameters of the original constructor, extra parameters go in the end
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory, 
        \Jeff\SimpleNews\Helper\Data $helper, 
        \Jeff\SimpleNews\Model\NewsFactory $newsFactory
    ){
        $this->_pageFactory = $pageFactory;
        $this->_dataHelper = $helper;
        $this->_newsFactory = $newsFactory;
        parent::__construct($context);
    }

    public function dispatch(RequestInterface $request) {
        if($this->_dataHelper->isEnabledInFrontend()) {
            $result = parent::dispatch($request);
            return $result;
        }
        else {
            $this->_forward('noroute');
        }
    }
}
