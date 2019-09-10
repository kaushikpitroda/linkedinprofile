<?php


namespace Redbox\Linkedin\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

class InstallData implements InstallDataInterface
{

    private $customerSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'linkedin_profile', [
            'type' => 'varchar',
            'label' => 'Linked In Profile',
            'input' => 'text',
            'source' => '',
            'required' => true,
            'visible' => true,
            'position' => 333,
            'system' => false,
            'backend' => '',
			'filterable' => true,
			'comparable' => true,
			'is_used_in_grid' => true,
			'is_visible_in_grid' => true,
			'is_filterable_in_grid' => true,
			'is_searchable_in_grid' => true,
        ]);
        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'linkedin_profile')
        ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]
        ]);
        $attribute->save();
    }
}
