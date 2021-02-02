<?php

namespace App\Model;

use App\Auth\AuthController;
use CoffeeCode\DataLayer\DataLayer;

class Product extends DataLayer
{
    private bool $hasError = false;
    public array $error;
    private Category $category;

    public function __construct()
    {   
        $this->category = new Category();
        parent::__construct("products", ["name", "price", "qtd"]);
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(string $name): self
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

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice(float $price): self
    {
        if (empty($price)) {
            $this->hasError = true;
            $this->error["price"] = "Price is required";
        }

        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of qtd
     */
    public function getQtd()
    {
        return $this->qtd;
    }

    /**
     * Set the value of qtd
     *
     * @return  self
     */
    public function setQtd(int $qtd): self
    {
        if (empty($qtd)) {
            $this->hasError = true;
            $this->error["qtd"] = "Quantity is required";
        }

        $this->qtd = $qtd;

        return $this;
    }

    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id(int $category_id = null)
    {
        if (isset($category_id)) {
            $category = $this->category->findById($category_id);

            if (is_null($category)) {
                $this->hasError = true;
                $this->error["category_id"] = "There is no category with the id: $category_id";
            }
        }

        $this->category_id = $category_id ?? null;

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
