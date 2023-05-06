<?php

namespace MageTest\DataCustomer\Model\Source;

class Customdropdown extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        if ($this->_options === null) {

            $this->_options = [

                ['value' => '', 'label' => __('Select CI Ext')],

                ['value' => '1', 'label' => __('CB')],
                ['value' => '2', 'label' => __('LP')],
                ['value' => '3', 'label' => __('SC')],
                ['value' => '4', 'label' => __('CH')],
                ['value' => '5', 'label' => __('BN')],
                ['value' => '6', 'label' => __('TJ')],
                ['value' => '7', 'label' => __('OR')],
                ['value' => '8', 'label' => __('PT')],
                ['value' => '9', 'label' => __('PA')]
            ];
        }
        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option)
        {
            if ($option['value'] == $value)
            {
                return $option['label'];
            }
        }
        return false;
    }
}
