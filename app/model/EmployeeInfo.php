<?php

namespace App\Model;

use CoffeeCode\DataLayer\DataLayer;

class EmployeeInfo extends DataLayer
{
    private bool $hasError = false;
    public array $error;

    public function __construct()
    {
        parent::__construct("employees_info", [], "id", false);
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setAddressNumber($addressNumber)
    {
        $this->addressNumber = $addressNumber;
        return $this;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
        return $this;
    }
}
