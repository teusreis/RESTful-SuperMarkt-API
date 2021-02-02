<?php

namespace App\Model;

use App\Model\Product;
use CoffeeCode\DataLayer\DataLayer;

class Category extends DataLayer
{
    private Product $product;
    private bool $hasError = false;
    public array $error;
    
    public function __construct()
    {
        $required = ["name"];
        parent::__construct("category", $required, timestamps: false);
    }

    public function products(): array|null
    {
        $this->product = new Product();
        $product = $this->product->find("category_id = :category_id", "category_id={$this->id}")->fetch(true);

        if (is_null($product)) return null;

        $data = [];

        foreach ($product as $p) {
            $data[] = $p->data;
        }

        return $data;
    }

    public function setName(string $name)
    {
        if (empty($name)) {
            $this->hasError = true;
            $this->error["name"] = "Name is required";
        } else if (strlen($name) > 50) {
            $this->hasError = true;
            $this->error["name"] = "Name must not be graiter than 50 characters!";
        }

        $this->name = $name;

        return $this;
    }

    public function save(): bool
    {
        if ($this->hasError) {
            return false;
        }

        return parent::save();
    }
}
