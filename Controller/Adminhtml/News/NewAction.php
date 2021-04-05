<?php
namespace Jeff\SimpleNews\Controller\Adminhtml\News;

use Jeff\SimpleNews\Controller\Adminhtml\News;

class NewAction extends News {
    public function execute() {
        $this->_forward('edit');
    }
}
