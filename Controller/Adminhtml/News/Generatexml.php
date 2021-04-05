<?php
namespace Jeff\SimpleNews\Controller\Adminhtml\News;

use Jeff\SimpleNews\Controller\Adminhtml\News;

/** This is the edit action for editing news page */
class Generatexml extends News 
{
    public function execute() 
	{
		$newsId = (int) $this->getRequest()->getParam('id');

		//$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		//$model = $objectManager->create('\Jeff\SimpleNews\Model\Modelname');		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
		$rootPath  =  $directory->getPath('media').'/lxrfeedfiles/';		
        
        if($newsId) 
		{
            $newsModel = $this->_newsFactory->create();
            $newsModel->load($newsId);
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$currencysymbol = $objectManager->get('Magento\Directory\Model\Currency');
			$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
			$store = $storeManager->getStore();			
			$currency_code= $store->getCurrentCurrencyCode();
			
			
			//$collection = $newsModel->getCollection()->addFieldToFilter('id', $newsId);
			//print_r($collection);
			$x           = $newsModel->getFileName();
            $pc          = $newsModel->getData('product_categories');
            $catinput    = '01';
            $catarray1   = Array(
                $catinput
            );
            $catarray2   = explode(',', $pc);
            $catarray3   = array_diff($catarray2, $catarray1);
            $pc          = implode(',', $catarray3);
            $saleprice   = $newsModel->getData('feedprice');
            $pricerange  = $newsModel->getData('pricerange');
            $stockavail  = $newsModel->getData('stock_availability');
            $stockrange  = $newsModel->getData('stock_range');
            $stockvalue  = $newsModel->getData('stock_value');
            $attrpattern = $newsModel->getData('pattern');
            $attrbrand   = $newsModel->getData('brand');
            $attrcond    = $newsModel->getData('condition');
            $attrupc     = $newsModel->getData('upc');
            $pgtin       = $newsModel->getData('gtin');
            $customlabel = $newsModel->getData('customlabelzero');
            $pgender     = $newsModel->getData('gender');
            $padult      = $newsModel->getData('adult');
            $pmpn        = $newsModel->getData('mpn');
            $pricevalue  = $newsModel->getData('pricevalue');
            $gpc 		 = $newsModel->getData('content');
            $age 		 = $newsModel->getData('product');
            $substring   = substr_count($pricevalue, '-');
			 if ($substring != 0) {
                $input = $pricevalue;
                list($a, $b) = explode('-', $input);
            }
            substr($pricerange . $pricevalue, 0, 2);		
			
			$bwith           = $newsModel->getData('begins_with');
            $cwith           = $newsModel->getData('contains_with');
            $beginswith      = array();
            $containswith    = array();
            $beginswith      = explode(",", $bwith);
            $containswith    = explode(",", $cwith);
            $s               = explode(",", $pc);			
            $variable        = implode("','", $s);
            $comma_separated = "'" . $variable . "'";
            $t               = '';
            $bcount          = count($beginswith);
            $ccount          = count($containswith);
            $beginsid        = array();
            $csid            = array();
			echo "=======".$ccount."=======";
			$stockId = 'stock_id';
			$todayDate    = date('m/d/y');
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			 
			$productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
 
			$categoryCollectionFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');
			$categorycollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\Collection');
			$categoryCollection = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
			$categoryId = '12';
			$category = $categoryCollectionFactory->create()->load($categoryId);
			$collection = $productCollectionFactory->create();
			//echo $stockavail."==".$saleprice;
			if($bwith != '' && $cwith != '') 
			{
				//echo "Begins & Contains are not empty";
							
                for ($i = 0; $i < $bcount; $i++) 
				{				
					$collectionbw = $productCollectionFactory->create();	
					$collectionbw->addCategoriesFilter(array('in' => $s));					
					$collectionbw->addAttributeToSelect('*');
					$collectionbw->addAttributeToFilter('name', array('like' => $beginswith[$i].'%'));
					$collectionbw->addAttributeToSort('created_at', 'asc');
					$productCollectionb = $collectionbw;
					$productCollectionb->getSelect()->group('e.entity_id');
                    foreach ($productCollectionb as $product) {
                        $beginsid[] = $product->getId();
                    }
                }				
                for ($j = 0; $j < $ccount; $j++) 
				{                    				
					$collectioncw = $productCollectionFactory->create();	
					$collectioncw->addCategoriesFilter(array('in' => $s));					
					$collectioncw->addAttributeToSelect('*');
					$collectioncw->addAttributeToFilter('name', array('like' => '%' . $containswith[$j] . '%'));
					$collectioncw->addAttributeToSort('created_at', 'asc');				
					$productCollectionc = $collectioncw;
					$productCollectionc->getSelect()->group('e.entity_id');
                    foreach ($productCollectionc as $product) 
					{
                        $csid[] = $product->getId();
                    }
                }				
            } 
			else if ($bwith != '' && $cwith == '') 
			{
				$collectionbw = $productCollectionFactory->create();
				//echo "Begins not empty & Contains empty";
                for ($i = 0; $i < $bcount; $i++) 
				{                    				
					$collectionbw->addCategoriesFilter(array('in' => $s));					
					$collectionbw->addAttributeToSelect('*');
					$collectionbw->addAttributeToFilter('name', array('like' => $beginswith[$i] . '%'));
					$collectionbw->addAttributeToSort('created_at', 'asc');				
					$productCollectionb = $collectionbw;
					$productCollectionb->getSelect()->group('e.entity_id');					
                    foreach ($productCollectionb as $product) 
					{
                        $beginsid[] = $product->getId();
                    }
                }
            } 
			else if ($bwith == '' && $cwith != '') 
			{
				//echo "Begins empty & Contains not empty";
				$collectioncw = $productCollectionFactory->create();
                for ($j = 0; $j < $ccount; $j++) 
				{                    				
					$collectioncw->addCategoriesFilter(array('in' => $s));					
					$collectioncw->addAttributeToSelect('*');
					$collectioncw->addAttributeToFilter('name', array('like' => '%' . $containswith[$j] . '%'));
					$collectioncw->addAttributeToSort('created_at', 'asc');				
					$productCollectionc = $collectioncw;
					$productCollectionc->getSelect()->group('e.entity_id');
                    foreach ($productCollectionc as $product) 
					{
                        $csid[] = $product->getId();
                    }
                }	
            } 
			else 
			{	
					$collection = $productCollectionFactory->create();
					$collection->addCategoriesFilter(array('in' => $s));					
					$collection->addAttributeToSelect('*');					
					$collection->addAttributeToSort('created_at', 'asc');				
					$collection=$collection->getSelect()->group('e.entity_id');
            }			
			if ((count($beginsid) > 0) || (count($csid) > 0)) 
			{
                $proid = array_merge($beginsid, $csid);			
				$proid = array_unique($proid);
				$collection->addCategoriesFilter(array('in' => $s));					
				$collection->addAttributeToSelect('*');
				$collection->addAttributeToFilter('entity_id', array('in' => $proid));
				$collection->addAttributeToSort('created_at', 'asc');					
			}
			else 
			{	
				$collection = $productCollectionFactory->create();
				$collection->addCategoriesFilter(array('in' => $s));					
				$collection->addAttributeToSelect('*');
				$collection->addAttributeToSort('created_at', 'asc');
				$collection->getSelect()->group('e.entity_id');			
            }
						
			if ($stockavail != 'all') 
			{			
				$collection->joinField('qty', 'cataloginventory_stock_item', 'qty', 'product_id=entity_id', '{{table}}.stock_id="' . $stockavail . '"', 'left');
				$collection->addAttributeToSort('created_at', 'asc');                 
                if ($stockrange == 'lt') 
				{
					
					$collection->addAttributeToFilter('qty', array("lt" => $stockvalue));
					$collection->addAttributeToSort('created_at', 'asc');					
                } 
				else if ($stockrange == 'gt') 
				{
                   
					$collection->addAttributeToFilter('qty', array("gt" => $stockvalue));
					$collection->addAttributeToSort('created_at', 'asc');		 
                } 
				else 
				{
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');
                }
				if ($stockavail == '0')
				{
					$collection->setFlag('has_stock_status_filter', true);
					$collection->joinTable('cataloginventory_stock_item', 'product_id=entity_id', array('stock_status' => 'is_in_stock'));
					$collection->addAttributeToSelect('stock_status');
					$collection->addFieldToFilter('stock_status', ['eq' => 0]);
				}	
            } 
			else 
			{
				$collection->addAttributeToSort('created_at', 'asc');
				$collection->addAttributeToSelect('*');
            }
			if ($saleprice == 'Special Price')
			{
				$todayDate    = date('m/d/y');
				$tomorrow     = mktime(0, 0, 0, date('m'), date('d') + 1, date('y'));
				$tomorrowDate = date('m/d/y', $tomorrow);
				if ($pricerange == 'lt') {
					
					$collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');
					$collection->addAttributeToFilter('special_price', array(
						'lt' => $pricevalue
					));
					$collection->addAttributeToFilter('special_from_date', array(
						'date' => true,
						'to' => $todayDate
					));
					$collection->addAttributeToFilter('special_to_date', array(
						'or' => array(
							0 => array(
								'date' => true,
								'from' => $tomorrowDate
							),
							1 => array(
								'is' => new \Zend_Db_Expr('null')
							)
						)
					), 'left');
				} else if ($pricerange == 'gt') {
					$collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');
					$collection->addAttributeToFilter('special_price', array(
						'gt' => $pricevalue
					));
					$collection->addAttributeToFilter('special_from_date', array(
						'date' => true,
						'to' => $todayDate
					));
					$collection->addAttributeToFilter('special_to_date', array(
						'or' => array(
							0 => array(
								'date' => true,
								'from' => $tomorrowDate
							),
							1 => array(
								'is' => new \Zend_Db_Expr('null')
							)
						)
					), 'left');
					;
				}
				else if ($pricerange == 'le') 
				{
					$collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');
					$collection->addAttributeToFilter('special_price', array(
						'lteq' => $pricevalue
					));
					$collection->addAttributeToFilter('special_from_date', array(
						'date' => true,
						'to' => $todayDate
					));
					$collection->addAttributeToFilter('special_to_date', array(
						'or' => array(
							0 => array(
								'date' => true,
								'from' => $tomorrowDate
							),
							1 => array(
								'is' => new \Zend_Db_Expr('null')
							)
						)
					), 'left');
				}
				else if ($pricerange == 'ge')
				{
					$collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');
					$collection->addAttributeToFilter('special_price', array(
						'gteq' => $pricevalue
					));
					$collection->addAttributeToFilter('special_from_date', array(
						'date' => true,
						'to' => $todayDate
					));
					$collection->addAttributeToFilter('special_to_date', array(
						'or' => array(
							0 => array(
								'date' => true,
								'from' => $tomorrowDate
							),
							1 => array(
								'is' => new \Zend_Db_Expr('null')
							)
						)
					), 'left');
					;
				} 
				else if ($pricerange == 'bt') 
				{
					$collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');
					$collection->addAttributeToFilter('special_price', array(
						'from' => $a,
						'to' => $b
					));
					$collection->addAttributeToFilter('special_from_date', array(
						'date' => true,
						'to' => $todayDate
					));
					$collection->addAttributeToFilter('special_to_date', array(
						'or' => array(
							0 => array(
								'date' => true,
								'from' => $tomorrowDate
							),
							1 => array(
								'is' => new \Zend_Db_Expr('null')
							)
						)
					), 'left');
				}
				else 
				{
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');					
					$collection->addAttributeToFilter('special_from_date', array(
						'date' => true,
						'to' => $todayDate
					));
					$collection->addAttributeToFilter('special_to_date', array(
						'or' => array(
							0 => array(
								'date' => true,
								'from' => $tomorrowDate
							),
							1 => array(
								'is' => new \Zend_Db_Expr('null')
							)
						)
					), 'left');
                }
			} 
			else 
			{
				if ($pricerange == 'lt') {
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToFilter('price', array(
                        'lt' => $pricevalue
                    ));
                } else if ($pricerange == 'gt') {
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToFilter('price', array(
                        'gt' => $pricevalue
                    ));
                } else if ($pricerange == 'le') {
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToFilter('price', array(
                        'lteq' => $pricevalue
                    ));
                } else if ($pricerange == 'gt') {
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToFilter('price', array(
                        'gteq' => $pricevalue
                    ));
                } else if ($pricerange == 'bt') {
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToFilter('price', array(
                        'from' => $a,
                        'to' => $b
                    ));
                } else {
                    $collection->addAttributeToSort('created_at', 'asc');
					$collection->addAttributeToSelect('*');
                }
			}		
			//echo count($beginsid);						
			/*$csv     = '';
            $content = array(
                "id",
                "title",
                "brand",
                "description",
                "short_description",
                "price",
                "image_link",
                "additional_image_link",
                "upc",
                "gtin",
                "mpn",
                "shipping_weight",
                "link",
                "product_type",
                "google_product_category",
                "identifier_exists",
                "adult",
                "age_group",
                "gender",
                "availability",
                "condition",
                "custom_label_0",
                "shipping(price)",
                "color",
                "size",
                "quantity",
                "is_bundle",
                "tax(rate)",
                "pattern"
            );*/
			$doc = new \DOMDocument('1.0', 'UTF-8');
			$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
			$domain=$_SERVER['SERVER_NAME'];
			$url = "http://localhost/magento3/";
			$xmlRoot = $doc->createElement("rss");
			$xmlRoot = $doc->appendChild($xmlRoot);
			$xmlRoot->setAttribute('version', '2.0');
			$xmlRoot->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', "http://base.google.com/ns/1.0");
			$channelNode = $xmlRoot->appendChild($doc->createElement('channel'));
			$channelNode->appendChild($doc->createElement('title', 'Product Feed'));
			$channelNode->appendChild($doc->createElement('link', $url));
			$feed_products = array();
			/*$data    = array();
            foreach ($content as $column) {
                $data[] = '"' . $column . '"';
            }
            $csv .= implode(',', $data) . "\n";*/
			foreach ($collection as $product) 
			{
				$_Product = $objectManager->create('Magento\Catalog\Model\Product')->load($product->getId());
				$color       = $_Product->getAttributeText('color');
                $categoryIds = $_Product->getCategoryIds(); //array of product categories	
				
				$categories = $categoryCollection->create();
				$categories->addAttributeToSelect('*');
                $categories->addAttributeToFilter('entity_id', $categoryIds);
				$holder = array();
					foreach ($categories as $category) {
						
						$holder[]= $category->getName();
					}
				if ($attrbrand == 'none' || $attrbrand == '') 
				{
                    $brand = '';
                } else 
				{
                    $brand = $_Product->getAttributeText($attrbrand);
					if(empty($brand))
					{						
						$brand= '';
					}
					else
					{
						if(is_array($brand))
						{
							$brand= $brand[0];	
						}
						else{$brand= $brand;}
					}					
                }
                if ($age == 'adult' || $age == '') {
                    $age = $age;
                } else {
                    //$age = $_Product->getAttributeText($age);
                    $age = 'adult';
                } 
                if ($attrpattern == 'none' || $attrpattern == '') {
                    $pattern = '';
                } else {
                    $pattern = $_Product->getAttributeText($attrpattern);
					if(is_array($pattern))
					{						
						$pattern= $pattern[0];							
					}
					else
					{
						if(empty($pattern))
						{						
							$pattern= '';
						}
						else
						{
							if(is_array($pattern))
							{
								$pattern= $pattern[0];	
							}
							else{$pattern= $pattern;}
						}
					}
                }
                if ($pgtin == 'none' || $pgtin == '') {
                    $gtinval = '';
                } else {
                    $gtinval = $_Product->getData($pgtin);
					
                }
                if ($customlabel == 'none' || $customlabel == '') {
                    $custval = '0';
                } else {
                    $custval = $_Product->getData($customlabel);
                }
				
                if ($attrupc == 'none' || $attrupc == '') {
                    $attriupc = '';
                } else {
                    $attriupc = $_Product->getData($attrupc);
                }
                if ($pmpn == 'none' || $pmpn == '') {
                    $mpnval = '';
                } else {
                    $mpnval = $_Product->getData($pmpn);
                }
				if ($gpc == 'none' || $gpc == '') {
                    $gpcval = implode(" > ", $holder);
                } else {
                    // $gpcval = $_Product->getData($gpc);
                    $gpcval = implode(" > ", $holder); 
                }			
				
                if ($_Product->getTypeId() == 'bundle') {
                    $isbundle = 'yes';
                } else {
                    $isbundle = 'no';
                }
				$genderval=array();
                if ($pgender == 'none' || $pgender == '') {
                    $genderval = '';
                } 
				else {
                    $genderval = $_Product->getAttributeText($pgender);	
					if(empty($genderval))
					{						
						$genderval= '';
					}
					else
					{
						if(is_array($genderval))
						{
							if (in_array("Unisex", $genderval, TRUE)) 
							{ 							
								$genderval= 'Unisex';							
							} 
							else
							{ 						 
							  $genderval= $genderval[0];
							} 	
						}
						else{$genderval= $genderval;}
					}					
                }
                if ($gtinval != '' || $attriupc != '' || $mpnval != '') {
                    $idexists = 'TRUE';
                } else {
                    $idexists = 'FALSE';
                }
				$prodid = $_Product->getId();
				
				$StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
				$quantity = $StockState->getStockQty($_Product->getId(), $_Product->getStore()->getWebsiteId());
				
				/* $stockItem = $objectManager->get('\Magento\CatalogInventory\Model\Stock\StockItemRepository');
				$productId = 1; // YOUR PRODUCT ID
				$productStock = $stockItem->get($prodid);
				$instock  = $productStock->getIsInStock();
				if ($instock == 1) {
                    $instock = 'in stock';
                } else {
                    $instock = 'out of stock';
                } */
				//$instock  = '';
				 if ($quantity > 0) {
                    $instock = 'in stock';
                } else {
                    $quantity = 'out of stock';
                }
				$backendModel = $collection->getResource()->getAttribute('media_gallery')->getBackend();
                $backendModel->afterLoad($_Product);                
                $img    = $_Product->getMediaGalleryImages()->getFirstItem()->getUrl();				
				$prodimages=$_Product->getImageUrl();
				if($prodimages==''){
					$prodimages='';
				} 
				$store  = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
				$taxCalculation = $objectManager->get( 'Magento\Tax\Model\TaxCalculation' );				
				$tax_class_id = $_Product->getTaxClassId(); 
				$taxCalculation = $objectManager->create( 'Magento\Tax\Model\Calculation\Rate' )->load( $tax_class_id , 'tax_calculation_rate_id' );
				//echo "<br/>";
				$tax = round($taxCalculation->getRate());
				if($tax==''){$tax='0';}
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
				$baseurl=$storeManager->getStore()->getBaseUrl();
				if ($saleprice == 'Special Price'){
					if ($_Product['special_price'] !='')
					{
						//$price=number_format($_Product['special_price'], 2, '.', '').' '.$currency_code;
						$price=number_format($_Product['special_price'], 2, '.', '');
					}
					else{$price = 0;}
				}
				else{$price = number_format($_Product['price'], 2, '.', '');}
				
				$data['g:id'] = $_Product->getId();
                $data['title'] = $_Product['name'];
				$prod_desc=preg_replace("/\r|\n/", "", $_Product['description']);
                $prod_desc = str_replace(","," ",$prod_desc);
				$search = array(',','&', '<', '>', '€', '‘', '’', '“', '”', '–', '—', '¡', '¢','£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã','ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ','Œ', 'œ', '‚', '„', '…', '™', '•', '˜');
				$replace  = array('&#44;','&amp;', '&lt;', '&gt;', '&euro;', '&lsquo;', '&rsquo;', '&ldquo;','&rdquo;', '&ndash;', '&mdash;', '&iexcl;','&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;','&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;','&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;', '&OElig;', '&oelig;', '&sbquo;', '&bdquo;', '&hellip;', '&trade;', '&bull;', '&asymp;');
				
				$data['description']=str_replace($search, $replace,$prod_desc);
				$data['link'] = $baseurl.$_Product->getUrlKey();
				$data['g:price'] = $price.' '.$currency_code;
				$data['g:condition'] = $attrcond;
				$data['g:availability'] = $instock;
				$data['g:image_link'] = $img;
				$data['g:tax'] = $tax.' '.$currency_code;
				$data['g:shipping_weight'] = $_Product->getWeight();
				$data['g:google_product_category'] = $gpcval;
				$pcval = implode(" > ", $holder);
				$data['g:product_type'] = $pcval;
				$data['g:item_group_id'] = $_Product->getId();
				$data['g:color'] = $color;
                $data['g:size'] = $_Product->getSize();
				$data['g:gender'] = $genderval;
				$data['g:age_group'] = $age;
				$data['g:pattern'] = $pattern;
				$data['g:brand'] = $brand;
				$data['g:gtin'] = $gtinval;
                $data['g:mpn'] = $mpnval;
				$data['g:upc'] = $attriupc;
				$data['g:identifier_exists'] = $idexists;
                $data['g:adult'] = $padult;       
                $data['g:custom_label_0'] = $custval;
                $data['g:isbundle'] = $isbundle;				
				/*$prod_sdesc=preg_replace("/\r|\n/", "", $_Product['short_description']);
                $data['g:short_description'] = str_replace(","," ",$prod_sdesc);
                $data['g:quantity'] = $quantity;*/
				$feed_products[] = $data;				
			}
			foreach ($feed_products as $_product) {
				$itemNode = $channelNode->appendChild($doc->createElement('item'));
				foreach($_product as $key=>$value) {
					 if ($value != "") {
						  if (is_array($_product[$key])) {
							$subItemNode = $itemNode->appendChild($doc->createElement($key));
							foreach($_product[$key] as $key2=>$value2){
							  $subItemNode->appendChild($doc->createElement($key2))->appendChild($doc->createTextNode($value2));
							}
						  } else {
							$itemNode->appendChild($doc->createElement($key))->appendChild($doc->createTextNode($value));
						  }
					 
						} else {
					 
						  $itemNode->appendChild($doc->createElement($key));
						}
				}
            }	
				echo"HI";
				//Save XML as a file
				//$dom->save('sitemap.xml');
				$filename=$x;
				//$file_name='test.xml';
				if (!is_dir($rootPath)) {
					mkdir($rootPath, 0777, true);
				}
				$file_name=$rootPath.$filename.'.xml';
				file_put_contents($file_name, $doc->saveXML());			
				$timezone = date('Y-m-d h:i:s');
				$feedfile=$baseurl.$file_name;
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
				$connection = $resource->getConnection();
				$tableName = $resource->getTableName('tutorial_simplenews');
				$id = $newsId;  // table row id to update
				$sql = "UPDATE " . $tableName . " SET `feed_xml`  = '".$feedfile."',`created_time` =  '".$timezone."' WHERE `id` = " . $id;
				$connection->query($sql);
				
				
				
				 
				/*Create XML File*/

			//Check if this news exists
            if(!$newsModel->getId()) {
                $this->messageManager->addError(__('This Feed is no longer exists.'));
            }
            else {
                try {
                    $this->messageManager->addSuccess(__('The Feed has been Created.'));

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
