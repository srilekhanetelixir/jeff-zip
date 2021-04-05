<?php
namespace Jeff\SimpleNews\Controller\Adminhtml\News;

use Jeff\SimpleNews\Controller\Adminhtml\News;

class Index extends News {
    public function execute() {
        if($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Jeff_SimpleNews::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('LXR Product Feed'));

        return $resultPage;
    }
}