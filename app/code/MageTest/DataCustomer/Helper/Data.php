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
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \MageTest\DataCustomer\Model\Source\Customdropdown $modelExtCi,
        CustomerFactory $customer,
        StoreManagerInterface $storemanager,
        CustomerRepositoryInterface $customerInterface

    ) {
        $this->modelExtCi=$modelExtCi;
        $this->customer = $customer;
        $this->storemanager = $storemanager;
        $this->customerInterface=$customerInterface;
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
                $data["ci"] = $customer->getCustomAttribute('customer_ci')->getValue();
            }
            if ($customer->getCustomAttribute('customer_ci_ext')) {
                $data["ext"] = $this->getOptionText($customer->getCustomAttribute('customer_ci_ext')->getValue());
            }
            $response['message']=$data;
        } catch (NoSuchEntityException $e) {
            $response['message']="Not Exist User";
        }
        return $response;
    }
}
