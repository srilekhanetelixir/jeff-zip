<?php

namespace Jeff\SimpleNews\Model;
    use Magento\Store\Model\StoreManagerInterface;
    use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;

class Myvalues implements \Magento\Framework\Option\ArrayInterface
{
         public function __construct(
            CollectionFactory $collectionFactory,
            \Magento\Framework\ObjectManagerInterface $objectManager
        ) {
           $this->_collectionFactory = $collectionFactory;
            $this->_objectManager = $objectManager;
        }


    public function toOptionArray()
    {
		$attributes = $this->getAttributes();
        return  $attributes;
    }



	 public function getAttributes() {
        
         $collection = $this->_collectionFactory->create();
         
         $attr_groups = array();
          
        foreach ($collection as $item) {
         $attr_groups[] = ['value' => $item->getData()['attribute_code'], 'label' => $item->getData()['frontend_label']];
        }

        return $attr_groups; 
    } 

/* protected $_attributeFactory;

public function __construct(
\Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attributeFactory

){
	parent::__construct($context);
	$this->_attributeFactory = $attributeFactory;
}

 public function toOptionArray()
    {
		$attributes = $this->getallattributes();
        return  $attributes;
    }
	

public function getallattributes()
{
    $attribute_data = [];
    $attributeInfo = $this->_collectionFactory->create()
    foreach ($attributeInfo as $items) {
            $attribute_data[] = $items->getData();
        }
   }
   return $attribute_data;
} */
 
 
}