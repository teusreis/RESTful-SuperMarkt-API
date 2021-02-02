<?php

namespace App\Model;

use App\Trait\UserTrait;
use CoffeeCode\DataLayer\DataLayer;

class Employee extends DataLayer
{
    use UserTrait;

    private bool $hasError = false;
    public array $error = [];

    private EmployeeInfo $employeeInfo;

    public function __construct()
    {
        $this->employeeInfo = new EmployeeInfo();
        parent::__construct("users", ["name", "lastName", "email", "password"]);
    }

    public function setIsEmployee($isEmployee)
    {
        $this->isEmployee = $isEmployee;
        return $this;
    }

    public function setUserType($userType)
    {
        $validTypies = ["basic", "employee", "admin"];

        if (!in_array($userType, $validTypies)) {
            $this->hasError = true;
            $this->error["userType"] = "Invalid user type!";
        }

        $this->userType = $userType;
        return $this;
    }

    public function save(): bool
    {
        if ($this->error) {
            return false;
        }

        return parent::save();
    }

    public function getInfo()
    {
        if (isset($this->info)) {
            return $this->employeeInfo->find("id = :info", "info={$this->info}")->fetch();
        } else {
            return null;
        }
    }
}
