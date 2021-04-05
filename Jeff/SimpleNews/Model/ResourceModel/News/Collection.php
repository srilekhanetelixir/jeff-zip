<?php
namespace Jeff\SimpleNews\Model\ResourceModel\News;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
    protected function _construct() {
        $this->_init('Jeff\SimpleNews\Model\News', 'Jeff\SimpleNews\Model\ResourceModel\News');
    }
}
