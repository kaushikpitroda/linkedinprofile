<?php

namespace Redbox\Linkedin\Observer\Api\Customer;

use Magento\Framework\Event\ObserverInterface;

class Attribute implements ObserverInterface
{
    protected $_customerRepositoryInterface;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		
        $customer = $observer->getEvent()->getCustomer();
		$extensionAttributes = $customer->getExtensionAttributes();
		$attr = $customer->getCustomAttribute('linkedin_profile')->getValue();
		$extensionAttributes->setLinkedinProfile($attr);
        if ($customer->getGroupId() == 1) {
            $this->_customerRepositoryInterface->save($customer);;
        }
    }
}