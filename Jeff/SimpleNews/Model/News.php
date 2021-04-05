<?php
namespace Jeff\SimpleNews\Model;

use Magento\Framework\Model\AbstractModel;

class News extends AbstractModel implements \Magento\Framework\DataObject\IdentityInterface{
	
	const CACHE_TAG = 'tutorial_simplenews';

	protected $_cacheTag = 'tutorial_simplenews';

	protected $_eventPrefix = 'tutorial_simplenews';
	
    protected function _construct() {
        /** @var resourceModel classname */
        $this->_init('Jeff\SimpleNews\Model\ResourceModel\News');
    }
	
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
	
}
