<?php
namespace Jeff\SimpleNews\Block;

use Magento\Framework\App\Filesystem\DirectoryList;

class Subcategory extends \Magento\Framework\View\Element\Template
{
    protected $categoryFactory;
    protected $layerResolver;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,  
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        array $data = []
    ) {
        $this->categoryFactory = $categoryFactory;   
        $this->_catalogLayer = $layerResolver->get();
        parent::__construct(
            $context,
            $data
        );
    }

    public function getCurrentCategoryInfo(){
        $categories = $this->_catalogLayer->getCurrentCategory()->getChildrenCategories();
        return $categories;
    }

    public function getCategoryData($id){
        return $category = $this->categoryFactory->create()->load($id);       
    }

    public function subCategory($id){
        $category = $this->getCategoryData($id);
        $childs = $category->getChildrenCategories();
        foreach($childs as $child){
            $subchild[] = $child->getData();
        }
        return $subchild;
    }
}