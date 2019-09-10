<?php 
namespace Redbox\Linkedin\Controller\Customer;  
use Magento\Framework\Message\ManagerInterface;
class Index extends \Magento\Framework\App\Action\Action {
	public function __construct(
	\Magento\Framework\App\Action\Context $context,
	\Magento\Customer\Model\Customer $customer,
    \Magento\Customer\Model\CustomerFactory $customerFactory,
	\Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
	\Magento\Store\Model\StoreManagerInterface $storeManager,
	ManagerInterface $messageManager
	) {     
		parent::__construct($context);
		$this->customer = $customer;
		$this->customerFactory = $customerFactory;
		$this->customerRepositoryInterface = $customerRepositoryInterface;
		$this->_storeManager = $storeManager;
		$this->_messageManager = $messageManager;
		$this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	} 
	
	
	public function execute() {
		$post = $this->getRequest()->getPostValue();
		if(isset($post['linkedin_profile']) && $post['linkedin_profile']!='') {
			if(!filter_var($post['linkedin_profile'], FILTER_VALIDATE_URL)) {
				$this->_messageManager->addError('Please ener valid linkedin profile URL.');
				$this->_redirect('redbox/customer/index');
				return;
			}
			$this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$session = $this->objectManager->create('Magento\Customer\Model\Session');    
			
			$customer = $this->customerRepositoryInterface->getById($session->getCustomer()->getId());
			$custom = $this->customerFactory ->create();
			$custom = $custom->setWebsiteId($this->_storeManager->getStore()->getWebsiteId());
			$custom = $custom->loadByEmail($session->getCustomer()->getEmail());
			$custom->setCustomAttributeCode('linkedin_profile');  
			
			$customerData = $custom->getDataModel();
			$customerData->setCustomAttribute('linkedin_profile', $post['linkedin_profile']);
			$custom->updateData($customerData);
			$custom->save();
			$this->_messageManager->addSuccess('Linkedin Profile URL successfully updated.');
			$this->_redirect('redbox/customer/index');
		}
		else {
			$this->_view->loadLayout(); 
			$this->_view->renderLayout(); 
		}
	} 
} 
?>