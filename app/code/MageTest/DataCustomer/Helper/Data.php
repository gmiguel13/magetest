<?php

namespace MageTest\DataCustomer\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $modelExtCi;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \MageTest\DataCustomer\Model\Source\Customdropdown $modelExtCi
    ) {
        $this->modelExtCi=$modelExtCi;
        parent::__construct($context);
    }
    public function getAllOptions(){
        return $this->modelExtCi->getAllOptions();
    }

}
