<?php
 
namespace Redbox\Linkedin\Helper;
 
use Magento\Framework\App\Helper\AbstractHelper;
 
class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $scopeConfig;
	const XML_PATH_DISPLAY_OPTION = 'linkedin/general/display_option';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) 
    {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }
 
    public function getLinkedinStatus() {
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_DISPLAY_OPTION, $storeScope);
    }
}