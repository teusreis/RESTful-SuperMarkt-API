<?php

namespace App\Model;

use App\Trait\UserTrait;
use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer
{
    use UserTrait;
    
    private bool $hasError = false;
    public array $error = [];

    public function __construct()
    {
        parent::__construct("users", ["name", "lastName", "email", "password"]);
    }

    public function save(): bool
    {
        if ($this->error) {
            return false;
        }

        return parent::save();
    }
}
