<?php
namespace Redbox\Linkedin\Model\Config;
 
class Options implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Optional')],
            ['value' => 1, 'label' => __('Required')],
            ['value' => 2, 'label' => __('Invisible')]
        ];
    }
}