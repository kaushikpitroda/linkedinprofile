<?php
namespace Redbox\Linkedin\Model\Plugin\Checkout;
class LayoutProcessor
{
	protected $_helper;
	public function __construct(\Redbox\Linkedin\Helper\Data $moduleHelper) {
		$this->_helper = $moduleHelper;
	}
		
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
		$fieldStatus = $this->_helper->getLinkedinStatus();
		if ($fieldStatus == 1) {
			$required = true;
		}
		else {
			$required = false;
		}
		if ($fieldStatus == 2) {
			$visible = false;
		}
		else {
			$visible = true;
		}
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['linkedin_profile'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'id' => 'linkedin-profile'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.linkedin_profile',
            'label' => 'Linkedin Profile',
            'provider' => 'checkoutProvider',
            'visible' => $visible,
            'validation' => [
				'required-entry' => $required, 'validate-url' => true
			],
            'sortOrder' => 299,
            'id' => 'linkedin-profile',
			
        ];
 
 
        return $jsLayout;
    }
}