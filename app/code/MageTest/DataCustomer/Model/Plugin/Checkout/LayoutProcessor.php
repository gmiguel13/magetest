<?php
namespace MageTest\DataCustomer\Model\Plugin\Checkout;
use MageTest\DataCustomer\Helper\Data;
use Magento\Store\Model\StoreManagerInterface as smi;
use Magento\Customer\Model\CustomerFactory as cuf;
use Magento\Customer\Model\Session as cus;
use Magento\Customer\Api\CustomerRepositoryInterface as cui;

class LayoutProcessor
{

    protected $helper;
    protected $smi;
    protected $cuf;
    protected $cus;
    protected $cui;
    public function __construct(
        Data $myhelper,
        smi $smi,
        cuf $cuf,
        cus $cus,
        cui $cui
    ){
        $this->helper=$myhelper;
        $this->smi=$smi;
        $this->cus=$cus;
        $this->cuf=$cuf;
        $this->cui=$cui;
    }
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        if($this->helper->getStatusMod()) {
            if($this->helper->showAtShipping()) {
                $customer = $this->cui->getById($this->cus->getId());
                $value_ci = "";
                $value_ci_ext = "";
                $options = array($this->helper->getAllOptions());

                if ($customer->getCustomAttribute('customer_ci')) {
                    $value_ci = $customer->getCustomAttribute('customer_ci')->getValue();
                    if(strcmp("0", $value_ci)==0){
                        $value_ci="";
                    }
                }
                if ($customer->getCustomAttribute('customer_ci_ext')) {
                    $value_ci_ext = $customer->getCustomAttribute('customer_ci_ext')->getValue();
                }
                $value_ci_ext = $this->helper->getOptionText($value_ci_ext);
                if(!$value_ci_ext){
                    $value_ci_ext="";
                }

                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                ['shippingAddress']['children']['shipping-address-fieldset']['children']['customer_ci'] = [
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'customScope' => 'shippingAddress.custom_attributes',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input',
                        'options' => [],
                        'id' => 'customer_ci'
                    ],
                    'dataScope' => 'shippingAddress.custom_attributes.customer_ci',
                    'label' => 'Ci',
                    'provider' => 'checkoutProvider',
                    'visible' => true,
                    'validation' => [],
                    'sortOrder' => 250,
                    'id' => 'customer_ci',
                    'value' => $value_ci
                ];

                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
                ['shippingAddress']['children']['shipping-address-fieldset']['children']['customer_ci_ext'] = [
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'customScope' => 'shippingAddress.custom_attributes',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input',
                        'options' => [],
                        'id' => 'customer_ci_ext'
                    ],
                    'dataScope' => 'shippingAddress.custom_attributes.customer_ci_ext',
                    'label' => 'Ext',
                    'provider' => 'checkoutProvider',
                    'visible' => true,
                    'validation' => [],
                    'sortOrder' => 251,
                    'id' => 'customer_ci_ext',
                    'value' => $value_ci_ext
                ];
            }
        }

        return $jsLayout;
    }
}
