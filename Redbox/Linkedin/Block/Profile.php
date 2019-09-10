<?php
namespace Redbox\Linkedin\Block;
class Profile extends \Magento\Framework\View\Element\Template
{
	protected $_session;
	protected $_context;

	public function __construct(
	 \Magento\Framework\View\Element\Template\Context $context,
	 \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
	) {     
		parent::__construct($context);
		$this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$this->customerRepositoryInterface = $customerRepositoryInterface;

	} 
	public function isCustomerLoggedIn()
	{
		$session = $this->objectManager->create('Magento\Customer\Model\Session');    
		return $session->isLoggedIn();
	}

	public function getCustomerId(){
		$session = $this->objectManager->create('Magento\Customer\Model\Session');    
		return $session->getCustomer()->getId();
	}
	
	public function getMyLinkedinProfile($customerId) {
		$customer = $this->customerRepositoryInterface->getById($customerId);
		return $customer->getCustomAttribute('linkedin_profile')->getValue();
	}
}