<?php

namespace Jeff\SimpleNews\Model;
    use Magento\Store\Model\StoreManagerInterface;
    use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;

class Categories implements \Magento\Framework\Option\ArrayInterface
{
        protected $_categories;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collection)
    {
        $this->_categories = $collection;
    }

    public function toOptionArray()
    {

        $collection = $this->_categories->create();
        $collection->addAttributeToSelect('*')->addFieldToFilter('is_active', 1);
        $itemArray = array('value' => '', 'label' => '--Please Select--');
        $options = [];
        foreach ($collection as $category) {
            $options[] = ['value' => $category->getId(), 'label' => $category->getName()];
        }
        return $options;
    }

}
 
