<?php

namespace MageTest\DataCustomer\Model;
use MageTest\DataCustomer\Helper\Data;

class CustomerciManagement implements \MageTest\DataCustomer\Api\CustomerciManagementInterface
{
    private $helper;

    public function __construct(
        Data $helper
    ){
        $this->helper=$helper;
    }

    public function getCiCustomer($email)
    {
        $dataCIUser=$this->helper->getCiCustomer($this->helper->getCustomerIdByEmail($email));
        return json_encode($dataCIUser,JSON_UNESCAPED_SLASHES);
    }
}
