<?php
namespace Jeff\SimpleNews\Controller\Index;

use Jeff\SimpleNews\Controller\News;

class View extends News {
    public function execute() {
        $newsId = $this->getRequest()->getParam('id');

        $news = $this->_newsFactory->create()->load($newsId);

        $this->_objectManager->get('Magento\Framework\Registry')->register('newsData', $news);

        $pageFactory = $this->_pageFactory->create();

        $pageFactory->getConfig()->getTitle()->set($news->getTitle());

        $breadcrumbs = $pageFactory->getLayout()->getBlock('breadcrumbs');
        $breadcrumbs->addCrumb('home', ['label' => __('Home'), 'title'=>__('Home'), 'link' => $this->_url->getUrl('')]);
        $breadcrumbs->addCrumb('simplenews', ['label' => __('LXR Product Feed'), 'title'=>__('LXR Product Feed'), 'link' => $this->_url->getUrl('news')]);
        $breadcrumbs->addCrumb('news', ['label' => $news->getTitle(), 'title'=>$news->getTitle()]);

        return $pageFactory;
    }
}
