<?php

namespace MageTest\DataCustomer\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\CustomerFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;



class Data extends AbstractHelper
{
    protected $modelExtCi;
    protected $customer;
    protected $storemanager;
    protected $customerInterface;

    protected $moduleManager;
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \MageTest\DataCustomer\Model\Source\Customdropdown $modelExtCi,
        CustomerFactory $customer,
        StoreManagerInterface $storemanager,
        CustomerRepositoryInterface $customerInterface,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->modelExtCi=$modelExtCi;
        $this->customer = $customer;
        $this->storemanager = $storemanager;
        $this->customerInterface=$customerInterface;
        $this->moduleManager=$moduleManager;
        $this->scopeConfig=$scopeConfig;
        parent::__construct($context);
    }
    public function getAllOptions(){
        return $this->modelExtCi->getAllOptions();
    }
    public function  getOptionText($value){
        return $this->modelExtCi->getOptionText($value);
    }

    public function getCustomerIdByEmail($email)
    {
        $websiteID = $this->storemanager->getStore()->getWebsiteId();
        $customer = $this->customer->create()->setWebsiteId($websiteID)->loadByEmail($email);
        if($customer->getId()){
            return $customer->getId();
        }else{
            return null;
        }
    }
    public function getCiCustomer($id)
    {
        $response=[];
        try {
            $customer = $this->customerInterface->getById($id);
            $data["ci"] = "";
            $data["ext"] = "";
            if ($customer->getCustomAttribute('customer_ci')) {
                if(strcmp("0", "".$customer->getCustomAttribute('customer_ci')->getValue())!=0){
                    $data["ci"] = $customer->getCustomAttribute('customer_ci')->getValue();
                }
            }
            if ($customer->getCustomAttribute('customer_ci_ext')) {
                if($this->getOptionText($customer->getCustomAttribute('customer_ci_ext')->getValue())) {
                    $data["ext"] = $this->getOptionText($customer->getCustomAttribute('customer_ci_ext')->getValue());
                }
            }
            $response['message']=$data;
        } catch (NoSuchEntityException $e) {
            $response['message']="Not Exist User";
        }
        return $response;
    }

    public function isEnabled(){
        if ($this->moduleManager->isEnabled('MageTest_DataCustomer')) {
            //the module is enabled
            return true;
        } else {
            //the module is disabled
            return false;
        }
    }

    public function getStatusMod(){
        return $this->scopeConfig->getValue('DataCustomer/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function showAtAccount(){
        return $this->scopeConfig->getValue('DataCustomer/general/ataccount', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function showAtForm(){
        return $this->scopeConfig->getValue('DataCustomer/general/atformreg', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function showAtShipping(){
        return $this->scopeConfig->getValue('DataCustomer/general/atshipping', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function showAtGridCustomer(){
        return $this->scopeConfig->getValue('DataCustomer/general/atgridcustomer', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function showAtMail(){
        return $this->scopeConfig->getValue('DataCustomer/general/atmailtemplate', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
