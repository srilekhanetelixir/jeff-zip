<?php
namespace Jeff\SimpleNews\Controller\Adminhtml\News;

use Jeff\SimpleNews\Controller\Adminhtml\News;

class Delete extends News {
    public function execute() {
        $newsId = (int) $this->getRequest()->getParam('id');

        if($newsId) {
            $newsModel = $this->_newsFactory->create();
            $newsModel->load($newsId);


            //Check if this news exists
            if(!$newsModel->getId()) {
                $this->messageManager->addError(__('This news no longer exists.'));
            }
            else {
                try {
                    $newsModel->delete();
                    $this->messageManager->addSuccess(__('The news has been deleted.'));

                    $this->_redirect('*/*/');
                    return;
                }
                catch(\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', ['id' => $newsModel->getId()]);
                }
            }
        }
    }
}
