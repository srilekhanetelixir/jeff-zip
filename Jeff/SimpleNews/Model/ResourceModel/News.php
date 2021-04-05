<?php
namespace Jeff\SimpleNews\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class News extends AbstractDb {
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
    protected function _construct() {
        $this->_init('tutorial_simplenews', 'id');
    }
}
