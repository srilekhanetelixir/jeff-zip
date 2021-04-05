<?php 
namespace Jeff\SimpleNews\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper {
    const XML_PATH_ENABLED = 'simplenews/general/enable_in_frontend';
    const XML_PATH_HEAD_TITLE = 'simplenews/general/head_title';
    const XML_PATH_LATEST_NEWS = 'simplenews/general/latest_news_block_position';

    protected $_scopeConfig;

    /**
     * @param Context $contex
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(Context $context, ScopeConfigInterface $scopeConfig) {
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function isEnabledInFrontend($store = null) {
        return $this->_scopeConfig->getValue(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    public function getHeadTitle() {
        return $this->_scopeConfig->getValue(self::XML_PATH_HEAD_TITLE, ScopeInterface::SCOPE_STORE);
    }

    public function getLatestNewsBlockPosition() {
        return $this->_scopeConfig->getValue(self::XML_PATH_LATEST_NEWS, ScopeInterface::SCOPE_STORE);
    }
}
