<?php namespace Redbox\Linkedin\Plugin;

use Magento\Framework\Controller\ResultFactory;

use Magento\Framework\Message\ManagerInterface;

use Magento\Framework\App\RequestInterface;


class Checklinkedin 
{

    public function __construct(
        ResultFactory $Redirect, 
        ManagerInterface $messageManager,   
        RequestInterface $request,
		\Redbox\Linkedin\Helper\Data $moduleHelper
    )
    {
        $this->resultFactory = $Redirect;
        $this->_messageManager = $messageManager;
        $this->getRequest = $request;
		$this->_helper = $moduleHelper;
    }

    public function beforeExecute(\Magento\Customer\Controller\Account\CreatePost $subject)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$fieldStatus = $this->_helper->getLinkedinStatus();
		if($fieldStatus == 1) {
			$linkedin_profile = $this->getRequest->getParam('linkedin_profile');
			$customerObj = $objectManager->create('Magento\Customer\Model\ResourceModel\Customer\Collection');
			$collection = $customerObj->addAttributeToSelect('*')
					  ->addAttributeToFilter('linkedin_profile',$linkedin_profile)
					  ->load();
			$customerdata=$collection->getData();
			$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
			if($linkedin_profile!='') {
				if(!filter_var($linkedin_profile, FILTER_VALIDATE_URL)) {
					$this->_messageManager->addError('Please ener valid linkedin profile URL.');
					$resultRedirect->setPath('customer/account/');
					$this->getRequest->setParam('form_key','');
					return $resultRedirect;
				}
				if(count($customerdata)>0) {
					$this->_messageManager->addError('The value of "Linkedin Profile" already exist.');
					$resultRedirect->setPath('customer/account/');
					$this->getRequest->setParam('form_key','');
					return $resultRedirect;
				}
				else
				{
					return true;
				}
			}
			else {
					$this->_messageManager->addError('The value of "Linkedin Profile" is empty.');
					$resultRedirect->setPath('customer/account/');
					$this->getRequest->setParam('form_key','');
					return $resultRedirect;
			}
		}

    }

}