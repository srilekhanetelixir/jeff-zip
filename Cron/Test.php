<?php
namespace Jeff\SimpleNews\Cron;
 
class Test {
 
    protected $_logger;
 
    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }
    
    /**
     * Method executed when cron runs in server
     */
    public function execute() {
		$this->_logger->info('Bs_Cron has been run successfully');
		$timezone1 = date('Y-m-d h:i:s');
		$timecreated   = strftime("%Y-%m-%d %H:%M:%S",  mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
		
        
        $this->_logger->debug('Running Cron from Test class');
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
		$rootPath  =  $directory->getPath('media').'/lxrcron/';				
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('tutorial_simplenews');
		$sqlfecth = "SELECT * FROM " . $tableName . " WHERE `status` = 1";
		$id = $connection->query($sqlfecth);
        while ($row = $id->fetch() ) {
		$Ids = $row['id'];
		$sqlfecth1 = "SELECT `cron_interval`,`update_time` FROM " . $tableName . " WHERE `status` = 1 AND `id`=".$Ids;
		$cronin = $connection->fetchAll($sqlfecth1);
		$cr=$cronin[0]['cron_interval'];
		$scheduled=$cronin[0]['update_time'];
		$minutes=(int)$cr;
		$this->_logger->info($scheduled);
		//$timescheduled = strftime("%Y-%m-%d %H:%M:%S", mktime(date("H"), date("i")+ 10, date("s"), date("m"), date("d"), date("Y")));
		$difference= round(abs(strtotime($timecreated) - strtotime($scheduled)) %60);
		$this->_logger->info($difference);
		if($difference=='10'){
			
			$this->_logger->info($timecreated);
			$this->_logger->info("cron successss");
			$x = $row['file_name'];
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$currencysymbol = $objectManager->get('Magento\Directory\Model\Currency');
			$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
			$store = $storeManager->getStore();			
			$currency_code= $store->getCurrentCurrencyCode();
			$stockavail  = $row['stock_availability'];
			$pc          = $row['product_categories'];
			$catinput    = '01';
			$catarray1   = Array($catinput);
			$catarray2   = explode(',', $pc);
			$catarray3   = array_diff($catarray2, $catarray1);
			$pc          = implode(',', $catarray3);
			$saleprice   = $row['feedprice'];
			$pricerange  = $row['pricerange'];
			$stockavail  = $row['stock_availability'];
			$stockrange  = $row['stock_range'];
			$stockvalue  = $row['stock_value'];
			$attrpattern = $row['pattern'];
			$attrbrand   = $row['brand'];
			$attrcond    = $row['condition'];
			$attrupc     = $row['upc'];
			$pgtin       = $row['gtin'];
			$customlabel = $row['customlabelzero'];
			$pgender     = $row['gender'];
			$padult      = $row['adult'];
			$pmpn        = $row['mpn'];
			$pricevalue  = $row['pricevalue'];
			$gpc 		 = $row['content'];
			$age 		 = $row['product'];
			$substring   = substr_count($pricevalue, '-');
			if ($substring != 0) {
				$input = $pricevalue;
				list($a, $b) = explode('-', $input);
			}
			substr($pricerange . $pricevalue, 0, 2);
			$bwith           = $row['begins_with'];
			$cwith           = $row['contains_with'];
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
			$stockId 		 = 'stock_id';
			$todayDate    = date('m/d/y');
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			 
			$productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
			
			$categoryCollectionFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');
			$categorycollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\Collection');
			$categoryCollection = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
			/* $categoryId = '12';
			$category = $categoryCollectionFactory->create()->load($categoryId); */
			$collection = $productCollectionFactory->create();
			echo $stockavail."==".$saleprice;
			if($bwith != '' && $cwith != '') 
			{
				echo "Begins & Contains are not empty";
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
				echo "Begins not empty & Contains empty";
				$collectionbw = $productCollectionFactory->create();				
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
				echo "Begins empty & Contains not empty";
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
					/*$collection->joinField('qty', 'cataloginventory/stock_item','qty','product_id=entity_id','{{table}}.is_in_stock=1','left');
					*/
					$collection->addAttributeToFilter('qty', array("lt" => $stockvalue));
					//$collection->addAttributeToFilter('qty',['lt '=> $stockvalue ]) ->load();
					$collection->addAttributeToSort('created_at', 'asc');					
				} 
				else if ($stockrange == 'gt') 
				{
				   /*$collection->joinField('qty', 'cataloginventory/stock_item','qty','product_id=entity_id','{{table}}.is_in_stock=1','left');
					*/
					$collection->addAttributeToFilter('qty', array("gt" => $stockvalue));
					//$collection->addAttributeToFilter('qty',['gt '=> $stockvalue ]) ->load();
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
			echo count($beginsid);
			
			
			
			$csv     = '';
			$content = array(
				"id",
				"title",                
				"description",
				"link",
				"price",
				"condition",
				"availability",
				"image_link",
				"tax(rate)",
				"shipping_weight",
				"google_product_category",
				"product_type",
				"item_group_id",
				"color",
				"size",
				"gender",
				"age_group",
				"pattern",
				"brand",
				"gtin",
				"mpn",
				"upc", 
				"identifier_exists",
				"adult",
				"custom_label_0",                            
				"is_bundle"       
			);
			$data    = array();
			$data1    = array();
			
			$doc = new \DOMDocument('1.0', 'UTF-8');
			//$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
			//$domain=$_SERVER['SERVER_NAME'];
			//$url = "http://localhost/magento3/";
			$xmlRoot = $doc->createElement("rss");
			$xmlRoot = $doc->appendChild($xmlRoot);
			$xmlRoot->setAttribute('version', '2.0');
			$xmlRoot->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', "http://base.google.com/ns/1.0");
			$channelNode = $xmlRoot->appendChild($doc->createElement('channel'));
			$channelNode->appendChild($doc->createElement('title', 'Product Feed'));
			//$channelNode->appendChild($doc->createElement('link', $url));
			$feed_products = array();
			
			foreach ($content as $column) {
				$data[] = '"' . $column . '"';
			}
			$csv .= implode(',', $data) . "\n";
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
					/* $gpcval = $_Product->getData($gpc); */
					if ($gpc == 'category_ids')
					{
						$gpcval = implode(" > ", $holder); 
					}
					else{$gpcval = $_Product->getData($gpc);}
					//$gpcval = implode(" > ", $holder); 
				}			
				//echo "gpcval=".$gpcval;
				$pcval = implode(" > ", $holder);
				//echo "pcval=".$pcval;
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
				}*/
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
				
				//$storeID  = $storeManager->getStore()->getStoreId(); 
				$taxCalculation = $objectManager->get( 'Magento\Tax\Model\TaxCalculation' );
				
				$tax_class_id = $_Product->getTaxClassId(); 
				$taxCalculation = $objectManager->create( 'Magento\Tax\Model\Calculation\Rate' )->load( $tax_class_id , 'tax_calculation_rate_id' );
				echo "<br/>";
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
				//else{$price = number_format($_Product['price'], 2, '.', '').' '.$currency_code;}
				else{$price = number_format($_Product['price'], 2, '.', '');} 
				
				 $data = array();
				$data[] = $_Product->getId();
				$data[] = $_Product['name'];                
				$prod_desc=preg_replace("/\r|\n/", "", $_Product['description']);
				$prod_desc = str_replace(","," ",$prod_desc);
				$search = array(',','&', '<', '>', '€', '‘', '’', '“', '”', '–', '—', '¡', '¢','£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã','ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ','Œ', 'œ', '‚', '„', '…', '™', '•', '˜');
				$replace  = array('&#44;','&amp;', '&lt;', '&gt;', '&euro;', '&lsquo;', '&rsquo;', '&ldquo;','&rdquo;', '&ndash;', '&mdash;', '&iexcl;','&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;','&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;','&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;', '&OElig;', '&oelig;', '&sbquo;', '&bdquo;', '&hellip;', '&trade;', '&bull;', '&asymp;'); 
				
				 $data[]=str_replace($search, $replace,$prod_desc);
				 $data[] = $baseurl.$_Product->getUrlKey();
				$data[] = $price.' '.$currency_code;
				$data[] = $attrcond;
				$data[] = $instock;				
				$data[] = $img;
				$data[] = $tax.' '.$currency_code;
				$data[] = $_Product->getWeight();
				$data[] = $pcval; //google_product_category
				$data[] = $pcval;				//product_type
				$data[] = $_Product->getId(); // item_group_id 
				$data[] = $color; 
				$data[] = $_Product->getSize();
				$data[] = $genderval;   
				$data[] = $age;
				$data[] = $pattern;
				$data[] = $brand;
				$data[] = $gtinval;
				$data[] = $mpnval;			
				$data[] = $attriupc; 
				$data[] = $idexists;
				$data[] = $padult;                
				$data[] = $custval;                
				$data[] = $isbundle; 	 
				$csv .= implode(',', $data) . "\n";		
				
				$data1['g:id'] = $_Product->getId();
				$data1['title'] = $_Product['name'];
				$data1['description']=str_replace($search, $replace,$prod_desc);
				$data1['link'] = $baseurl.$_Product->getUrlKey();
				$data1['g:price'] = $price.' '.$currency_code;
				$data1['g:condition'] = $attrcond;
				$data1['g:availability'] = $instock;
				$data1['g:image_link'] = $img;
				$data1['g:tax'] = $tax.' '.$currency_code;
				$data1['g:shipping_weight'] = $_Product->getWeight();
				$data1['g:google_product_category'] = $gpcval;
				$pcval = implode(" > ", $holder);
				$data1['g:product_type'] = $pcval;
				$data1['g:item_group_id'] = $_Product->getId();
				$data1['g:color'] = $color;
				$data1['g:size'] = $_Product->getSize();
				$data1['g:gender'] = $genderval;
				$data1['g:age_group'] = $age;
				$data1['g:pattern'] = $pattern;
				$data1['g:brand'] = $brand;
				$data1['g:gtin'] = $gtinval;
				$data1['g:mpn'] = $mpnval;
				$data1['g:upc'] = $attriupc;
				$data1['g:identifier_exists'] = $idexists;
				$data1['g:adult'] = $padult;       
				$data1['g:custom_label_0'] = $custval;
				$data1['g:isbundle'] = $isbundle;		
				$feed_products[] = $data1;
			}
			
			 $filename=$x;
			if (!is_dir($rootPath)) {
				mkdir($rootPath, 0777, true);
			}
			$csv_filename = $rootPath.$filename.".csv";
			$csv_handler = fopen ($csv_filename,'w');
			fwrite ($csv_handler,$csv);
			fclose ($csv_handler);
			//$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			//$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			//$connection = $resource->getConnection();
			//$sql = "UPDATE " . $tableName . " SET `summary` =  '".$filename."' WHERE `id` = ".$Ids;
			
		
			//$connection->query($sql); 
			
			
			
			
	/////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			
			
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
			$file_name=$rootPath.$filename.'.xml';
			file_put_contents($file_name, $doc->saveXML());			
			$timezone = date('Y-m-d h:i:s');
			$feedfile=$baseurl.$csv_filename; 
			$feedfilexml=$baseurl.$file_name; 
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tableName = $resource->getTableName('tutorial_simplenews');
			//$sql = "UPDATE " . $tableName . " SET `summary` =  '".$filename."' WHERE `id` = ".$Ids;
			//$sql = "UPDATE " . $tableName . " SET `feed_csv`  = '".$feedfile."',`created_time` =  '".$timezone."' WHERE `id` = " . $Ids;
			$sql = "UPDATE " . $tableName . " SET `feed_csv`  = '".$feedfile."', `feed_xml`  = '".$feedfile."',`update_time` =  '".$timecreated."' WHERE `id` = " . $Ids;
			$connection->query($sql);
			
		}
		
	}
    }
}