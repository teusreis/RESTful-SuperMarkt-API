<?php

namespace App\Services;

use App\Model\Product;
use App\Auth\AuthController;


class ProductServices
{
    private Product $product;

    public function __construct()
    {
        header("content-type: application/json");
        AuthController::checkAuth();

        $this->product = new Product();
    }

    public function find($data)
    {
        $product = $this->getProduct($data["id"]);

        $response = [
            "status" => "success",
            "body" => $product->data
        ];

        echo json_encode($response);
    }

    public function findByName($data): void
    {
        $name = "%" . $data["name"] . "%";
        $products = $this->product->find("name like :name", "name={$name}")->fetch(true);

        if (!is_null($products)) {
            $data = [];

            foreach ($products as $product) {
                $data[] = $product->data;
            }

            $response = [
                "status" => "success",
                "body" => $data
            ];
        } else {
            http_response_code(404);
            $response = [
                "status" => "Not Found",
            ];
        }

        echo json_encode($response);
    }

    public function create()
    {
        AuthController::isEmployee();

        $request = getRequestData();

        extract($request);

        $this->product->setName($name)
            ->setPrice($price)
            ->setQtd($qtd)
            ->setCategory_id($category_id);

        if ($this->product->save()) {
            http_response_code(201);
            $response = [
                "status" => "success",
                "procuctId" => $this->product->id,
                "body" => "Product create successfully"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $this->product->error
            ];
        }

        echo json_encode($response);
    }

    public function update($data)
    {
        AuthController::isEmployee();

        $product = $this->getProduct($data["id"]);
        $request = getRequestData();
        extract($request);

        $product->setName($name)
            ->setPrice($price)
            ->setQtd($qtd)
            ->setCategory_id($category_id);

        if ($product->save()) {
            http_response_code(201);
            $response = [
                "status" => "success",
                "procuctId" => $product->id,
                "body" => "Product updated successfully"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $product->error
            ];
        }

        echo json_encode($response);
    }

    public function updateName($data)
    {
        AuthController::isEmployee();

        $product = $this->getProduct($data["id"]);
        $request = getRequestData();
        extract($request);

        $product->setName($name);

        if ($product->save()) {
            http_response_code(201);
            $response = [
                "status" => "success",
                "procuctId" => $product->id,
                "body" => "Product's name updated successfully"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $product->error
            ];
        }

        echo json_encode($response);
    }

    public function updatePrice($data)
    {
        AuthController::isEmployee();

        $product = $this->getProduct($data["id"]);
        $request = getRequestData();
        extract($request);

        $product->setPrice($price);

        if ($product->save()) {
            http_response_code(201);
            $response = [
                "status" => "success",
                "procuctId" => $product->id,
                "body" => "Product's price updated successfully"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $product->error
            ];
        }

        echo json_encode($response);
    }

    public function updateQtd($data)
    {
        AuthController::isEmployee();

        $product = $this->getProduct($data["id"]);
        $request = getRequestData();
        extract($request);

        $product->setQtd($qtd);

        if ($product->save()) {
            http_response_code(201);
            $response = [
                "status" => "success",
                "procuctId" => $product->id,
                "body" => "Product's quantity updated successfully"
            ];
        } else {
            http_response_code(400);
            $response = [
                "status" => "error",
                "body" => $product->error
            ];
        }

        echo json_encode($response);
    }

    public function delete($data)
    {
        AuthController::isEmployee();

        $product = $this->getProduct($data["id"]);

        if ($product->destroy()) {
            $response = [
                "status" => "success",
                "body" => "Product deleted successfully!"
            ];
        };

        echo json_encode($response);
    }

    private function getProduct($id): Product
    {
        $product = $this->product->findById($id);

        if (is_null($product)) {
            http_response_code(404);

            $response = [
                "status" => "Not Found!",
                "body" => "No product found with the id: {$id}"
            ];

            echo json_encode($response);
            die();
        } else {
            return $product;
        }
    }
}