<?php

namespace MageTest\DataCustomer\Api;

interface CustomerciManagementInterface
{
    /**
     * GET for ci api
     * @param string $email
     * @return mixed
     */
    public function getCiCustomer($email);
}
